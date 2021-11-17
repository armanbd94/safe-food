<?php

namespace Modules\StockReturn\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Modules\Depo\Entities\Depo;
use Modules\Sale\Entities\Sale;
use Illuminate\Support\Facades\DB;
use Modules\Dealer\Entities\Dealer;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\Product;
use Modules\Customer\Entities\Customer;
use Modules\SalesMen\Entities\Salesmen;
use App\Http\Controllers\BaseController;
use Modules\Account\Entities\Transaction;
use Modules\Product\Entities\ProductVariant;
use Modules\StockReturn\Entities\SaleReturn;
use Modules\Product\Entities\WarehouseProduct;
use Modules\StockReturn\Entities\SaleReturnProduct;
use Modules\StockReturn\Http\Requests\SaleReturnRequest;

class SaleReturnController extends BaseController
{
    public function __construct(SaleReturn $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {
        if(permission('sale-return-access')){
            $this->setPageData('Sale Return','Sale Return','fas fa-file',[['name' => 'Sale Return']]);

            return view('stockreturn::sale.index');
        }else{
            return $this->access_blocked();
        }

    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('sale-return-access')){

                if (!empty($request->return_no)) {
                    $this->model->setReturnNo($request->return_no);
                }
                if (!empty($request->memo_no)) {
                    $this->model->setMemoNo($request->memo_no);
                }
                if (!empty($request->start_date)) {
                    $this->model->setStartDate($request->start_date);
                }
                if (!empty($request->end_date)) {
                    $this->model->setEndDate($request->end_date);
                }

                $this->set_datatable_default_properties($request);//set datatable default properties
                $list = $this->model->getDatatableList();//get table data
                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';
                    $action .= ' <a class="dropdown-item view_data" href="'.route("sale.return.show",$value->id).'">'.self::ACTION_BUTTON['View'].'</a>';
                    $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->return_no . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                    $row = [];
                    $row[] = $no;
                    $row[] = $value->return_no;
                    $row[] = $value->sale->memo_no;
                    $row[] = $value->sale->dealer->name;
                    $row[] = $value->sale->depo->name;
                    $row[] = $value->item;
                    $row[] = $value->total_qty;
                    $row[] = number_format($value->total_price,2,'.','');
                    $row[] = number_format($value->total_deduction,2,'.','');
                    $row[] = number_format($value->grand_total,2,'.','');
                    $row[] = date('d-M-Y',strtotime($value->return_date));
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

    public function store(SaleReturnRequest $request)
    {
        if($request->ajax()){
            if(permission('sale-return-access')){
                // dd($request->all());
                DB::beginTransaction();
                try {
                    $sale_return  = $this->model->create([
                        'return_no'       => 'SRINV-'.date('ymd').rand(1,999),
                        'sale_id'         => $request->sale_id,
                        'item'            => $request->item,
                        'total_qty'       => $request->total_qty,
                        'total_price'     => $request->total_price,
                        'total_deduction' => $request->total_deduction ? $request->total_deduction : 0,
                        'grand_total'     => $request->grand_total,
                        'reason'          => $request->reason,
                        'return_date'     => $request->return_date,
                        'created_by'      => Auth::user()->name
                    ]);
                    //purchase products
                    $products = [];
                    if($request->has('products'))
                    {
                        foreach ($request->products as $key => $value) {

                                $products[] = [
                                    'sale_return_id'     => $sale_return->id,
                                    'product_id'         => $value['id'],
                                    'return_qty'         => $value['return_qty'],
                                    'base_unit_id'       => $value['base_unit_id'],
                                    'product_rate'       => $value['net_unit_price'],
                                    'deduction_rate'     => $value['deduction_rate'] ? $value['deduction_rate'] : 0,
                                    'deduction_amount'   => $value['deduction_amount'] ? $value['deduction_amount'] : 0,
                                    'total'              => $value['subtotal']
                                ];

                                // $product = Product::find($value['id']);
                                // if($product){
                                //     $product->base_unit_qty += $value['return_qty'];
                                //     $product->update();
                                // }

                                // $warehouse_product = WarehouseProduct::where([
                                //     'warehouse_id'=> 1,
                                //     'product_id'  => $value['id'],
                                //     ])->first();
                                // if($warehouse_product){
                                //     $warehouse_product->qty += $value['return_qty'];
                                //     $warehouse_product->update();
                                // }
                               
                            
                        }
                        if(count($products) > 0)
                        {
                            SaleReturnProduct::insert($products);
                        }
                    }
                    if($request->order_from == 1){
                        $depo  = Depo::with('coa')->find($request->depo_id);
                    }elseif ($request->order_from == 2) {
                        $dealer  = Dealer::with('coa')->find($request->dealer_id);
                    }

                    $customer_credit = array(
                        'chart_of_account_id' => $request->order_from == 1 ? $depo->coa->id : $dealer->coa->id,
                        'warehouse_id'        => 1,
                        'voucher_no'          => $request->memo_no,
                        'voucher_type'        => 'SALE RETURN',
                        'voucher_date'        => $request->return_date,
                        'description'         => 'Credit amount '.$request->grand_total.'Tk for product damage Memo No. :- ' . $request->memo_no,
                        'debit'               => 0,
                        'credit'              => $request->grand_total,
                        'posted'              => 1,
                        'approve'             => 1,
                        'created_by'          => auth()->user()->name,
                        'created_at'          => date('Y-m-d H:i:s')
                    );
                    Transaction::create($customer_credit);                   

  
                    $output  = $this->store_message($sale_return, null);
                    DB::commit();
                } catch (\Exception $e) {
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

    public function show(int $id)
    {
        if(permission('sale-return-access')){
            $this->setPageData('Sale Return Details','Sale Return Details','fas fa-file',[['name' => 'Sale Return Details']]);
            $sale_return = $this->model->with('return_products','sale')->find($id);
            if($sale_return)
            {
                return view('stockreturn::sale.details',compact('sale_return'));
            }else{
                return redirect('sale.return')->with('error','No Data Available');
            }
        }else{
            return $this->access_blocked();
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            if(permission('sale-return-access'))
            {
                DB::beginTransaction();
                try {
    
                    $saleReturnData = $this->model->with('sale','return_products')->find($request->id);
                    
                    if(!$saleReturnData->return_products->isEmpty())
                    {
                        
                        // foreach ($saleReturnData->return_products as  $return_product) {
                        //     $return_qty = $return_product->return_qty;
                        //     $product = Product::find($return_product->product_id);
                        //     if($product){
                        //         $product->base_unit_qty -= $return_qty;
                        //         $product->update();
                        //     }
                        //     $warehouse_product = WarehouseProduct::where([
                        //         'warehouse_id' => $saleReturnData->sale->warehouse_id,
                        //         'product_id'   => $return_product->product_id,
                        //         ])->first();
                        //     if($warehouse_product){
                        //         $warehouse_product->qty -= $return_qty;
                        //         $warehouse_product->update();
                        //     }
                        // }
                        $saleReturnData->return_products()->delete();
                    }
                    Transaction::where(['voucher_no'=>$saleReturnData->sale->memo_no,'voucher_type'=>'SALE RETURN'])->delete();
    
                    $result = $saleReturnData->delete();
                    if($result)
                    {
                        $output = ['status' => 'success','message' => 'Data has been deleted successfully'];
                    }else{
                        $output = ['status' => 'error','message' => 'Failed to delete data'];
                    }
                    DB::commit();
                } catch (\Exception $e) {
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
