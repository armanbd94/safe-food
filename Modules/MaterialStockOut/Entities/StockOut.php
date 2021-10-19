<?php

namespace Modules\MaterialStockOut\Entities;

use App\Models\BaseModel;
use Modules\Setting\Entities\Warehouse;
use Modules\MaterialStockOut\Entities\StockOutMaterial;

class StockOut extends BaseModel
{
    protected $fillable = [ 'stock_out_no', 'warehouse_id', 'date', 'item', 'total_qty', 'grand_total', 'note', 'created_by', 'modified_by'];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class); 
    }

    public function materials()
    {
        return $this->hasMany(StockOutMaterial::class); 
    }

    /******************************************
     * * * Begin :: Custom Datatable Code * * *
    *******************************************/
    //custom search column property
    protected $_stock_out_no; 
    protected $_warehouse_id; 
    protected $_from_date; 
    protected $_to_date; 

    //methods to set custom search property value
    public function setStockOutNo($stock_out_no)
    {
        $this->_stock_out_no = $stock_out_no;
    }
    public function setWarehouseID($warehouse_id)
    {
        $this->_warehouse_id = $warehouse_id;
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
        if (permission('adjustment-bulk-delete')){
            $this->column_order = [null,'id','stock_out_no','warehouse_id', 'item',null,'total_qty','grand_total','created_by','created_at', null];
        }else{
            $this->column_order = ['id','stock_out_no','warehouse_id', 'item',null,'total_qty','grand_total','created_by','created_at', null];
        }
        
        $query = self::with(['warehouse:id,name','materials']);

        //search query
        if (!empty($this->_stock_out_no)) {
            $query->where('stock_out_no', 'like', '%' . $this->_stock_out_no . '%');
        }
        if (!empty($this->_warehouse_id)) {
            $query->where('warehouse_id', $this->_warehouse_id);
        }

        if (!empty($this->_from_date)) {
            $query->whereDate('created_at', '>=',$this->_from_date);
        }
        if (!empty($this->_to_date)) {
            $query->whereDate('created_at', '<=',$this->_to_date);
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
        return self::toBase()->get()->count();
    }
    /******************************************
     * * * End :: Custom Datatable Code * * *
    *******************************************/
}
