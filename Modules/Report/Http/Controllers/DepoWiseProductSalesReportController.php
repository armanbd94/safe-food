<?php
namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Depo\Entities\Depo;
use Illuminate\Support\Facades\DB;
use Modules\Dealer\Entities\Dealer;
use App\Http\Controllers\BaseController;

class DepoWiseProductSalesReportController extends BaseController
{
    
    public function index()
    {
        if(permission('depo-wise-product-sales-report-access')){
            $this->setPageData('Depo Wise Product Sales Report','Depo Wise Product Sales Report','fas fa-file',[['name' => 'Depo Wise Product Sales Report']]);
            $data = [
                'depos'  => DB::table('depos')->where('status',1)->pluck('name','id')
            ];
            return view('report::depo-wise-product-sales-report.index',$data);
        }else{
            return $this->access_blocked();
        }

    }

    public function report_data(Request $request)
    {

        $depo_id = $request->depo_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $depo = Depo::with('district','area')->find($depo_id);
        $report_data = DB::table('sale_products as sp')
        ->join('sales as s','sp.sale_id','=','s.id')
        ->join('products as p','sp.product_id','=','p.id')
        ->join('units as bu','sp.base_unit_id','=','bu.id')
        ->join('units as u','p.unit_id','=','u.id')
        ->selectRaw('p.id,p.name,bu.unit_name as sale_unit,u.unit_name as ctn_size,SUM(sp.unit_qty) as unit_qty,
        SUM(sp.qty) as qty, SUM(sp.free_qty) as free_qty,sp.net_unit_price,sum(sp.total) as total_order_value')
        ->groupBy('sp.product_id')
        ->where(['s.order_from'=>1,'s.depo_id'=>$depo_id])
        ->whereBetween('s.sale_date',[$start_date,$end_date]) 
        ->orderBy('p.id','asc')
        ->get();
        return view('report::depo-wise-product-sales-report.report',compact('report_data','depo','start_date','end_date'))->render();

    }

}
