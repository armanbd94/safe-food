<?php
namespace Modules\Depo\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Depo\Entities\Depo;
use Illuminate\Support\Facades\DB;
use Modules\Depo\Entities\DepoAdvance;
use App\Http\Controllers\BaseController;
use Modules\Depo\Http\Requests\DepoAdvanceFormRequest;

class DepoAdvanceController extends BaseController
{
    public function __construct(DepoAdvance $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('depo-advance-access')){
            $this->setPageData('Depo Advance','Depo Advance','fas fa-hand-holding-usd',[['name'=>'Depo','link'=>route('depo')],['name'=>'Depo Advance']]);
            $depos = Depo::with('coa')->where('status',1)->get();
            return view('depo::advance.index',compact('depos'));
        }else{
            return $this->access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if (!empty($request->depo_id)) {
                $this->model->setDepoID($request->depo_id);
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
                if(permission('depo-advance-edit')){
                $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '">'.self::ACTION_BUTTON['Edit'].'</a>';
                }
                if(permission('depo-advance-delete')){
                $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->voucher_no . '" data-name="' . $value->depo_name . ' advance ">'.self::ACTION_BUTTON['Delete'].'</a>';
                }
                $account = $this->account_data($value->voucher_no);

                if($account->coa->parent_name == 'Cash & Cash Equivalent'){
                    $payment_method = 'Cash';
                }elseif ($account->coa->parent_name == 'Cash At Bank') {
                    $payment_method = 'Cheque';
                }elseif ($account->coa->parent_name == 'Cash At Mobile Bank') {
                    $payment_method = 'Mobile Bank';
                }
                $row = [];

                $row[] = $no;
                $row[] = $value->depo_name;
                $row[] = $value->mobile_no;
                $row[] = $value->district_name;
                $row[] = $value->upazila_name;
                $row[] = $value->area_name;
                $row[] = number_format($value->credit,2,'.',',');
                $row[] = date(config('settings.date_format'),strtotime($value->created_at));
                $row[] = $payment_method;
                $row[] = $account->coa->name;
                $row[] = action_button($action);//custom helper function for action button
                $data[] = $row;
            }
            return $this->datatable_draw($request->input('draw'),$this->model->count_all(),
            $this->model->count_filtered(), $data);
        }else{
            return response()->json($this->unauthorized());
        }
    }

    private function account_data(string $voucher_no) : object
    {
        return $this->model->with('coa')->where('voucher_no',$voucher_no)->orderBy('id','desc')->first();

    }

    public function store_or_update_data(DepoAdvanceFormRequest $request)
    {
        if($request->ajax()){
            if(permission('depo-advance-add') || permission('depo-advance-edit')){
                DB::beginTransaction();
                try {
                    if(empty($request->id)){
                        $result = $this->advance_add($request->amount,$request->depo_coaid,$request->depo_name,$request->payment_method,$request->account_id,$request->reference_number,$request->warehouse_id);
                        $output = $this->store_message($result, $request->id);
                    }else{
                        $result = $this->advance_update($request->id,$request->amount,$request->depo_coaid,$request->depo_name,$request->payment_method,$request->account_id,$request->reference_number,$request->warehouse_id);
                        $output = $this->store_message($result, $request->id);
                    }
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    $output = ['status' => 'error','message' => $e->getMessage()];
                }
            }else{
                $output = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }

    private function advance_add($amount, int $depo_coa_id, string $depo_name,int $payment_method, int $account_id, string $reference_number = null,$warehouse_id) {
        if(!empty($amount) && !empty($depo_coa_id) && !empty($depo_name)){
            $transaction_id = generator(10);

            $depo_accledger = array(
                'chart_of_account_id' => $depo_coa_id,
                'warehouse_id'        => $warehouse_id,
                'voucher_no'          => $transaction_id,
                'voucher_type'        => 'Advance',
                'voucher_date'        => date("Y-m-d"),
                'description'         => 'Advance from depo '.$depo_name,
                'debit'               => 0,
                'credit'              => $amount,
                'posted'              => 1,
                'approve'             => 1,
                'created_by'          => auth()->user()->name,
                'created_at'          => date('Y-m-d H:i:s')
            );
            if($payment_method == 1){
                $note = 'Cash in Hand For '.$depo_name;
            }else{
                $note = $reference_number;
            }
            $cc = array(
                'chart_of_account_id' => $account_id,
                'warehouse_id'        => $warehouse_id,
                'voucher_no'          => $transaction_id,
                'voucher_type'        => 'Advance',
                'voucher_date'        => date("Y-m-d"),
                'description'         => $note,
                'debit'               => 0,
                'credit'              => $amount,
                'posted'              => 1,
                'approve'             => 1,
                'created_by'          => auth()->user()->name,
                'created_at'          => date('Y-m-d H:i:s')
            ); 

            return $this->model->insert([
                $depo_accledger,$cc
            ]);
        }
    }

    private function advance_update(int $transaction_id, $amount, int $depo_coa_id, string $depo_name,int $payment_method, int $account_id, string $reference_number = null,$warehouse_id) {
        if(!empty($amount) && !empty($depo_coa_id) && !empty($depo_name)){

            $depo_advance_data = $this->model->find($transaction_id);

            $voucher_no = $depo_advance_data->voucher_no;

            $updated = $depo_advance_data->update([
                'warehouse_id'        => $warehouse_id,
                'description'         => 'Advance from depo '.$depo_name,
                'debit'               => 0,
                'credit'              => $amount,
                'modified_by'         => auth()->user()->name,
                'updated_at'          => date('Y-m-d H:i:s')
            ]);
            if($updated)
            {
                if($payment_method == 1){
                    $note = 'Cash in Hand For '.$depo_name;
                }else {
                    $note = $reference_number;
                }
                $account = $this->model->where('voucher_no', $voucher_no)->orderBy('id','desc')->first();
                if($account){
                    $account->update([
                        'chart_of_account_id' => $account_id,
                        'warehouse_id'        => $warehouse_id,
                        'description'         => $note,
                        'debit'               => 0,
                        'credit'              => $amount,
                        'modified_by'         => auth()->user()->name,
                        'updated_at'          => date('Y-m-d H:i:s')
                    ]);
                }
                return true;
            }else{
                return false;
            }
           
        }
    }

    public function edit(Request $request)
    {
        if($request->ajax()){
            if(permission('depo-advance-edit')){
                $data   = $this->model->select('transactions.*','coa.id as coa_id','coa.code','d.id as depo_id')
                ->join('chart_of_accounts as coa','transactions.chart_of_account_id','=','coa.id')
                ->join('depos as d','coa.depo_id','d.id')
                ->where('transactions.id',$request->id)
                ->first();
                $account = $this->account_data($data->voucher_no);
                if($account->coa->parent_name == 'Cash & Cash Equivalent'){
                    $payment_method = 1;
                }elseif ($account->coa->parent_name == 'Cash At Bank') {
                    $payment_method = 2;
                }elseif ($account->coa->parent_name == 'Cash At Mobile Bank') {
                    $payment_method = 3;
                }
                $output = []; //if data found then it will return data otherwise return error message
                if($data){
                    $output = [
                        'id'               => $data->id,
                        'warehouse_id'     => $data->warehouse_id,
                        'depo_id'          => $data->depo_id,
                        'amount'           => $data->credit,
                        'payment_method'   => $payment_method,
                        'account_id'       => $account->chart_of_account_id,
                        'reference_number' => ($payment_method != 1) ? $account->description : '',
                    ];
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
            if(permission('depo-advance-delete')){
                $result   = $this->model->where('voucher_no',$request->id)->delete();
                $output   = $this->delete_message($result);
            }else{
                $output       = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }

    public function bulk_delete(Request $request)
    {
        if($request->ajax()){
            if(permission('depo-advance-bulk-delete')){
                $result   = $this->model->whereIn('voucher_no',$request->ids)->delete();
                $output   = $this->bulk_delete_message($result);
            }else{
                $output       = $this->unauthorized();
            }
            return response()->json($output);
        }else{
            return response()->json($this->unauthorized());
        }
    }



}
