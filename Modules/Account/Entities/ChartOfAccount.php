<?php

namespace Modules\Account\Entities;

use App\Models\BaseModel;
use Modules\Depo\Entities\Depo;
use Modules\Dealer\Entities\Dealer;
use Modules\Customer\Entities\Customer;
use Modules\SalesMen\Entities\Salesmen;
use Modules\Supplier\Entities\Supplier;
use Modules\Account\Entities\Transaction;

class ChartOfAccount extends BaseModel
{
    protected $fillable = [ 'code', 'name', 'parent_name', 'level', 'type', 'transaction', 'general_ledger', 
    'customer_id', 'supplier_id', 'depo_id','dealer_id', 'bank_id','mobile_bank_id','budget', 'depreciation', 'depreciation_rate', 'status', 'created_by', 'modified_by'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class,'chart_of_account_id','id');
    }

    
    public static function bankHeadCode()
    {
        return self::where('level',4)->where('code','like', '1020102%')->max('code');
    }
    public static function mobileBankHeadCode()
    {
        return self::where('level',4)->where('code','like', '1020103%')->max('code');
    }

    public static function account_id_by_name($name)
    {
        $query = self::where('name',$name)->first();
        return $query->id;
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
    public function depo()
    {
        return $this->belongsTo(Depo::class,'depo_id','id');
    }
    public function dealer()
    {
        return $this->belongsTo(Dealer::class,'dealer_id','id');
    }


    /******************************************
     * * * Begin :: Custom Datatable Code * * *
    *******************************************/
    protected $order = ['id' => 'asc'];
    protected $_name; 

    //methods to set custom search property value
    public function setName($name)
    {
        $this->_name = $name;
    }

    private function get_datatable_query()
    {
        //set column sorting index table column name wise (should match with frontend table header)

        $this->column_order = ['id','name', 'code','parent_name','type',null,null,null];
        
        
        $query = self::toBase();
        //search query
        if (!empty($this->_name)) {
            $query->where('name', 'like','%'.$this->_name.'%');
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
