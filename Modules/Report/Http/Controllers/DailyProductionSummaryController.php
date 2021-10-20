<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class DailyProductionSummaryController extends BaseController
{
    public function index()
    {
        if(permission('daily-production-summary-access')){
            $this->setPageData('Daily Production Summary','Daily Production Summary','fas fa-file',[['name' => 'Daily Production Summary']]);
            $total_production_material_cost = DB::table('stock_outs')
            ->whereBetween('date',[date('Y-m-d'),date('Y-m-d')])
            ->sum('grand_total');

            $production_product_value = DB::table('adjustment_products as ap')
            ->selectRaw('p.name,SUM(ap.base_unit_qty) as qty,p.base_unit_price as price,(SUM(ap.base_unit_qty) * p.base_unit_price) as total,a.date')
            ->join('adjustments as a','ap.adjustment_id','=','a.id')
            ->join('products as p','ap.product_id','=','p.id')
            ->groupBy('ap.product_id','a.date')
            ->whereBetween('a.date',[date('Y-m-d'),date('Y-m-d')])
            ->get();
            $total_production_product_value = 0;
            if(!$production_product_value->isEmpty())
            {
                foreach ($production_product_value as $value) {
                    $total_production_product_value += $value->total;
                }
            }
            $data = [
                'total_production_material_cost' => number_format($total_production_material_cost,2,'.',''),
                'total_production_product_value' => number_format($total_production_product_value,2,'.','')
            ];
            return view('report::production-summary-report',$data);
        }else{
            return $this->access_blocked();
        }
    }


}
