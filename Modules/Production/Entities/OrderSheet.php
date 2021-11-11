<?php

namespace Modules\Production\Entities;

use App\Models\BaseModel;
use Modules\Sale\Entities\Sale;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;


class OrderSheet extends BaseModel
{
    protected $fillable = ['sheet_no', 'order_date','delivery_date','delivery_status', 'item', 'total_qty', 'total_order_value', 'total_commission','created_by','modified_by'];

    public function products()
    {
        return $this->belongsToMany(Product::class,'order_sheet_products','order_sheet_id','product_id','id','id')
        ->withPivot('id', 'stock_qty', 'ordered_qty', 'required_qty', 'total')
        ->withTimestamps(); 
    }
    public function memos()
    {
        return $this->belongsToMany(Sale::class,'order_sheet_memos','order_sheet_id','sale_id','id','id')
        ->withPivot('id')
        ->withTimestamps(); 
    }

     /******************************************
     * * * Begin :: Custom Datatable Code * * *
    *******************************************/

    //custom search column property
    protected $_sheet_no; 
    protected $_from_date; 
    protected $_to_date; 
    protected $_delivery_status; 


    //methods to set custom search property value
    public function setSheetNo($sheet_no)
    {
        $this->_sheet_no = $sheet_no;
    }

    public function setFromDate($from_date)
    {
        $this->_from_date = $from_date;
    }

    public function setToDate($to_date)
    {
        $this->_to_date = $to_date;
    }

    public function setDeliveryStatus($delivery_status)
    {
        $this->_delivery_status = $delivery_status;
    }



    private function get_datatable_query()
    {

        $this->column_order = ['id','sheet_no', 'item', 'total_qty', 'total_order_value', 'total_commission','order_date','delivery_date','delivery_status', null];
        

        $query = DB::table('order_sheets');

        //search query
        if (!empty($this->_sheet_no)) {
            $query->where('sheet_no', $this->_sheet_no);
        }

        if (!empty($this->_from_date) && !empty($this->_to_date)) {
            $query->whereDate('order_date', '>=',$this->_from_date)
                ->whereDate('order_date', '<=',$this->_to_date);
        }

        if (!empty($this->_delivery_status)) {
            $query->where('delivery_status', $this->_delivery_status);
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
        return DB::table('order_sheets')->count();
    }
    /******************************************
     * * * End :: Custom Datatable Code * * *
    *******************************************/
}
