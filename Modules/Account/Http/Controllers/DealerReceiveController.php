<?php

namespace Modules\Account\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Dealer\Entities\Dealer;
use App\Http\Controllers\BaseController;
use Modules\Account\Entities\Transaction;
use Modules\Account\Http\Requests\DealerReceiveFormRequest;

class DealerReceiveController extends BaseController
{
    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }


    public function index()
    {
        if(permission('dealer-receive-access')){
            $this->setPageData('Dealer Receive','Dealer Receive','far fa-money-bill-alt',[['name'=>'Accounts'],['name'=>'Dealer Receive']]);
            $voucher_no = 'CR-'.date('ymd').rand(1,999);
            $dealers     = DB::table('dealers as d')
            ->leftJoin('locations as di','d.district_id','=','di.id')
            ->leftJoin('locations as a','d.area_id','=','a.id')
            ->select('d.*','di.name as district_name','a.name as area_name')
            ->where([['d.status',1],['d.type',2]])
            ->get();
            return view('account::dealer-receive.index',compact('voucher_no','dealers'));
        }else{
            return $this->access_blocked();
        }
    }

    public function store(DealerReceiveFormRequest $request)
    {
        if($request->ajax()){
            if(permission('dealer-receive-access')){
                DB::beginTransaction();
                try {
                    $dealer = Dealer::with('coa')->find($request->dealer_id);
                    $vtype = 'CR';
                    $warehouse_id = 1;
                    /****************/
                    $dealer_credit = array(
                        'chart_of_account_id' => $dealer->coa->id,
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
                            'description'         => 'Cash In Hand For ' . $dealer->name,
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
                            'description'         => 'Depo Receive From ' . $dealer->name,
                            'debit'               => $request->amount,
                            'credit'              => 0,
                            'posted'              => 1,
                            'approve'             => 1,
                            'created_by'          => auth()->user()->name,
                            'created_at'          => date('Y-m-d H:i:s')
                        );
                    }

                    $dealer_transaction = $this->model->create($dealer_credit);
                    $payment_transaction = $this->model->create($payment);
                    if($dealer_transaction && $payment_transaction){
                        $output = ['status'=>'success','message' => 'Payment Data Saved Successfully'];
                        $output['dealer_transaction'] = $dealer_transaction->id;
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
        if(permission('dealer-receive-access')){
            $this->setPageData('Dealer Receive Voucher Print','Dealer Receive Voucher Print','far fa-money-bill-alt',[['name'=>'Dealer Receive Voucher Print']]);
            $data = $this->model->with('coa')->find($id);
            return view('account::dealer-receive.print',compact('data','payment_type'));
        }else{
            return $this->access_blocked();
        }
    }
}
