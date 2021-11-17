<?php

namespace Modules\StockReturn\Entities;

use App\Models\BaseModel;
use Modules\Purchase\Entities\Purchase;
use Modules\Setting\Entities\Warehouse;
use Modules\Supplier\Entities\Supplier;
use Modules\StockReturn\Entities\PurchaseReturnMaterial;

class PurchaseReturn extends BaseModel
{
    protected $fillable = ['return_no', 'purchase_id', 'item','total_qty','total_cost', 'total_deduction', 'grand_total', 'reason', 'return_date', 'created_by', 'modified_by'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class,'purchase_id','id');
    }

 
    public function return_materials()
    {
        return $this->hasMany(PurchaseReturnMaterial::class,'purchase_return_id','id'); 
    }

    /******************************************
    * * * Begin :: Custom Datatable Code * * *
    *******************************************/
     //custom search column property
     protected $_return_no; 
     protected $_memo_no; 
     protected $_start_date; 
     protected $_end_date; 
 
     //methods to set custom search property value
     public function setReturnNo($return_no){ $this->_return_no = $return_no; }
     public function setMemoNo($memo_no){ $this->_memo_no = $memo_no;}
     public function setStartDate($start_date){ $this->_start_date = $start_date; }
     public function setEndDate($end_date){ $this->_end_date = $end_date; }
 
 
     private function get_datatable_query()
     {

        $this->column_order = ['id', 'return_no', null, null, 'item', 'total_qty', 'total_cost', 'total_deduction', 'grand_total', 'return_date', null];
         
         
         $query = self::with('purchase');
 
         //search query
         if (!empty($this->_return_no)) {
             $query->where('return_no', 'like', '%' . $this->_return_no . '%');
         }

         if (!empty($this->_memo_no)) {
            $memo_no = $this->_memo_no;
            $query->whereHas('purchase',function($q) use ($memo_no){
                $q->where('memo_no', 'like', '%' . $memo_no . '%');
            });
        }
 
        if (!empty($this->_start_date)) {
            $query->where('return_date', '>=',$this->_start_date);
        }
        
        if (!empty($this->_end_date)) {
            $query->where('return_date', '<=',$this->_end_date);
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
