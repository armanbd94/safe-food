<?php

namespace Modules\MaterialStockOut\Entities;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;

class StockOutReport extends BaseModel
{
    protected $table = 'stock_out_materials';
    protected $guarded = [];

     /******************************************
     * * * Begin :: Custom Datatable Code * * *
    *******************************************/
    //custom search column property
    protected $order = ['so.date' => 'desc'];
    protected $_material_id; 
    protected $_from_date; 
    protected $_to_date; 

    //methods to set custom search property value
    public function setMaterialID($material_id)
    {
        $this->_material_id = $material_id;
    }

    public function setFromDate($from_date)
    {
        $this->_from_date = $from_date;
    }
    public function setToDate($to_date)
    {
        $this->_to_date = $to_date;
    }


    private function get_datatable_query()
    {

        $this->column_order = ['som.material_id','so.date','m.material_name','m.material_code', 'som.qty','som.net_unit_cost',null];
 
        $query = DB::table('stock_out_materials as som')
        ->selectRaw('m.material_name,m.material_code,SUM(som.qty) as qty,AVG(som.net_unit_cost) as cost,so.date')
        ->join('stock_outs as so','som.stock_out_id','=','so.id')
        ->join('materials as m','som.material_id','=','m.id')
        ->groupBy('som.material_id','so.date');

        //search query
        if (!empty($this->_material_id)) {
            $query->where('som.material_id', $this->_material_id);
        }

        if (!empty($this->_from_date)) {
            $query->whereDate('so.date', '>=',$this->_from_date);
        }
        if (!empty($this->_to_date)) {
            $query->whereDate('so.date', '<=',$this->_to_date);
        }


        //order by data fetching code
        if (isset($this->orderValue) && isset($this->dirValue)) { //orderValue is the index number of table header and dirValue is asc or desc
            $query->orderBy($this->column_order[$this->orderValue], $this->dirValue); //fetch data order by matching column
        } else if (isset($this->order)) {
            $query->orderBy(key($this->order), $this->order[key($this->order)]);
        }
        return $query;
    }

    public function getDatatableList()
    {
        $query = $this->get_datatable_query();
        if ($this->lengthVlaue != -1) {
            $query->offset($this->startVlaue)->limit($this->lengthVlaue);
        }
        return $query->get();
    }

    public function count_filtered()
    {
        $query = $this->get_datatable_query();
        return $query->get()->count();
    }

    public function count_all()
    {
        return DB::table('stock_out_materials as som')
        ->selectRaw('m.material_name,m.material_code,SUM(som.qty) as qty,AVG(som.net_unit_cost) as cost,so.date')
        ->join('stock_outs as so','som.stock_out_id','=','so.id')
        ->join('materials as m','som.material_id','=','m.id')
        ->groupBy('som.material_id','so.date')->get()->count();
    }
    /******************************************
     * * * End :: Custom Datatable Code * * *
    *******************************************/

}
