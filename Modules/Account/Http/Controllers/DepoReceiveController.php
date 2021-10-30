<?php

namespace Modules\Account\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Depo\Entities\Depo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Modules\Account\Entities\Transaction;
use Modules\Account\Http\Requests\DepoReceiveFormRequest;

class DepoReceiveController extends BaseController
{
    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }


    public function index()
    {
        if(permission('depo-receive-access')){
            $this->setPageData('Depo Receive','Depo Receive','far fa-money-bill-alt',[['name'=>'Accounts'],['name'=>'Depo Receive']]);
            $voucher_no = 'CR-'.date('ymd').rand(1,999);
            $depos     = DB::table('depos as d')
            ->leftJoin('locations as di','d.district_id','=','di.id')
            ->leftJoin('locations as a','d.area_id','=','a.id')
            ->select('d.*','di.name as district_name','a.name as area_name')
            ->get();
            return view('account::depo-receive.index',compact('voucher_no','depos'));
        }else{
            return $this->access_blocked();
        }
    }

    public function store(DepoReceiveFormRequest $request)
    {
        if($request->ajax()){
            if(permission('depo-receive-access')){
                DB::beginTransaction();
                try {
                    $depo = Depo::with('coa')->find($request->depo_id);
                    $vtype = 'CR';
                    $warehouse_id = 1;
                    /****************/
                    $depo_credit = array(
                        'chart_of_account_id' => $depo->coa->id,
                        'warehouse_id'        => $warehouse_id,
                        'voucher_no'          => $request->voucher_no,
                        'voucher_type'        => $vtype,
                        'voucher_date'        => $request->voucher_date,
                        'description'         => $request->remarks,
                        'debit'               => 0,
                        'credit'              => $request->amount,
                        'posted'              => 1,
                        'approve'             => 1,
                        'created_by'          => auth()->user()->name,
                        'created_at'          => date('Y-m-d H:i:s')
                    );
                    if($request->payment_type == 1){
                        //Cah In Hand For Supplier
                        $payment = array(
                            'chart_of_account_id' => $request->account_id,
                            'warehouse_id'        => $warehouse_id,
                            'voucher_no'          => $request->voucher_no,
                            'voucher_type'        => $vtype,
                            'voucher_date'        => $request->voucher_date,
                            'description'         => 'Cash In Hand For ' . $depo->name,
                            'debit'               => $request->amount,
                            'credit'              => 0,
                            'posted'              => 1,
                            'approve'             => 1,
                            'created_by'          => auth()->user()->name,
                            'created_at'          => date('Y-m-d H:i:s')
                            
                        );
                    }else{
                        // Bank Ledger
                        $payment = array(
                            'chart_of_account_id' => $request->account_id,
                            'warehouse_id'        => $warehouse_id,
                            'voucher_no'          => $request->voucher_no,
                            'voucher_type'        => $vtype,
                            'voucher_date'        => $request->voucher_date,
                            'description'         => 'Depo Receive From ' . $depo->name,
                            'debit'               => $request->amount,
                            'credit'              => 0,
                            'posted'              => 1,
                            'approve'             => 1,
                            'created_by'          => auth()->user()->name,
                            'created_at'          => date('Y-m-d H:i:s')
                        );
                    }

                    $depo_transaction = $this->model->create($depo_credit);
                    $payment_transaction = $this->model->create($payment);
                    if($depo_transaction && $payment_transaction){
                        $output = ['status'=>'success','message' => 'Payment Data Saved Successfully'];
                        $output['depo_transaction'] = $depo_transaction->id;
                    }else{
                        $output = ['status'=>'error','message' => 'Failed To Save Payment Data'];
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

    public function show(int $id,int $payment_type)
    {
        if(permission('depo-receive-access')){
            $this->setPageData('Depo Receive Voucher Print','Depo Receive Voucher Print','far fa-money-bill-alt',[['name'=>'Depo Receive Voucher Print']]);
            $data = $this->model->with('coa')->find($id);
            return view('account::depo-receive.print',compact('data','payment_type'));
        }else{
            return $this->access_blocked();
        }
    }
}
