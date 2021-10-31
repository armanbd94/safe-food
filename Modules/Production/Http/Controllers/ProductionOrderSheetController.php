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
            return view('production::order-sheed.index');
        }else{
            return $this->access_blocked();
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
