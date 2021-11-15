<?php
namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Depo\Entities\Depo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class DepoWiseSalesReportController extends BaseController
{
    
    public function index()
    {
        if(permission('depo-wise-sales-report-access')){
            $this->setPageData('Depo Wise Sales Report','Depo Wise Sales Report','fas fa-file',[['name' => 'Depo Wise Sales Report']]);
            $data = [
                'depos'  => DB::table('depos')->where('status',1)->pluck('name','id')
            ];
            return view('report::depo-wise-sales-report.index',$data);
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
        $report_data = DB::table('sales as s')
                    ->selectRaw('s.sale_date,sum(s.item) as total_item,sum(s.total_qty) as total_qty, sum(s.grand_total) as grand_total,
                    s.commission_rate,sum(s.total_commission) as total_commission,sum(s.net_total) as net_total')
                    ->groupBy('s.sale_date')
                    ->where('s.depo_id',$depo_id)
                    ->whereBetween('s.sale_date',[$start_date,$end_date]) 
                    ->get();
        return view('report::depo-wise-sales-report.report',compact('report_data','depo','start_date','end_date'))->render();

    }

}
