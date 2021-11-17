<?php

namespace Modules\DamageProduct\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Modules\Depo\Entities\Depo;
use Illuminate\Support\Facades\DB;
use Modules\Dealer\Entities\Dealer;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Modules\Account\Entities\Transaction;
use Modules\DamageProduct\Entities\Damage;
use Modules\DamageProduct\Entities\DamageProduct;
use Modules\DamageProduct\Http\Requests\DamageProductRequest;

class DamageProductController extends BaseController
{
    public function __construct(Damage $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {
        if(permission('damage-product-access')){
            $this->setPageData('Damage Product','Damage Product','fas fa-file',[['name' => 'Damage Product']]);
            return view('damageproduct::index');
        }else{
            return $this->access_blocked();
        }

    }
    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('damage-product-access')){

                if (!empty($request->damage_no)) {
                    $this->model->setDamageNo($request->damage_no);
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
                    $action .= ' <a class="dropdown-item view_data" href="'.route("damage.product.show",$value->id).'">'.self::ACTION_BUTTON['View'].'</a>';
                    $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->damage_no . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                    $row = [];
                    $row[] = $no;
                    $row[] = $value->damage_no;
                    $row[] = $value->sale->memo_no;
                    $row[] = $value->sale->dealer->name;
                    $row[] = $value->sale->depo->name;
                    $row[] = $value->item;
                    $row[] = $value->total_qty;
                    $row[] = number_format($value->grand_total,2,'.',',');
                    $row[] = date('d-M-Y',strtotime($value->damage_date));
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

    public function store(DamageProductRequest $request)
    {
        if($request->ajax()){
            if(permission('damage-product-add')){
                // dd($request->all());
                DB::beginTransaction();
                try {
                    $damage  = $this->model->create([
                        'damage_no'              => 'DINV-'.date('ymd').rand(1,999),
                        'sale_id'                => $request->sale_id,
                        'item'                   => $request->item,
                        'total_qty'              => $request->total_qty,
                        'grand_total'            => $request->grand_total,
                        'reason'                 => $request->reason,
                        'damage_date'            => $request->damage_date,
                        'created_by'             => Auth::user()->name
                    ]);
                    //purchase products
                    $products = [];
                    if($request->has('products'))
                    {
                        foreach ($request->products as $key => $value) {

                            $products[] = [
                                'damage_id'      => $damage->id,
                                'product_id'     => $value['id'],
                                'damage_qty'     => $value['damage_qty'],
                                'base_unit_id'   => $value['base_unit_id'],
                                'net_unit_price' => $value['net_unit_price'],
                                'total'          => $value['subtotal'],
                                'created_at'     => date('Y-m-d H:i:s')
                            ];  
                        }
                        if(count($products) > 0)
                        {
                            DamageProduct::insert($products);
                        }
                    }

                    if($request->order_from == 1){
                        $depo  = Depo::with('coa')->find($request->depo_id);
                    }elseif ($request->order_from == 2) {
                        $dealer  = Dealer::with('coa')->find($request->dealer_id);
                    }

                    $sale_credit = array(
                        'chart_of_account_id' => $request->order_from == 1 ? $depo->coa->id : $dealer->coa->id,
                        'warehouse_id'        => 1,
                        'voucher_no'          => $request->memo_no,
                        'voucher_type'        => 'PRODUCT DAMAGE',
                        'voucher_date'        => $request->damage_date,
                        'description'         => 'Credit amount '.$request->grand_total.'Tk for product damage Memo No. :- ' . $request->memo_no,
                        'debit'               => 0,
                        'credit'              => $request->grand_total,
                        'posted'              => 1,
                        'approve'             => 1,
                        'created_by'          => auth()->user()->name,
                        'created_at'          => date('Y-m-d H:i:s')
                    );
                    Transaction::create($sale_credit);           
                    $output  = $this->store_message($damage, null);
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
        if(permission('damage-product-view')){
            $this->setPageData('Damage Product Details','Damage Product Details','fas fa-file',[['name' => 'Damage Product Details']]);
            $damage = $this->model->with('damage_products','sale')->find($id);
            if($damage)
            {
                return view('damageproduct::details',compact('damage'));
            }else{
                return redirect('damage.product')->with('error','No Data Available');
            }
        }else{
            return $this->access_blocked();
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            if(permission('damage-product-delete'))
            {
                DB::beginTransaction();
                try {
    
                    $damageData = $this->model->with('sale','damage_products')->find($request->id);
                    
                    if(!$damageData->damage_products->isEmpty())
                    {
                        $damageData->damage_products()->detach();
                    }
                    Transaction::where(['voucher_no'=>$damageData->sale->memo_no,'voucher_type'=>'PRODUCT DAMAGE'])->delete();
    
                    $result = $damageData->delete();
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
