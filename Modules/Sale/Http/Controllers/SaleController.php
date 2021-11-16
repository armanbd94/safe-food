<?php

namespace Modules\Sale\Http\Controllers;

use Exception;
use App\Models\Unit;
use Illuminate\Http\Request;
use Modules\Sale\Entities\Sale;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;
use Modules\Sale\Entities\SaleProduct;
use App\Http\Controllers\BaseController;
use Modules\Account\Entities\Transaction;
use Modules\Dealer\Entities\Dealer;
use Modules\Depo\Entities\Depo;
use Modules\Sale\Http\Requests\SaleFormRequest;


class SaleController extends BaseController
{
    public function __construct(Sale $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {
        if(permission('sale-access')){
            $this->setPageData('Sale Manage','Sale Manage','fab fa-opencart',[['name' => 'Sale Manage']]);
            $data = [
                'locations'   => DB::table('locations')->where('status', 1)->get(),
                'depos'     => DB::table('depos as d')->leftJoin('locations as a','d.area_id','=','a.id')->select('d.*','a.name as area_name')->get(),
                'dealers'   => DB::table('dealers as d')->leftJoin('locations as a','d.area_id','=','a.id')->select('d.*','a.name as area_name')->get(),
            ];
            return view('sale::index',$data);
        }else{
            return $this->access_blocked();
        }

    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('sale-access')){
                if (!empty($request->memo_no)) {
                    $this->model->setMemoNo($request->memo_no);
                }
                if (!empty($request->start_date)) {
                    $this->model->setFromDate($request->start_date);
                }
                if (!empty($request->end_date)) {
                    $this->model->setToDate($request->end_date);
                }
                if (!empty($request->depo_id)) {
                    $this->model->setDepoID($request->depo_id);
                }
                if (!empty($request->dealer_id)) {
                    $this->model->setDealerID($request->dealer_id);
                }
                if (!empty($request->area_id)) {
                    $this->model->setAreaID($request->area_id);
                }
                if (!empty($request->district_id)) {
                    $this->model->setDistrictID($request->district_id);
                }
                if (!empty($request->upazila_id)) {
                    $this->model->setUpazilaID($request->upazila_id);
                }


                $this->set_datatable_default_properties($request);//set datatable default properties
                $list = $this->model->getDatatableList();//get table data
                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';
                    if (permission('sale-edit') && $value->delivery_status == 2) {
                        $action .= ' <a class="dropdown-item" href="'.route("sale.edit",$value->id).'">'.self::ACTION_BUTTON['Edit'].'</a>';
                    }
                    if (permission('sale-view')) {
                        $action .= ' <a class="dropdown-item view_data" href="'.route("sale.show",$value->id).'">'.self::ACTION_BUTTON['View'].'</a>';
                    }

                    if (permission('sale-delete') && $value->delivery_status == 2) {
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->memo_no . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                    }

                    $row = [];
                    if(permission('sale-bulk-delete')){
                        $row[] = row_checkbox($value->id);//custom helper function to show the table each row checkbox
                    }

                    $row[] = $no;
                    $row[] = $value->memo_no;
                    $row[] = ORDER_FROM_STATUS_LABEL[$value->order_from];
                    $row[] = $value->dealer_name;
                    $row[] = $value->depo_name;
                    $row[] = $value->area_name;
                    $row[] = $value->upazila_name;
                    $row[] = $value->district_name;
                    $row[] = $value->item.'('.$value->total_qty+($value->total_free_qty ?? 0).')';
                    $row[] = number_format($value->grand_total,2,'.','');
                    $row[] = number_format($value->commission_rate,2,'.','');
                    $row[] = number_format($value->total_commission,2,'.','');
                    $row[] = number_format($value->net_total,2,'.','');
                    $row[] = date('d-M-Y',strtotime($value->sale_date));
                    $row[] = $value->delivery_date ? date('d-M-Y',strtotime($value->delivery_date)) : '';
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
        if(permission('sale-add')){
            $this->setPageData('Add Sale','Add Sale','fas fa-shopping-cart',[['name' => 'Add Sale']]);
            $data = [
                'products'  => Product::with(['base_unit','unit','product_prices'])->get(),
                'dealers'   => DB::table('dealers as de')
                ->leftJoin('locations as d','de.district_id','=','d.id')
                ->leftJoin('locations as a','de.area_id','=','a.id')
                ->leftJoin('depos as dp','de.depo_id','=','dp.id')
                ->select('de.*','d.name as district_name','a.name as area_name','dp.commission_rate as depo_commission_rate')
                ->get(),
                'memo_no'   => 'SINV-'.date('ymd').rand(1,999),
            ];
            return view('sale::create',$data);
        }else{
            return $this->access_blocked();
        }
    }

    public function store(SaleFormRequest $request)
    {
        if($request->ajax()){
            if(permission('sale-add')){
                // dd($request->all());
                DB::beginTransaction();
                try {

                    $warehouse_id = 1;
                    $sale_data = [
                        'memo_no'            => $request->memo_no,
                        'warehouse_id'       => $warehouse_id,
                        'order_from'         => $request->order_from,
                        'item'               => $request->item,
                        'total_unit_qty'     => $request->total_unit_qty,
                        'total_qty'          => $request->total_qty,
                        'total_free_qty'     => $request->total_free_qty,
                        'grand_total'        => $request->grand_total,
                        'commission_rate'    => $request->commission_rate,
                        'total_commission'   => $request->total_commission,
                        'net_total'          => $request->net_total,
                        'sale_date'          => $request->sale_date,
                        'delivery_date'      => $request->delivery_date,
                        'created_by'         => auth()->user()->name
                    ];

                    if($request->order_from == 1){
                        $depo  = Depo::with('coa')->find($request->depo_id);
                        $dealer = Dealer::find($request->depo_dealer_id);
                        $sale_data['depo_id']    = $request->depo_id;
                        $sale_data['dealer_id']    = $request->depo_dealer_id;
                    }elseif ($request->order_from == 2) {
                        $dealer  = Dealer::with('coa')->find($request->direct_dealer_id);
                        $sale_data['dealer_id']    = $request->direct_dealer_id;
                    }
                    $sale_data['district_id']    = $dealer->district_id;
                    $sale_data['upazila_id']     = $dealer->upazila_id;
                    $sale_data['area_id' ]       = $dealer->area_id;

                    $sale  = $this->model->create($sale_data);

                    $saleData = $this->model->with('sale_products')->find($sale->id);

                    $products = [];
                    $direct_cost = [];
                    if($request->has('products'))
                    {
                        foreach ($request->products as $key => $value) {
                            $products[$value['id']] = [
                                'unit_qty'       => $value['unit_qty'],
                                'qty'            => $value['qty'],
                                'free_qty'       => $value['free_qty'],
                                'base_unit_id'   => $value['base_unit_id'],
                                'unit_id'        => $value['unit_id'],
                                'net_unit_price' => $value['net_unit_price'],
                                'total'          => $value['subtotal']
                            ];
                            
                            $product = DB::table('products')
                            ->where('id',$value['id'])
                            ->first();
                            if($product){
                                $direct_cost[] = $value['qty'] * ($product ? $product->cost : 0);
                            }
                        }
                        if(count($products) > 0)
                        {
                            $saleData->sale_products()->sync($products);
                        }
                    }
                    $sum_direct_cost = array_sum($direct_cost);

  
                    Transaction::insert($this->sale_transaction_data($request->memo_no,$request->net_total,
                    $sum_direct_cost,$saleData->order_from == 1 ? $depo->coa->id : $dealer->coa->id,
                    $saleData->order_from == 1 ? $depo->name : $dealer->name,$request->sale_date,$warehouse_id));
                    if($sale)
                    {
                        $output = ['status'=>'success','message'=>'Data has been saved successfully','sale_id'=>$sale->id];
                    }else{
                        $output = ['status'=>'error','message'=>'Failed to save data!','sale_id'=>''];
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

 
    private function sale_transaction_data($invoice_no, $grand_total, $sum_direct_cost, int $coa_id, string $name, $sale_date, int $warehouse_id) {

        //Inventory Credit
        $coscr = array(
            'chart_of_account_id' => DB::table('chart_of_accounts')->where('code', $this->coa_head_code('inventory'))->value('id'),
            'warehouse_id'        => $warehouse_id,
            'voucher_no'          => $invoice_no,
            'voucher_type'        => 'INVOICE',
            'voucher_date'        => $sale_date,
            'description'         => 'Inventory credit for Memo No. - '.$invoice_no,
            'debit'               => 0,
            'credit'              => $sum_direct_cost,
            'posted'              => 1,
            'approve'             => 1,
            'created_by'          => auth()->user()->name,
            'created_at'          => date('Y-m-d H:i:s')
        ); 

        // customer Debit
        $sale_coa_transaction = array(
            'chart_of_account_id' => $coa_id,
            'warehouse_id'        => $warehouse_id,
            'voucher_no'          => $invoice_no,
            'voucher_type'        => 'INVOICE',
            'voucher_date'        => $sale_date,
            'description'         => 'Debit amount '.$grand_total.'Tk for sale Memo No. -  ' . $invoice_no . ' from ' .$name,
            'debit'               => $grand_total,
            'credit'              => 0,
            'posted'              => 1,
            'approve'             => 1,
            'created_by'          => auth()->user()->name,
            'created_at'          => date('Y-m-d H:i:s')
        );

        $product_sale_income = array(
            'chart_of_account_id' => DB::table('chart_of_accounts')->where('code', $this->coa_head_code('product_sale'))->value('id'),
            'warehouse_id'        => $warehouse_id,
            'voucher_no'          => $invoice_no,
            'voucher_type'        => 'INVOICE',
            'voucher_date'        => $sale_date,
            'description'         => 'Sale income for Memo No. - ' . $invoice_no . ' from ' .$name,
            'debit'               => 0,
            'credit'              => $grand_total,
            'posted'              => 1,
            'approve'             => 1,
            'created_by'          => auth()->user()->name,
            'created_at'          => date('Y-m-d H:i:s')
        ); 

        return [
            $coscr, $sale_coa_transaction, $product_sale_income
        ];


    }


    public function show(int $id)
    {
        if(permission('sale-view')){
            $this->setPageData('Sale Details','Sale Details','fas fa-file',[['name'=>'Sale','link' => route('sale')],['name' => 'Sale Details']]);
            $sale = $this->model->with('sale_products','dealer','district','upazila','area')->find($id);
            return view('sale::details',compact('sale'));
        }else{
            return $this->access_blocked();
        }
    }
    public function edit(int $id)
    {
        if(permission('sale-edit')){
            $this->setPageData('Edit Sale','Edit Sale','fas fa-edit',[['name'=>'Sale','link' => route('sale')],['name' => 'Edit Sale']]);

            $data = [
                'products'  => Product::with(['base_unit','unit','product_prices'])->get(),
                'sale'      => $this->model->with('sale_products')->find($id),
                'dealers'   => DB::table('dealers as de')
                ->leftJoin('locations as d','de.district_id','=','d.id')
                ->leftJoin('locations as a','de.area_id','=','a.id')
                ->leftJoin('depos as dp','de.depo_id','=','dp.id')
                ->select('de.*','d.name as district_name','a.name as area_name','dp.commission_rate as depo_commission_rate')
                ->get(),
            ];
            // dd($data['sale']);
            return view('sale::edit',$data);
        }else{
            return $this->access_blocked();
        }

    }

    public function update(SaleFormRequest $request)
    {
        if($request->ajax()){
            if(permission('sale-edit')){
                // dd($request->all());
                DB::beginTransaction();
                try {
                    $saleData = $this->model->with('sale_products')->find($request->sale_id);
                    $warehouse_id = 1;
                    $sale_data = [
                        'memo_no'            => $request->memo_no,
                        'warehouse_id'       => $warehouse_id,
                        'order_from'         => $request->order_from,
                        'item'               => $request->item,
                        'total_unit_qty'     => $request->total_unit_qty,
                        'total_qty'          => $request->total_qty,
                        'total_free_qty'     => $request->total_free_qty,
                        'grand_total'        => $request->grand_total,
                        'commission_rate'    => $request->commission_rate,
                        'total_commission'   => $request->total_commission,
                        'net_total'          => $request->net_total,
                        'sale_date'          => $request->sale_date,
                        'delivery_date'      => $request->delivery_date,
                        'modified_by'         => auth()->user()->name
                    ];

                    if($request->order_from == 1){
                        $depo  = Depo::with('coa')->find($request->depo_id);
                        $dealer = Dealer::find($request->depo_dealer_id);
                        $sale_data['depo_id']    = $request->depo_id;
                        $sale_data['dealer_id']    = $request->depo_dealer_id;
                    }elseif ($request->order_from == 2) {
                        $dealer  = Dealer::with('coa')->find($request->direct_dealer_id);
                        $sale_data['dealer_id']    = $request->direct_dealer_id;
                    }
                    $sale_data['district_id']    = $dealer->district_id;
                    $sale_data['upazila_id']     = $dealer->upazila_id;
                    $sale_data['area_id' ]       = $dealer->area_id;

                    $products = [];
                    $direct_cost = [];
                    if($request->has('products'))
                    {
                        foreach ($request->products as $key => $value) {
                            $products[$value['id']] = [
                                'unit_qty'       => $value['unit_qty'],
                                'qty'            => $value['qty'],
                                'free_qty'       => $value['free_qty'],
                                'base_unit_id'   => $value['base_unit_id'],
                                'unit_id'        => $value['unit_id'],
                                'net_unit_price' => $value['net_unit_price'],
                                'total'          => $value['subtotal']
                            ];
                            
                            $product = DB::table('products')
                            ->where('id',$value['id'])
                            ->first();
                            if($product){
                                $direct_cost[] = $value['qty'] * ($product ? $product->cost : 0);
                            }
                        }
                        if(count($products) > 0)
                        {
                            $saleData->sale_products()->sync($products);
                        }
                    }
                    $sum_direct_cost = array_sum($direct_cost);

                    $sale  = $saleData->update($sale_data);
                    Transaction::where(['voucher_no'=>$request->memo_no,'voucher_type'=>'INVOICE'])->delete();
                    Transaction::insert($this->sale_transaction_data($request->memo_no,$request->net_total,
                    $sum_direct_cost,$saleData->order_from == 1 ? $depo->coa->id : $dealer->coa->id,
                    $saleData->order_from == 1 ? $depo->name : $dealer->name,$request->sale_date,$warehouse_id));
                    $output  = $this->store_message($sale, $request->sale_id);
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

    public function delete(Request $request)
    {
        if($request->ajax()){
            if(permission('sale-delete'))
            {
                DB::beginTransaction();
                try {
    
                    $saleData = $this->model->with('sale_products')->find($request->id);
    
                    if(!$saleData->sale_products->isEmpty() && $saleData->delivery_status == 2)
                    {
                        $saleData->sale_products()->detach();
                        
                    }
                    Transaction::where(['voucher_no'=>$saleData->memo_no,'voucher_type'=>'INVOICE'])->delete();
    
                    $result = $saleData->delete();
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

    public function bulk_delete(Request $request)
    {
        if($request->ajax()){
            if(permission('sale-bulk-delete'))
            {
                DB::beginTransaction();
                try {
                    foreach ($request->ids as $id) {
                        $saleData = $this->model->with('sale_products')->find($id);
        
                        if(!$saleData->sale_products->isEmpty() && $saleData->delivery_status == 2)
                        {
                            $saleData->sale_products()->detach(); 
                        }
                        Transaction::where(['voucher_no'=>$saleData->memo_no,'voucher_type'=>'INVOICE'])->delete();
        
                        $result = $saleData->delete();
                        if($result)
                        {
                            $output = ['status' => 'success','message' => 'Data has been deleted successfully'];
                        }else{
                            $output = ['status' => 'error','message' => 'Failed to delete data'];
                        }
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
