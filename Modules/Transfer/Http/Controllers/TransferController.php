<?php

namespace Modules\Transfer\Http\Controllers;

use Exception;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Setting\Entities\Warehouse;
use Modules\Transfer\Entities\Transfer;
use App\Http\Controllers\BaseController;
use Modules\Product\Entities\WarehouseProduct;
use Modules\Transfer\Http\Requests\TransferFormRequest;

class TransferController extends BaseController
{
    private const CHALAN_NO = 1001;
    public function __construct(Transfer $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {
        if(permission('transfer-access')){
            $this->setPageData('Manage Transfer','Manage Transfer','fas fa-share-square',[['name' => 'Manage Transfer']]);
            $warehouses = Warehouse::where('status',1)->pluck('name','id');
            return view('transfer::index',compact('warehouses'));
        }else{
            return $this->access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('transfer-access')){

                if (!empty($request->chalan_no)) {
                    $this->model->setChalanNo($request->chalan_no);
                }
                if (!empty($request->start_date)) {
                    $this->model->setFromDate($request->start_date);
                }
                if (!empty($request->end_date)) {
                    $this->model->setToDate($request->end_date);
                }
                if (!empty($request->from_warehouse_id)) {
                    $this->model->setFromWarehouseID($request->from_warehouse_id);
                }
                if (!empty($request->to_warehouse_id)) {
                    $this->model->setToWarehouseID($request->to_warehouse_id);
                }

                $this->set_datatable_default_properties($request);//set datatable default properties
                $list = $this->model->getDatatableList();//get table data
                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';
                    if(permission('transfer-edit')){
                        $action .= ' <a class="dropdown-item" href="'.route("transfer.edit",$value->id).'">'.self::ACTION_BUTTON['Edit'].'</a>';
                    }
                    if(permission('transfer-view')){
                        $action .= ' <a class="dropdown-item view_data" href="'.route("transfer.show",$value->id).'">'.self::ACTION_BUTTON['View'].'</a>';
                    }
                    if(permission('transfer-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->chalan_no . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                    }
                    
                    $row = [];
                    if(permission('transfer-bulk-delete')){
                        $row[] = row_checkbox($value->id);//custom helper function to show the table each row checkbox
                    }
                    $row[] = $no;
                    $row[] = $value->chalan_no;
                    $row[] = $value->from_warehouse->name;
                    $row[] = $value->to_warehouse->name;
                    $row[] = $value->item.'('.$value->total_qty.')';
                    $row[] = number_format($value->total_price,2);
                    $row[] = $value->total_labor_cost ? number_format($value->total_labor_cost,2) : 0;
                    $row[] = $value->shipping_cost ? number_format($value->shipping_cost,2) : 0;
                    $row[] = number_format($value->grand_total,2);
                    $row[] = date(config('settings.date_format'),strtotime($value->transfer_date));
                    $row[] = action_button($action);//custom helper function for action button
                    $data[] = $row;
                }
                return $this->datatable_draw($request->input('draw'),$this->model->count_all(),
                $this->model->count_filtered(), $data);
            }
        }else{
            return response()->json($this->unauthorized());
        }
    }

    public function create()
    {
        if(permission('transfer-add')){
            $this->setPageData('Add Transfer','Add Transfer','fas fa-share-square',[['name' => 'Add Transfer']]);
            $transfer = $this->model->select('chalan_no')->orderBy('chalan_no','desc')->first();
            $data = [
                'warehouses'   => DB::table('warehouses')->where('status', 1)->pluck('name','id'),
                'chalan_no'  => 'TINV-'.($transfer ? explode('TINV-',$transfer->chalan_no)[1] + 1 : self::CHALAN_NO)
            ];
            return view('transfer::create',$data);
        }else{
            return $this->access_blocked();
        }
    }

    public function store(TransferFormRequest $request)
    {
        if($request->ajax()){
            if(permission('transfer-add')){
                // dd($request->all());
                DB::beginTransaction();
                try {
                    $transfer_data = [
                        'chalan_no'         => $request->chalan_no,
                        'from_warehouse_id' => $request->from_warehouse_id,
                        'to_warehouse_id'   => $request->to_warehouse_id,
                        'item'              => $request->item,
                        'total_qty'         => $request->total_qty,
                        'total_tax'         => $request->total_tax,
                        'total_price'        => $request->total_price,
                        'shipping_cost'     => $request->shipping_cost ? $request->shipping_cost : 0,
                        'total_labor_cost'  => $request->labor_cost ? $request->labor_cost : 0,
                        'grand_total'       => $request->grand_total,
                        'note'              => $request->note,
                        'transfer_date'     => $request->transfer_date,
                        'carried_by'        => $request->carried_by,
                        'received_by'       => $request->received_by,
                        'created_by'        => auth()->user()->name
                    ];
                    $products = [];
                    if($request->has('products'))
                    {
                        foreach ($request->products as $key => $value) {
                            $unit = Unit::where('unit_name',$value['unit'])->first();

                            $products[$value['id']] = [
                                'qty'              => $value['qty'],
                                'unit_id'          => $unit ? $unit->id : null,
                                'price'    => $value['net_unit_price'],
                                'tax_rate'         => $value['tax_rate'],
                                'tax'              => $value['tax'],
                                'total'            => $value['subtotal']
                            ];

                            //Minus Finish Goods Qty From Warehosue
                            $from_warehouse_products = WarehouseProduct::where(['warehouse_id'=>$request->from_warehouse_id,'product_id'=>$value['id']])->first();
                            if($from_warehouse_products){
                                $from_warehouse_products->qty -= $value['qty'];
                                $from_warehouse_products->update();
                            }
                        

                            //Add Finish Goods Qty To Warehosue
                            $to_warehouse_products = WarehouseProduct::where(['warehouse_id'=>$request->to_warehouse_id,'product_id'=>$value['id']])->first();
                            if($to_warehouse_products){
                                $to_warehouse_products->qty += $value['qty'];
                                $to_warehouse_products->update();
                            }else{
                                WarehouseProduct::create([
                                    'warehouse_id'    => $request->to_warehouse_id,
                                    'product_id'      => $value['id'],
                                    'qty'             => $value['qty']
                                ]);
                            }
                            

                        }
                    }
                    $result  = $this->model->create($transfer_data);
                    $transfer = $this->model->with('transfer_products')->find($result->id);
                    $transfer->transfer_products()->sync($products);
                    $output  = $this->store_message($result, null);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $output = ['status' => 'error','message' => $e->getMessage()];
                }
            }else{
                $output       = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }
}
