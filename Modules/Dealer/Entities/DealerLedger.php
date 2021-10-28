<?php

namespace Modules\Dealer\Entities;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Modules\Dealer\Entities\Dealer;
use Modules\Account\Entities\ChartOfAccount;

class DealerLedger extends BaseModel
{
    protected $table = 'transactions';
    protected $order = ['t.voucher_date' => 'asc'];

    protected $fillable = ['chart_of_account_id', 'voucher_no', 'voucher_type', 'voucher_date', 'description', 'debit', 
    'credit', 'posted', 'approve', 'created_by', 'modified_by'];
    
    public function coa()
    {
        return $this->belongsTo(ChartOfAccount::class,'chart_of_account_id','id');
    }

    public function dealer()
    {
        return $this->hasOneThrough(Dealer::class,ChartOfAccount::class,'dealer_id','chart_of_account_id','id','id');
    }

    /******************************************
     * * * Begin :: Custom Datatable Code * * *
    *******************************************/
    //custom search column property
    protected $_dealer_id; 
    protected $_from_date; 
    protected $_to_date; 

    //methods to set custom search property value
    public function setDealerID($dealer_id)
    {
        $this->_dealer_id = $dealer_id;
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
        //set column sorting index table column name wise (should match with frontend table header)

        $this->column_order = ['t.voucher_date','t.description', 't.voucher_no','t.debit','t.credit',null];
        
        $query = DB::table($this->table.' as t')
        ->select('t.*','coa.id as coa_id','coa.code','coa.name','coa.parent_name','d.id as dealer_id','d.name as dealer_name','d.mobile_no')
        ->join('chart_of_accounts as coa','t.chart_of_account_id','=','coa.id')
        ->join('dealers as d','coa.dealer_id','d.id')
        ->where('t.approve',1);

        //search query
        if (!empty($this->_dealer_id)) {
            $query->where('coa.dealer_id', $this->_dealer_id);
        }
        if (!empty($this->_from_date)) {
            $query->where('t.voucher_date', '>=',$this->_from_date);
        }
        if (!empty($this->_to_date)) {
            $query->where('t.voucher_date', '<=',$this->_to_date);
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
        return DB::table($this->table.' as t')
        ->select('t.*','coa.id as coa_id','coa.code','coa.name','coa.parent_name','d.id as dealer_id','d.name as dealer_name','d.mobile_no')
        ->join('chart_of_accounts as coa','t.chart_of_account_id','=','coa.id')
        ->join('dealers as d','coa.dealer_id','d.id')
        ->where('t.approve',1)
        ->count();
    }
    /******************************************
     * * * End :: Custom Datatable Code * * *
    *******************************************/
}
