<?php

namespace Modules\Production\Http\Controllers;

use Exception;
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
            $this->setPageData('Manage Production Order Sheet','Manage Production Order Sheet','fas fa-file',[['name' => 'Manage Production Order Sheet']]);
            return view('production::order-sheet.index');
        }else{
            return $this->access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('production-order-sheet-access')){

                if (!empty($request->sheet_no)) {
                    $this->model->setSheetNo($request->sheet_no);
                }
                if (!empty($request->start_date)) {
                    $this->model->setFromDate($request->start_date);
                }
                if (!empty($request->end_date)) {
                    $this->model->setToDate($request->end_date);
                }
                if (!empty($request->delivery_status)) {
                    $this->model->setDeliveryStatus($request->delivery_status);
                }


                $this->set_datatable_default_properties($request);//set datatable default properties
                $list = $this->model->getDatatableList();//get table data
                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';


                    $action .= ' <a class="dropdown-item" href="'.route("production.order.sheet.view",$value->id).'">'.self::ACTION_BUTTON['View'].'</a>';
                    $action .= ' <a class="dropdown-item" href="'.route("production.order.challan",$value->id).'"><i class="fas fa-file-export text-primary mr-2"></i> Order Challan</a>';
                    
                    if(permission('production-order-sheet-delete') &&  (auth()->user()->role_id == 2 || auth()->user()->role_id == 1)){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->sheet_no . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                    }

                    $row = [];
                    $row[] = $no;
                    $row[] = $value->sheet_no;
                    $row[] = $value->item;
                    $row[] = $value->total_qty;
                    $row[] = number_format($value->total_order_value,2,'.',',');
                    $row[] = number_format($value->total_commission,2,'.',',');
                    $row[] = date('d-M-Y',strtotime($value->order_date));
                    $row[] = date('d-M-Y',strtotime($value->delivery_date));
                    $row[] = DELIVERY_STATUS[$value->delivery_status];
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
            ->join('units as bu','sp.base_unit_id','=','bu.id')
            ->join('units as u','p.unit_id','=','u.id')
            ->selectRaw('p.id,p.name,bu.unit_name as sale_unit,u.unit_name as ctn_size,(SUM(sp.qty) + ifnull(SUM(sp.free_qty),0)) as ordered_qty,sum(sp.total) as total_order_value,p.base_unit_qty as stock_qty')
            ->groupBy('sp.product_id')
            ->whereDate('s.sale_date',date('Y-m-d'))
            ->orderBy('p.id','asc')
            ->get();

            // dd($products);
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
                    'sheet_no'          => $request->sheet_no,
                    'order_date'        => $request->order_date,
                    'delivery_date'     => $request->order_date,
                    'item'              => $request->item,
                    'total_qty'         => $request->total_qty,
                    'total_order_value' => $request->total_order_value,
                    'total_commission'  => $request->total_commission,
                    'created_by'        => auth()->user()->name
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
            $order_sheet = $this->model->with(['products'])->find($id);
            return view('production::order-sheet.details',compact('order_sheet'));
        }else{
            return $this->access_blocked(); 
        }
    }


    public function delete(Request $request)
    {
        if($request->ajax()){
            if(permission('production-order-sheet-delete'))
            {
                DB::beginTransaction();
                try {
    
                    $orderSheetData = $this->model->with('products','memos')->find($request->id);
    
                    if(!$orderSheetData->products->isEmpty() && $orderSheetData->delivery_status == 2)
                    {
                        $orderSheetData->products()->detach();
                    }
                    if(!$orderSheetData->memos->isEmpty() && $orderSheetData->delivery_status == 2)
                    {
                        $orderSheetData->memos()->detach();
                    }
                    $result = $orderSheetData->delete();
                    if($result)
                    {
                        $output = ['status' => 'success','message' => 'Data has been deleted successfully'];
                    }else{
                        $output = ['status' => 'error','message' => 'Failed to delete data'];
                    }
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $output = ['status' => 'error','message' => $e->getMessage()];
                }
                return response()->json($output);
            }else{
                return response()->json($this->unauthorized());
            }
        }else{
            return response()->json($this->unauthorized());
        }
    }
}
