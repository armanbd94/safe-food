<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class WarehouseSummaryController extends BaseController
{
    public function index()
    {
        if(permission('warehouse-summary-access')){
            $this->setPageData('Warehouse Summary','Warehouse Summary','fas fa-file',[['name' => 'Warehouse Summary']]);
            return view('report::warehouse-summary-report.index');
        }else{
            return $this->access_blocked();
        }
    }

    public function summary_data(Request $request)
    {
        if($request->ajax())
        {

            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            
            $purchase = DB::table('purchases')
                                ->whereDate('purchase_date','>=',$start_date)
                                ->whereDate('purchase_date','<=',$end_date)
                                ->sum('net_total');

            $sale = DB::table('sales')
                                ->whereDate('sale_date','>=',$start_date)
                                ->whereDate('sale_date','<=',$end_date)
                                ->sum('net_total');

            $purchase_return = DB::table('purchase_returns')
                                ->whereDate('return_date','>=',$start_date)
                                ->whereDate('return_date','<=',$end_date)
                                ->sum('grand_total');

            $sale_return = DB::table('sale_returns')
                                ->whereDate('return_date','>=',$start_date)
                                ->whereDate('return_date','<=',$end_date)
                                ->sum('grand_total');

            $damage = DB::table('damages')
                            ->whereDate('damage_date','>=',$start_date)
                            ->whereDate('damage_date','<=',$end_date)
                            ->sum('grand_total');

            $expense = DB::table('expenses')
                                ->whereDate('date','>=',$start_date)
                                ->whereDate('date','<=',$end_date)
                                ->sum('amount');
                    
            $supplier_due = DB::table('transactions as t')
                                ->join('chart_of_accounts as coa','t.chart_of_account_id','=','coa.id')
                                ->select(DB::raw("(SUM(t.debit) - SUM(t.credit)) as due"))
                                ->whereNotNull('coa.supplier_id')
                                ->whereDate('t.voucher_date','<=',$end_date)
                                ->first();

            $depo_due = DB::table('transactions as t')
                                ->join('chart_of_accounts as coa','t.chart_of_account_id','=','coa.id')
                                ->select(DB::raw("(SUM(t.debit) - SUM(t.credit)) as due"))
                                ->whereNotNull('coa.depo_id')
                                ->whereDate('t.voucher_date','<=',$end_date)
                                ->first();

            $dealer_due = DB::table('transactions as t')
                                ->join('chart_of_accounts as coa','t.chart_of_account_id','=','coa.id')
                                ->select(DB::raw("(SUM(t.debit) - SUM(t.credit)) as due"))
                                ->whereNotNull('coa.dealer_id')
                                ->whereDate('t.voucher_date','<=',$end_date)
                                ->first();

            $data = [
                'total_purchase'        => $purchase,
                'total_sale'            => $sale,
                'total_purchase_return' => $purchase_return,
                'total_sale_return'     => $sale_return,
                'total_damage'          => $damage,
                'total_expense'         => $expense,
                'total_supplier_due'    => $supplier_due ? str_replace('-','',$supplier_due->due) : 0,
                'total_depo_due'        => $depo_due ? $depo_due->due : 0,
                'total_dealer_due'      => $dealer_due ? $dealer_due->due : 0,
            ];

            // dd($data);

            return view('report::warehouse-summary-report.summary-data',$data)->render();
        }
    }
}
