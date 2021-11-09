<?php

namespace Modules\Production\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Modules\Production\Entities\OrderSheet;

class ProductionOrderSheetController extends BaseController
{

    public function __construct(OrderSheet $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('production-order-sheet-access')){
            $this->setPageData('Manage Production','Manage Production','fas fa-industry',[['name' => 'Manage Production']]);
            return view('production::order-sheet.index');
        }else{
            return $this->access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('production-access')){

                if (!empty($request->batch_no)) {
                    $this->model->setBatchNo($request->batch_no);
                }
                if (!empty($request->start_date)) {
                    $this->model->setStartDate($request->start_date);
                }
                if (!empty($request->end_date)) {
                    $this->model->setEndDate($request->end_date);
                }
                if (!empty($request->warehouse_id)) {
                    $this->model->setWarehouseID($request->warehouse_id);
                }
                if (!empty($request->status)) {
                    $this->model->setStatus($request->status);
                }
                if (!empty($request->production_status)) {
                    $this->model->setProductionStatus($request->production_status);
                }
                if (!empty($request->transfer_status)) {
                    $this->model->setTransferStatus($request->transfer_status);
                }

                $this->set_datatable_default_properties($request);//set datatable default properties
                $list = $this->model->getDatatableList();//get table data
                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';
                    if(permission('production-approve')  && $value->status == 2){
                        $action .= ' <a class="dropdown-item change_status"  data-id="' . $value->id . '" data-name="' . $value->batch_no . '" data-status="' . $value->status . '"><i class="fas fa-toggle-on text-info mr-2"></i> Approve Status</a>';
                    }
                    if(permission('production-edit') && $value->status == 2){
                        $action .= ' <a class="dropdown-item" href="'.route("production.edit",$value->id).'">'.self::ACTION_BUTTON['Edit'].'</a>';
                    }
                    if(permission('production-operation') && $value->status == 1 && $value->production_status != 3 ){
                        $action .= ' <a class="dropdown-item" href="'.url("production/operation/".$value->id).'"><i class="fas fa-toolbox text-success mr-2"></i> Operation</a>';
                    }
                    if(permission('production-view')){
                        $action .= ' <a class="dropdown-item" href="'.url("production/view/".$value->id).'">'.self::ACTION_BUTTON['View'].'</a>';
                    }
                    if(permission('production-delete') && $value->production_status != 3 && $value->transfer_status == 1){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                    }

                    // if(permission('production-transfer') && $value->status == 1 && $value->production_status == 3 && $value->transfer_status == 1){
                    //     $action .= ' <a class="dropdown-item" href="'.url("production/transfer/".$value->id).'"><i class="fas fa-dolly-flatbed text-dark mr-2"></i> Transfer</a>';
                    // }

                    $row = [];
                    $row[] = $no;
                    $row[] = $value->batch_no;
                    $row[] = $value->warehouse->name;
                    $row[] = date('d-M-Y',strtotime($value->start_date));
                    $row[] = $value->end_date ? date('j-F-Y',strtotime($value->end_date)) : '-';
                    $row[] = $value->item;
                    $row[] = APPROVE_STATUS_LABEL[$value->status];
                    $row[] = PRODUCTION_STATUS_LABEL[$value->production_status];
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
        if(permission('todays-production-order-sheet-access')){
            $this->setPageData('Today\'s Production Order Sheet','Today\'s Production Order Sheet','fas fa-file',[['name' => 'Today\'s Production Order Sheet']]);
            return view('production::order-sheet.create');
        }else{
            return $this->access_blocked(); 
        }
    }

    public function generate_production_order_sheet()
    {
        $sheet_no = date('ymd');
        if(DB::table('order_sheets')->where('sheet_no', $sheet_no)->exists())
        {
            return 'exist';
        }else{
            $products = DB::table('sale_products as sp')
            ->join('sales as s','sp.sale_id','=','s.id')
            ->join('products as p','sp.product_id','=','p.id')
            ->leftJoin('warehouse_product as wp','p.id','=','wp.product_id')
            ->join('units as bu','sp.sale_unit_id','=','bu.id')
            ->join('units as u','p.unit_id','=','u.id')
            ->selectRaw('p.id,p.name,bu.unit_name as sale_unit,u.unit_name as ctn_size,SUM(sp.qty) as ordered_qty,sp.net_unit_price as price,SUM(wp.qty) as stock_qty')
            ->groupBy('sp.product_id')
            ->whereDate('s.sale_date',date('Y-m-d'))
            ->orderBy('p.id','asc')
            ->get();
            $sales = DB::table('sales')->whereDate('sale_date',date('Y-m-d'));
            $total_commission = $sales->sum('total_commission');
            $sale_list = $sales->get();
            return view('production::order-sheet.products',compact('sheet_no','products','total_commission','sale_list'))->render();

        }

    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            DB::beginTransaction();
            try {
                $order_sheet = $this->model->create([
                    'sheet_no' => $request->sheet_no, 
                    'order_date' => $request->order_date, 
                    'item' => $request->item, 
                    'total_qty' => $request->total_qty, 
                    'total' => $request->total, 
                    'total_commission' => $request->total_commission
                ]);
                if($order_sheet)
                {
                    $orderSheetData = $this->model->with(['products','memos'])->find($order_sheet->id);
                    if($request->has('products'))
                    {
                        $products = [];
                        foreach ($request->products as $key => $value) {
                            $products[$value['id']] = [
                                'stock_qty'    => $value['stock_qty'],
                                'ordered_qty'  => $value['ordered_qty'],
                                'required_qty' => $value['required_qty'],
                                'price'        => $value['price'],
                                'total'        => $value['total']
                            ];
                        }
                        $orderSheetData->products()->sync($products);

                    }
                    if($request->has('memos'))
                    {
                        $memos = [];
                        foreach ($request->memos as $key => $value) {
                            array_push($memos,$value['sale_id']);
                        }
                        $orderSheetData->memos()->sync($memos);
                    }
                    $output = ['status'=>'success','message'=> 'Product Order Sheet Data has Been Saved Successfully','sheet_id' => $order_sheet->id];
                }else{
                    $output = ['status'=>'error','message'=> 'Failed To Save Product Order Sheet Data!'];
                }
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                $output = ['status'=>'error','message'=>$th->getMessage()];
            }
            return response()->json($output);
        }
    }


    public function show(int $id)
    {
        if(permission('production-order-sheet-view')){
            $this->setPageData('Production Order Sheet Details','Production Order Sheet Details','fas fa-file',[['name' => 'Production Order Sheet Details']]);
            $order_sheet = $this->model->with(['products','memos'])->find($id);
            return view('production::order-sheet.details',compact('order_sheet'));
        }else{
            return $this->access_blocked(); 
        }
    }


    public function destroy($id)
    {
        //
    }
}
