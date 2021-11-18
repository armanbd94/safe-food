<?php

namespace Modules\Purchase\Http\Controllers;

use DB;
use Exception;
use App\Models\Tax;
use App\Models\Unit;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Modules\Material\Entities\Material;
use Modules\Purchase\Entities\Purchase;
use Modules\Supplier\Entities\Supplier;
use App\Http\Controllers\BaseController;
use Modules\Account\Entities\Transaction;
use Modules\Purchase\Entities\PurchasePayment;
use Modules\Material\Entities\WarehouseMaterial;
use Modules\Purchase\Entities\MaterialPurchase;
use Modules\Purchase\Http\Requests\PurchaseFormRequest;


class PurchaseController extends BaseController
{
    use UploadAble;
    private const MEMO_NO = 1001;
    public function __construct(Purchase $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {
        if(permission('purchase-access')){
            $this->setPageData('Purchase Manage','Purchase Manage','fas fa-shopping-cart',[['name' => 'Purchase Manage']]);
            $suppliers = Supplier::all();
            
            return view('purchase::index',compact('suppliers'));
        }else{
            return $this->access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('purchase-access')){

                if (!empty($request->memo_no)) {
                    $this->model->setMemoNo($request->memo_no);
                }
                if (!empty($request->from_date)) {
                    $this->model->setFromDate($request->from_date);
                }
                if (!empty($request->to_date)) {
                    $this->model->setToDate($request->to_date);
                }
                if (!empty($request->supplier_id)) {
                    $this->model->setSupplierID($request->supplier_id);
                }

                if (!empty($request->payment_status)) {
                    $this->model->setPaymentStatus($request->payment_status);
                }


                $this->set_datatable_default_properties($request);//set datatable default properties
                $list = $this->model->getDatatableList();//get table data
                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';
                    if(permission('purchase-edit')){
                        $action .= ' <a class="dropdown-item" href="'.route("purchase.edit",$value->id).'">'.self::ACTION_BUTTON['Edit'].'</a>';
                    }
                    if(permission('purchase-view')){
                        $action .= ' <a class="dropdown-item view_data" href="'.route("purchase.view",$value->id).'">'.self::ACTION_BUTTON['View'].'</a>';
                    }
                    if(permission('purchase-payment-add')){
                        if($value->payment_status != 1){
                        $action .= ' <a class="dropdown-item add_payment" data-id="'.$value->id.'" data-due="'.$value->due_amount.'"><i class="fas fa-plus-square text-info mr-2"></i> Add Payment</a>';
                        }
                    }
                    if(permission('purchase-payment-view')){
                        $action .= ' <a class="dropdown-item view_payment_list"  data-id="'.$value->id.'"><i class="fas fa-file-invoice-dollar text-dark mr-2"></i> Payment List</a>';
                    }
                    if(permission('purchase-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->chalan_no . '">'.self::ACTION_BUTTON['Delete'].'</a>';
                    }
                    
                    $row = [];
                    if(permission('purchase-bulk-delete')){
                        $row[] = row_checkbox($value->id);//custom helper function to show the table each row checkbox
                    }
                    $row[] = $no;
                    $row[] = $value->memo_no;
                    $row[] = $value->supplier->company_name.' ('.$value->supplier->name.')';
                    $row[] = $value->item;
                    $row[] = $value->total_qty;
                    $row[] = number_format($value->grand_total,2,'.',',');
                    $row[] = number_format($value->discount_amount ?? 0,2,'.',',');
                    $row[] = number_format($value->net_total,2,'.',',');
                    $row[] = number_format($value->paid_amount,2,'.',',');
                    $row[] = number_format($value->due_amount,2,'.',',');
                    $row[] = date(config('settings.date_format'),strtotime($value->purchase_date));
                    $row[] = PAYMENT_STATUS_LABEL[$value->payment_status];
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
        if(permission('purchase-add')){
            $this->setPageData('Add Purchase','Add Purchase','fas fa-shopping-cart',[['name' => 'Add Purchase']]);
            $purchase = $this->model->select('memo_no')->orderBy('memo_no','desc')->first();
            $data = [
                'suppliers'  => Supplier::allSuppliers(),
                'materials'      => Material::with('purchase_unit')->get(),
                'memo_no'   => 'PINV-'.($purchase ? explode('PINV-',$purchase->memo_no)[1] + 1 : self::MEMO_NO)
            ];
            
            return view('purchase::create',$data);
        }else{
            return $this->access_blocked();
        }
        
    }

    public function store(PurchaseFormRequest $request)
    {
        if($request->ajax()){
            if(permission('purchase-add')){
                // dd($request->all());
                DB::beginTransaction();
                try {
                    $warehouse_id = 1;
                    $purchase  = $this->model->create([
                        'memo_no'         => $request->memo_no,
                        'supplier_id'     => $request->supplier_id,
                        'warehouse_id'    => $warehouse_id,
                        'item'            => $request->item,
                        'total_qty'       => $request->total_qty,
                        'grand_total'     => $request->grand_total,
                        'discount_amount' => $request->discount_amount ? $request->discount_amount : 0,
                        'net_total'       => $request->net_total,
                        'paid_amount'     => $request->paid_amount ? $request->paid_amount : 0,
                        'due_amount'      => $request->due_amount,
                        'payment_status'  => $request->payment_status,
                        'purchase_date'   => $request->purchase_date,
                        'created_by'      => auth()->user()->name
                    ]);
                    if($purchase)
                    {
                        //purchase materials
                        $materials = [];
                        if($request->has('materials'))
                        {                        
                            foreach ($request->materials as $key => $value) {
                                $unit = Unit::find($value['purchase_unit_id']);

                                if($unit->operator == '*'){
                                    $qty = $value['qty'] * $unit->operation_value;
                                }else{
                                    $qty = $value['qty'] / $unit->operation_value;
                                }
                                
                                $material = Material::find($value['id']);

                                if($material->tax_method == 1){
                                    if($unit->operator == '*'){
                                        $material_cost = ((floatval($value['net_unit_cost']) * $value['qty']) /  $value['qty']) / $unit->operation_value;
                                    }elseif ($unit->operator == '/') {
                                        $material_cost = ((floatval($value['net_unit_cost']) * $value['qty']) /  $value['qty']) * $unit->operation_value;
                                    }
                                }else{
                                    if($unit->operator == '*'){
                                        $material_cost = ((floatval($value['subtotal']) / $value['qty']) / $unit->operation_value);
                                    }elseif ($unit->operator == '/') {
                                        $material_cost = ((floatval($value['subtotal']) / $value['qty']) * $unit->operation_value);
                                    }
                                    
                                }
                                
                                $current_stock_value = ($material->qty ? $material->qty : 0) * ($material->cost ? $material->cost : 0);
                                $new_cost            = (($material_cost * $qty) + $current_stock_value) / ($qty + $material->qty);
                                $current_cost        = $material->cost ? $material->cost : 0;
                                $old_cost            = $material->old_cost ? $material->old_cost : 0;
   
                                $materials[] = [
                                    'purchase_id'      => $purchase->id,
                                    'material_id'      => $value['id'],
                                    'qty'              => $value['qty'],
                                    'purchase_unit_id' => $value['purchase_unit_id'],
                                    'net_unit_cost'    => $value['net_unit_cost'],
                                    'new_unit_cost'    => $new_cost,
                                    'old_cost'         => $old_cost,
                                    'total'            => $value['subtotal'],
                                    'created_at'       => date('Y-m-d H:i:s')
                                ];

                                if($material){
                                    $material->qty     += $qty;
                                    $material->cost     = $new_cost;
                                    $material->old_cost = $current_cost;
                                    $material->save();    
                                }
                                
                                $warehouse_material = WarehouseMaterial::where(['warehouse_id'=>$warehouse_id,'material_id'=>$value['id']])->first();
                                if($warehouse_material){
                                    $warehouse_material->qty += $qty;
                                    $warehouse_material->save();
                                }else{
                                    WarehouseMaterial::create([
                                        'warehouse_id' => $warehouse_id,
                                        'material_id'  => $value['id'],
                                        'qty'          => $qty
                                    ]);
                                }
                            }

                            if(!empty($materials) && count($materials) > 0)
                            {
                                MaterialPurchase::insert($materials);
                            }
                        }
                        
                        $payment_data = [
                            'payment_method' => $request->payment_method,
                            'account_id'     => $request->account_id,
                            'paid_amount'    => $request->paid_amount ? $request->paid_amount : 0,
                            'reference_no'   => $request->reference_number ? $request->reference_number : '',
                        ];
                        $supplier = Supplier::with('coa')->find($request->supplier_id);
                        $this->purchase_balance_add($purchase->id,$request->memo_no,$request->net_total,$supplier->coa->id,$supplier->name,$request->purchase_date,$payment_data);
                        $output = ['status'=>'success','message'=>'Data has been saved successfully','purchase_id'=>$purchase->id];
                    }else{
                        $output = ['status'=>'error','message'=>'Failed to save data','purchase_id'=>''];
                    }
                    DB::commit();
                    // return response()->json($output);
                } catch (Exception $e) {
                    DB::rollback();
                    $output = ['status' => 'error','message' => $e->getMessage()];
                    // return response()->json($output);
                }
            }else{
                $output       = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }

 
    private function purchase_balance_add(int $purchase_id,$memo_no,$balance, int $supplier_coa_id, string $supplier_name, $purchase_date, array $payment_data) {
        if(!empty($purchase_id) && !empty($balance) && !empty($supplier_coa_id) && !empty($supplier_name)  && !empty($purchase_date)){
            // supplier Credit
            $purchase_coa_transaction = array(
                'chart_of_account_id' => $supplier_coa_id,
                'voucher_no'          => $memo_no,
                'voucher_type'        => 'Purchase',
                'voucher_date'        => $purchase_date,
                'description'         => 'Supplier '.$supplier_name,
                'debit'               => 0,
                'credit'              => $balance,
                'posted'              => 1,
                'approve'             => 1,
                'created_by'          => auth()->user()->name,
                'created_at'          => date('Y-m-d H:i:s')
            );

            //Inventory Debit
            $cosde = array(
                'chart_of_account_id' => DB::table('chart_of_accounts')->where('code', $this->coa_head_code('inventory'))->value('id'),
                'voucher_no'          => $memo_no,
                'voucher_type'        => 'Purchase',
                'voucher_date'        => $purchase_date,
                'description'         => 'Inventory Debit For Supplier '.$supplier_name,
                'debit'               => $balance,
                'credit'              => 0,
                'posted'              => 1,
                'approve'             => 1,
                'created_by'          => auth()->user()->name,
                'created_at'          => date('Y-m-d H:i:s')
            ); 

             // Expense for company
            $expense = array(
                'chart_of_account_id' => DB::table('chart_of_accounts')->where('code', $this->coa_head_code('material_purchase'))->value('id'),
                'voucher_no'          => $memo_no,
                'voucher_type'        => 'Purchase',
                'voucher_date'        => $purchase_date,
                'description'         => 'Company Credit For Supplier '.$supplier_name,
                'debit'               => $balance,
                'credit'              => 0,
                'posted'              => 1,
                'approve'             => 1,
                'created_by'          => auth()->user()->name,
                'created_at'          => date('Y-m-d H:i:s')
            ); 

            Transaction::insert([
                $purchase_coa_transaction,$cosde,$expense
            ]);


            if($payment_data['paid_amount'])
            {
                /****************/
                $supplierdebit = array(
                    'chart_of_account_id' => $supplier_coa_id,
                    'voucher_no'          => $memo_no,
                    'voucher_type'        => 'Purchase',
                    'voucher_date'        => $purchase_date,
                    'description'         => 'Supplier .' . $supplier_name,
                    'debit'               => $payment_data['paid_amount'],
                    'credit'              => 0,
                    'posted'              => 1,
                    'approve'             => 1,
                    'created_by'          => auth()->user()->name,
                    'created_at'          => date('Y-m-d H:i:s')
                );
                if($payment_data['payment_method'] == 1){
                    //Cah In Hand For Supplier
                    $payment = array(
                        'chart_of_account_id' => $payment_data['account_id'],
                        'voucher_no'          => $memo_no,
                        'voucher_type'        => 'Purchase',
                        'voucher_date'        => $purchase_date,
                        'description'         => 'Cash in Hand For Supplier ' . $supplier_name,
                        'debit'               => 0,
                        'credit'              => $payment_data['paid_amount'],
                        'posted'              => 1,
                        'approve'             => 1,
                        'created_by'          => auth()->user()->name,
                        'created_at'          => date('Y-m-d H:i:s')
                        
                    );
                }else{
                    // Bank Ledger
                    $payment = array(
                        'chart_of_account_id' => $payment_data['account_id'],
                        'voucher_no'          => $memo_no,
                        'voucher_type'        => 'Purchase',
                        'voucher_date'        => $purchase_date,
                        'description'         => 'Paid amount for Supplier  ' . $supplier_name,
                        'debit'               => 0,
                        'credit'              => $payment_data['paid_amount'],
                        'posted'              => 1,
                        'approve'             => 1,
                        'created_by'          => auth()->user()->name,
                        'created_at'          => date('Y-m-d H:i:s')
                    );
                }

                $supplier_debit_transaction = Transaction::create($supplierdebit);
                $payment_transaction        = Transaction::create($payment);

                if($supplier_debit_transaction && $payment_transaction){
                    PurchasePayment::create([
                        'purchase_id'                   => $purchase_id,
                        'account_id'                    => $payment_data['account_id'],
                        'transaction_id'                => $payment_transaction->id,
                        'supplier_debit_transaction_id' => $supplier_debit_transaction->id,
                        'amount'                        => $payment_data['paid_amount'],
                        'payment_method'                => $payment_data['payment_method'],
                        'reference_no'                  => $payment_data['reference_no'],
                        'created_by'                    => auth()->user()->name
                    ]);
                }
                
            }
        }
    }


    public function show(int $id)
    {
        if(permission('purchase-view')){
            $this->setPageData('Purchase Details','Purchase Details','fas fa-file',[['name'=>'Purchase','link' => route('purchase')],['name' => 'Purchase Details']]);
            $purchase = $this->model->with('purchase_materials','supplier')->find($id);
            return view('purchase::details',compact('purchase'));
        }else{
            return $this->access_blocked();
        }
    }
    public function edit(int $id)
    {

        if(permission('purchase-edit')){
            $this->setPageData('Edit Purchase','Edit Purchase','fas fa-edit',[['name'=>'Purchase','link' => route('purchase')],['name' => 'Edit Purchase']]);
            $data = [
                'purchase'   => $this->model->with('purchase_materials','supplier')->find($id),
                'materials'      => Material::with('purchase_unit')->get(),
            ];
            return view('purchase::edit',$data);
        }else{
            return $this->access_blocked();
        }
    }

    public function update(PurchaseFormRequest $request)
    {
        if($request->ajax()){
            if(permission('purchase-edit')){
                // dd($request->all());
                DB::beginTransaction();
                try {
                    $purchaseData = $this->model->with('purchase_materials')->find($request->purchase_id);
                    $warehouse_id = 1;
                    $balance = $request->net_total - ($purchaseData->paid_amount ? $purchaseData->paid_amount : 0);
                    
                    if($balance == 0)
                    {
                        $payment_status = 1;//paid
                    }else if($balance == $purchaseData->net_total)
                    {
                        $payment_status = 3;//due
                    }else{
                        if($purchaseData->paid_amount > 0 && $balance < $purchaseData->net_total)
                        {
                            $payment_status = 2;//partial
                        }else{
                            $payment_status = 3;//due
                        }
                        
                    }
                    // dd($balance);
                    $purchase_data = [
                        'item'            => $request->item,
                        'total_qty'       => $request->total_qty,
                        'grand_total'     => $request->grand_total,
                        'discount_amount' => $request->discount_amount ? $request->discount_amount : 0,
                        'net_total'       => $request->net_total,
                        'due_amount'      => $balance,
                        'payment_status'  => $payment_status,
                        'purchase_date'   => $request->purchase_date,
                        'modified_by'     => auth()->user()->name
                    ];

                    if(!$purchaseData->purchase_materials->isEmpty())
                    {
                        foreach ($purchaseData->purchase_materials as  $purchase_material) {
                            $old_received_qty = $purchase_material->pivot->qty;
                            $purchase_unit = Unit::find($purchase_material->pivot->purchase_unit_id);
                            //dd($purchase_unit);
                            if($purchase_unit->operator == '*'){
                                $old_received_qty = $old_received_qty * $purchase_unit->operation_value;
                            }else{
                                $old_received_qty = $old_received_qty / $purchase_unit->operation_value;
                            }
        
                            $material_data = Material::find($purchase_material->id);
                            if($material_data){
                                $material_data->qty -= $old_received_qty;
                                $material_data->cost = $material_data->old_cost;
                                $material_data->old_cost = $purchase_material->pivot->old_cost;
                                $material_data->update();
                            }
                            

                            $warehouse_material = WarehouseMaterial::where([
                                'warehouse_id'=>$purchaseData->warehouse_id,
                                'material_id'=>$purchase_material->id])->first();
                            if($warehouse_material)
                            {
                                $warehouse_material->qty -= $old_received_qty;
                                $warehouse_material->update();
                            }
                            
                        }
                    }
                   
                    //purchase materials
                    $materials = [];
                    if($request->has('materials'))
                    {                        
                        foreach ($request->materials as $key => $value) {
                            $unit = Unit::find($value['purchase_unit_id']);

                            if($unit->operator == '*'){
                                $qty = $value['qty'] * $unit->operation_value;
                            }else{
                                $qty = $value['qty'] / $unit->operation_value;
                            }
                            
                            $material = Material::find($value['id']);

                            if($material->tax_method == 1){
                                if($unit->operator == '*'){
                                    $material_cost = ((floatval($value['net_unit_cost']) * $value['qty']) /  $value['qty']) / $unit->operation_value;
                                }elseif ($unit->operator == '/') {
                                    $material_cost = ((floatval($value['net_unit_cost']) * $value['qty']) /  $value['qty']) * $unit->operation_value;
                                }
                            }else{
                                if($unit->operator == '*'){
                                    $material_cost = ((floatval($value['subtotal']) / $value['qty']) / $unit->operation_value);
                                }elseif ($unit->operator == '/') {
                                    $material_cost = ((floatval($value['subtotal']) / $value['qty']) * $unit->operation_value);
                                }
                                
                            }
                            
                            $current_stock_value = ($material->qty ? $material->qty : 0) * ($material->cost ? $material->cost : 0);
                            $new_cost            = (($material_cost * $qty) + $current_stock_value) / ($qty + $material->qty);
                            $current_cost        = $material->cost ? $material->cost : 0;
                            $old_cost            = $material->old_cost ? $material->old_cost : 0;

                            $materials[$value['id']] = [
                                'qty'              => $value['qty'],
                                'purchase_unit_id' => $value['purchase_unit_id'],
                                'net_unit_cost'    => $value['net_unit_cost'],
                                'new_unit_cost'    => $new_cost,
                                'old_cost'         => $old_cost,
                                'total'            => $value['subtotal'],
                                'created_at'       => date('Y-m-d H:i:s')
                            ];

                            if($material){
                                $material->qty     += $qty;
                                $material->cost     = $new_cost;
                                $material->old_cost = $current_cost;
                                $material->save();    
                            }
                            
                            $warehouse_material = WarehouseMaterial::where(['warehouse_id'=>$warehouse_id,'material_id'=>$value['id']])->first();
                            if($warehouse_material){
                                $warehouse_material->qty += $qty;
                                $warehouse_material->save();
                            }else{
                                WarehouseMaterial::create([
                                    'warehouse_id' => $warehouse_id,
                                    'material_id'  => $value['id'],
                                    'qty'          => $qty
                                ]);
                            }
                        }
                    }
                    $purchase = $purchaseData->update($purchase_data);

                    
                    $purchaseData->purchase_materials()->sync($materials);
                    $supplier = Supplier::with('coa')->find($request->supplier_id);
                    
                    $purchase_coa_transaction = Transaction::where(['chart_of_account_id' => $supplier->coa->id,'voucher_no' => $request->memo_no,'voucher_type'=> 'Purchase'])->first();
                    if($purchase_coa_transaction)
                    {
                        $purchase_coa_transaction->update([
                            'voucher_date' => $request->purchase_date,
                            'credit'       => $request->net_total,
                            'modified_by'  => auth()->user()->name,
                            'updated_at'   => date('Y-m-d H:i:s')
                        ]);
                    }

                    $purchase_coscr = Transaction::where([
                        'chart_of_account_id' => DB::table('chart_of_accounts')->where('code', $this->coa_head_code('inventory'))->value('id'),
                        'voucher_no' => $request->memo_no,'voucher_type'=> 'Purchase'])->first();
                    if($purchase_coscr)
                    {
                        $purchase_coscr->update([
                            'voucher_date' => $request->purchase_date,
                            'debit'        => $request->net_total,
                            'modified_by'  => auth()->user()->name,
                            'updated_at'   => date('Y-m-d H:i:s')
                        ]);
                    }
                    $company_expense = Transaction::where([
                        'chart_of_account_id' => DB::table('chart_of_accounts')->where('code', $this->coa_head_code('material_purchase'))->value('id'),
                        'voucher_no' => $request->memo_no,'voucher_type'=> 'Purchase'])->first();
                    if($company_expense)
                    {
                        $company_expense->update([
                            'voucher_date' => $request->purchase_date,
                            'debit'        => $request->net_total,
                            'modified_by'  => auth()->user()->name,
                            'updated_at'   => date('Y-m-d H:i:s')
                        ]);
                    }
                    $output  = $this->store_message($purchase, $request->purchase_id);
                    DB::commit();
                    // return response()->json($output);
                } catch (Exception $e) {
                    DB::rollback();
                    $output = ['status' => 'error','message' => $e->getMessage()];
                    // return response()->json($output);
                }
            }else{
                $output       = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }


    public function delete(Request $request)
    {
        if($request->ajax()){
            if(permission('purchase-delete')){
                DB::beginTransaction();
                try {
                    $purchaseData = Purchase::with('purchase_materials')->find($request->id);
                    if(!$purchaseData->purchase_materials->isEmpty())
                    {
                        foreach ($purchaseData->purchase_materials as  $purchase_material) {
                            $old_received_qty = $purchase_material->pivot->qty;
                            $purchase_unit = Unit::find($purchase_material->pivot->purchase_unit_id);
                            //dd($purchase_unit);
                            if($purchase_unit->operator == '*'){
                                $old_received_qty = $old_received_qty * $purchase_unit->operation_value;
                            }else{
                                $old_received_qty = $old_received_qty / $purchase_unit->operation_value;
                            }
        
                            $material_data = Material::find($purchase_material->id);
                            if($material_data){
                                $material_data->qty -= $old_received_qty;
                                $material_data->cost = $material_data->old_cost;
                                $material_data->old_cost = $purchase_material->pivot->old_cost;
                                $material_data->update();
                            }
                            

                            $warehouse_material = WarehouseMaterial::where([
                                'warehouse_id'=>$purchaseData->warehouse_id,
                                'material_id'=>$purchase_material->id])->first();
                            if($warehouse_material)
                            {
                                $warehouse_material->qty -= $old_received_qty;
                                $warehouse_material->update();
                            }
                           
                        }
                        $purchaseData->purchase_materials()->detach();
                    }
                    PurchasePayment::where('purchase_id',$request->id)->delete();
                    Transaction::where('voucher_no', (string) $purchaseData->memo_no)->where('voucher_type', (string) "Purchase")->delete();
                    $result = $purchaseData->delete();
                    $output = $result ? ['status' => 'success','message' => 'Data has been deleted successfully'] : ['status' => 'error','message' => 'failed to delete data'];
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    $output = ['status'=>'error','message'=>$e->getMessage()];
                }
                return response()->json($output);
            }else{
                $output = $this->access_blocked();
            }
            return response()->json($output);
        }else{
            return response()->json($this->access_blocked());
        }
    }

    public function bulk_delete(Request $request)
    {
        if($request->ajax()){
            if(permission('purchase-bulk-delete')){
                foreach ($request->ids as $id) {
                    DB::beginTransaction();
                    try {
                        $purchaseData = Purchase::with('purchase_materials')->find($id);
                        
                        if(!$purchaseData->purchase_materials->isEmpty())
                        {
                            foreach ($purchaseData->purchase_materials as  $purchase_material) {
                                $old_received_qty = $purchase_material->pivot->qty;
                                $purchase_unit = Unit::find($purchase_material->pivot->purchase_unit_id);
                                //dd($purchase_unit);
                                if($purchase_unit->operator == '*'){
                                    $old_received_qty = $old_received_qty * $purchase_unit->operation_value;
                                }else{
                                    $old_received_qty = $old_received_qty / $purchase_unit->operation_value;
                                }
            
                                $material_data = Material::find($purchase_material->id);
                                if($material_data){
                                    $material_data->qty -= $old_received_qty;
                                    $material_data->cost = $material_data->old_cost;
                                    $material_data->old_cost = $purchase_material->pivot->old_cost;
                                    $material_data->update();
                                }
                                

                                $warehouse_material = WarehouseMaterial::where([
                                    'warehouse_id'=>$purchaseData->warehouse_id,
                                    'material_id'=>$purchase_material->id])->first();
                                if($warehouse_material)
                                {
                                    $warehouse_material->qty -= $old_received_qty;
                                    $warehouse_material->update();
                                }
                                
                            }
                            $purchaseData->purchase_materials()->detach();
                        }
                        PurchasePayment::where('purchase_id',$id)->delete();
                        Transaction::where('voucher_no', (string) $purchaseData->memo_no)->where('voucher_type', (string) "Purchase")->delete();
                        $result = $purchaseData->delete();
                        $output = $result ? ['status' => 'success','message' => 'Data has been deleted successfully'] : ['status' => 'error','message' => 'failed to delete data'];
                        DB::commit();
                    } catch (Exception $e) {
                        DB::rollBack();
                        $output = ['status'=>'error','message'=>$e->getMessage()];
                    }
                    return response()->json($output);
                }
            }else{
                $output = $this->access_blocked();
            }
            return response()->json($output);
        }else{
            return response()->json($this->access_blocked());
        }
    }

    
}
