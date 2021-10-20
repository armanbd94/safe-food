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
            $materials =  DB::table('stock_out_materials as som')
            ->selectRaw('m.material_name,m.material_code,SUM(som.qty) as qty,AVG(som.net_unit_cost) as cost,so.date')
            ->join('stock_outs as so','som.stock_out_id','=','so.id')
            ->join('materials as m','som.material_id','=','m.id')
            ->groupBy('som.material_id','so.date')
            ->whereBetween('so.date',[date('Y-m-d'),date('Y-m-d')])
            ->get();

            $products = DB::table('adjustment_products as ap')
            ->selectRaw('p.name,p.code,SUM(ap.base_unit_qty) as qty,p.base_unit_price as price,(SUM(ap.base_unit_qty) * p.base_unit_price) as total,a.date')
            ->join('adjustments as a','ap.adjustment_id','=','a.id')
            ->join('products as p','ap.product_id','=','p.id')
            ->groupBy('ap.product_id','a.date')
            ->whereBetween('a.date',[date('Y-m-d'),date('Y-m-d')])
            ->get();

            $data = [
                'materials' => $materials,
                'products' => $products
            ];
            return view('report::production-summary-report',$data);
        }else{
            return $this->access_blocked();
        }
    }


}
