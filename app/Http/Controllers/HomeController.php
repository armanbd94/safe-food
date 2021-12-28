<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Modules\Account\Entities\ChartOfAccount;
use Modules\Account\Entities\Transaction;

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

    public function accounts()
    {
        $accounts = '<pre><ul>';
        $accounts .= $this->coa('COA');
        $accounts .= '</ul></pre>';
        return view('test',compact('accounts'));
    }

    public function coa($parent_name)
    {
        $module = '';
        
        if($parent_name == 'COA'){
            $modules = ChartOfAccount::where(['parent_name' => 'COA'])->orderBy('code','asc')->get(); //get module list whose parent id is 0
        }else{
            $modules = ChartOfAccount::where(['parent_name' => $parent_name])->orderBy('code','asc')->get(); //get module list whose parent id is the given id
        }
        
        if(!$modules->isEmpty()){
            foreach ($modules as $value) {
                $children = ChartOfAccount::where(['parent_name' => $value->name])->get();
                $amount = 0;
                if(count($children) > 0)
                {
                    foreach ($children as $item) {
                        $amount += $this->children($item);
                    }
                }else{
                    $balance = DB::table('transactions')
                    ->select(DB::raw("SUM(debit) - SUM(credit) as balance"))
                    ->where([['chart_of_account_id',$value->id],['approve',1]])
                    ->first();
                    $amount += !empty($balance) ? $balance->balance : 0;
                }
                $module .= "<li>".$value->name."<b > = ".$amount."</b>";
                $module .= "<ul>".$this->coa($value->name)."</ul>";
                $module .= "</li>";
            }
        }
        return $module;
    }

    public function children($item)
    {
        $amount = 0;
        
        $children = ChartOfAccount::where(['parent_name' => $item->name])->get();
        if(count($children) > 0)
        {
            foreach ($children as $item) {
                $amount += $this->children($item);
            }
        }else{
            $transaction = DB::table('transactions as t')
            ->select(DB::raw("SUM(t.debit) - SUM(t.credit) as balance"))
            ->where([['t.chart_of_account_id',$item->id],['approve',1]])
            ->first();
            $amount += $transaction ? $transaction->balance : 0;
        }
        return $amount;
    }
}
