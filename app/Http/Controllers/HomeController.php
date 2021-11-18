<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;


class HomeController extends BaseController
{
    public function index()
    {

        if (permission('dashboard-access')){

            $this->setPageData('Dashboard','Dashboard','fas fa-technometer');
            //Yearly Report
            $start = strtotime(date('Y').'-01-01');
            $end = strtotime(date('Y').'-12-31');

            $yearly_sale_amount = [];
            $yearly_purchase_amount = [];
            while ($start < $end) {
                $start_date  = date('Y').'-'.date('m',$start).'-01';
                $end_date  = date('Y').'-'.date('m',$start).'-31';

                $sale_amount = DB::table('sales')->whereDate('sale_date','>=',$start_date)
                ->whereDate('sale_date','<=',$end_date)->sum('net_total');

                $purchase_amount = DB::table('purchases')->whereDate('purchase_date','>=',$start_date)
                ->whereDate('purchase_date','<=',$end_date)->sum('net_total');

                $yearly_sale_amount[] = number_format($sale_amount,2,'.','');
                $yearly_purchase_amount[] = number_format($purchase_amount,2,'.','');
                $start = strtotime('+1 month',$start);
            }
            return view('home',compact('yearly_sale_amount','yearly_purchase_amount'));
        }else{
            return redirect('unauthorized')->with(['status'=>'error','message'=>'Unauthorized Access Blocked']);
        }
    }

    public function dashboard_data($start_date,$end_date)
    {
        if($start_date && $end_date)
        {
            $sale = DB::table('sales')
                    ->whereBetween('sale_date',[$start_date,$end_date])
                    ->sum('net_total');

            $purchase = DB::table('purchases')
                        ->whereBetween('purchase_date',[$start_date,$end_date])
                        ->sum('net_total');

            $expense = DB::table('expenses')
                        ->whereBetween('date',[$start_date,$end_date])
                        ->sum('amount');
            $income_from_depo = DB::table('transactions as t')
                        ->join('chart_of_accounts as coa','t.chart_of_account_id','=','coa.id')
                        ->whereNotNull('coa.depo_id')
                        ->whereBetween('t.voucher_date',[$start_date,$end_date])
                        ->where(function($q){
                            $q->where('t.voucher_type','CR')
                            ->orWhere('t.voucher_type','Advance');
                        })
                        ->sum('t.credit');

            $income_from_dealer = DB::table('transactions as t')
                        ->join('chart_of_accounts as coa','t.chart_of_account_id','=','coa.id')
                        ->whereNotNull('coa.dealer_id')
                        ->whereBetween('t.voucher_date',[$start_date,$end_date])
                        ->where(function($q){
                            $q->where('t.voucher_type','CR')
                            ->orWhere('t.voucher_type','Advance');
                        })
                        ->sum('t.credit');
            $data = [
                'sale'              => $sale,
                'purchase'          => $purchase,
                'expense'           => $expense,
                'income'   => ($income_from_depo ?? 0) + ($income_from_dealer ?? 0)
            ];
            return response()->json($data);
        }

    }
    
    public function unauthorized()
    {
        $this->setPageData('Unauthorized','Unauthorized','fas fa-ban',[['name' => 'Unauthorized']]);
        return view('unauthorized');
    }

    public function stock_alert()
    {
        $materials = DB::table('materials')->where('status',1)->whereColumn('alert_qty','>','qty')->count();
        $products = DB::table('products')
        ->where('status',1)
        ->whereColumn('alert_quantity','>','base_unit_qty')->count();
        return response()->json(['materials' => $materials,'products'=>$products]);
    }
}
