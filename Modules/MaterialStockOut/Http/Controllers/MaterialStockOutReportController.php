<?php

namespace Modules\MaterialStockOut\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Modules\MaterialStockOut\Entities\StockOutReport;

class MaterialStockOutReportController extends BaseController
{
    public function __construct(StockOutReport $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('material-stock-out-report-access')){
            $this->setPageData('Material Stock Out Report','Material Stock Out Report','fas fa-file',[['name' => 'Material Stock Out Report']]);
            
            // $reports = DB::table('stock_out_materials as som')
            // ->selectRaw('m.material_name,m.material_code,SUM(som.qty) as qty,AVG(som.net_unit_cost) as cost,so.date')
            // ->join('stock_outs as so','som.stock_out_id','=','so.id')
            // ->join('materials as m','som.material_id','=','m.id')
            // ->groupBy('som.material_id','so.date')
            // ->get();
            // dd($reports);
            $materials = DB::table('materials')->where('status',1)->get();
            return view('materialstockout::report',compact('materials'));
        }else{
            return $this->access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if($request->ajax()){
            if(permission('material-stock-out-access')){

                if (!empty($request->material_id)) {
                    $this->model->setMaterialID($request->material_id);
                }
                if (!empty($request->from_date)) {
                    $this->model->setFromDate($request->from_date);
                }
                if (!empty($request->to_date)) {
                    $this->model->setToDate($request->to_date);
                }

                $this->set_datatable_default_properties($request);//set datatable default properties
                $list = $this->model->getDatatableList();//get table data
                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
    
                    $row = [];
                    $row[] = $no;
                    $row[] = date(config('settings.date_format'),strtotime($value->date));
                    $row[] = $value->material_name;
                    $row[] = $value->material_code;
                    $row[] = $value->unit_name;
                    $row[] = number_format($value->cost,2,'.','');
                    $row[] = number_format($value->qty,2,'.','');
                    $row[] = number_format(($value->qty * $value->cost),2,'.','');
                    $data[] = $row;
                }
                return $this->datatable_draw($request->input('draw'),$this->model->count_all(),
                $this->model->count_filtered(), $data);
            }
        }else{
            return response()->json($this->unauthorized());
        }
    }
}
