<?php

namespace Modules\DamageProduct\Entities;

use App\Models\BaseModel;
use Modules\Sale\Entities\Sale;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;


class Damage extends BaseModel
{
    protected $fillable = ['damage_no', 'sale_id', 'item','total_qty','grand_total', 'reason', 'damage_date', 'created_by', 'modified_by'];
    
     public function sale()
     {
         return $this->belongsTo(Sale::class,'sale_id','id');
     }

     public function damage_products()
    {
        return $this->belongsToMany(Product::class,'damage_products','damage_id','product_id','id','id')
        ->withPivot('id', 'damage_qty', 'base_unit_id', 'net_unit_price', 'total')
        ->withTimestamps(); 
    }
      /******************************************
      * * * Begin :: Custom Datatable Code * * *
     *******************************************/

     //custom search column property
     protected $_damage_no; 
     protected $_memo_no; 
     protected $_from_date; 
     protected $_to_date; 
 
     //methods to set custom search property value
     public function setDamageNo($damage_no){ $this->_damage_no = $damage_no; }
     public function setMemoNo($memo_no){ $this->_memo_no = $memo_no; }
     public function setStartDate($from_date){ $this->_from_date = $from_date; }
     public function setEndDate($to_date){ $this->_to_date = $to_date; }
 
     private function get_datatable_query()
     {
         //set column sorting index table column name wise (should match with frontend table header)
        $this->column_order = ['id','damage_no',null,null,null, 'item','total_qty','grand_total', 'damage_date',null];
         
        $query = self::with('sale');
         //search query
         if (!empty($this->_damage_no)) {
             $query->where('damage_no', 'like', '%' . $this->_damage_no . '%');
         }
         if (!empty($this->_memo_no)) {
             $memo_no = $this->_memo_no;
             $query->whereHas('sale',function($q) use ($memo_no){
                 $q->where('memo_no', 'like', '%' . $memo_no . '%');
             });
         }
 
         if (!empty($this->_start_date)) {
             $query->where('damage_date', '>=',$this->_start_date);
         }
         if (!empty($this->_end_date)) {
             $query->where('damage_date', '<=',$this->_end_date);
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
         return DB::table('damages')->count();
     }
     /******************************************
      * * * End :: Custom Datatable Code * * *
     *******************************************/
}
