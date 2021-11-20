<?php

namespace Modules\GuestGift\Entities;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;

class GuestGift extends BaseModel
{
    protected $fillable = ['voucher_no', 'guest_name', 'gift_from', 'item', 'total_qty', 'note', 'date', 'created_by', 'modified_by'];

    public function products()
    {
        return $this->belongsToMany(Product::class,'guest_gift_products','guest_gift_id','product_id','id','id')
        ->withPivot('id', 'qty')
        ->withTimestamps(); 
    }

    /******************************************
     * * * Begin :: Custom Datatable Code * * *
    *******************************************/
    protected $_voucher_no; 
    protected $_from_date; 
    protected $_to_date; 

    //methods to set custom search property value
    public function setVoucherNo($voucher_no)
    {
        $this->_voucher_no = $voucher_no;
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
        if(permission('guest-gift-bulk-delete'))
        {
            $this->column_order = ['id','voucher_no', 'guest_name', 'gift_from', 'item', 'total_qty','date','created_by', null];
        }else{
            $this->column_order = ['id','id','voucher_no', 'guest_name', 'gift_from', 'item', 'total_qty','date','created_by', null];
        }

        $query = self::toBase();

        //search query
        if (!empty($this->_voucher_no)) {
            $query->where('voucher_no', $this->_voucher_no);
        }

        if (!empty($this->_from_date) && !empty($this->_to_date)) {
            $query->whereDate('date', '>=',$this->_from_date)
                ->whereDate('date', '<=',$this->_to_date);
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
        return DB::table('guest_gifts')->get()->count();
    }
    /******************************************
     * * * End :: Custom Datatable Code * * *
    *******************************************/
}
