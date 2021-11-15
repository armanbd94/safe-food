<?php
namespace Modules\Dealer\Entities;

use App\Models\BaseModel;
use Modules\Dealer\Entities\Dealer;
use Modules\Account\Entities\ChartOfAccount;


class DealerAdvance extends BaseModel
{
    protected $table = 'transactions';
    protected $order = ['transactions.id' => 'desc'];
    protected $fillable = ['chart_of_account_id','warehouse_id', 'voucher_no', 'voucher_type', 'voucher_date',
     'description', 'debit', 'credit', 'is_opening', 'posted', 'approve', 'created_by', 'modified_by'];
    private const TYPE = 'Advance'; 

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
    protected $_start_date; 
    protected $_end_date; 

    //methods to set custom search property value
    public function setDealerID($dealer_id)
    {
        $this->dealer_id = $dealer_id;
    }

    public function setStartDate($start_date)
    {
        $this->_start_date = $start_date;
    }

    public function setEndDate($end_date)
    {
        $this->_end_date = $end_date;
    }

    private function get_datatable_query()
    {
        //set column sorting index table column name wise (should match with frontend table header)
        if(permission('dealer-advance-bulk-delete'))
        {
            $this->column_order = ['transactions.id','transactions.id','de.name','de.mobile_no','de.district_id','de.upazila_id','de.area_id',null,'transactions.created_at',null,null,null];
        }else{
            $this->column_order = ['transactions.id','de.name','de.mobile_no','de.district_id','de.upazila_id','de.area_id',null,'transactions.created_at',null,null,null];
        }
        
        
        
        $query = self::select('transactions.*','coa.id as coa_id','coa.code','de.id as dealer_id','de.name as dealer_name',
        'de.mobile_no','d.name as district_name','u.name as upazila_name','a.name as area_name')
        ->join('chart_of_accounts as coa','transactions.chart_of_account_id','=','coa.id')
        ->join('dealers as de','coa.dealer_id','de.id')
        ->join('locations as d', 'de.district_id', '=', 'd.id')
        ->join('locations as u', 'de.upazila_id', '=', 'u.id')
        ->join('locations as a', 'de.area_id', '=', 'a.id')
        ->where([
            'transactions.voucher_type'=>self::TYPE,
            'transactions.approve'=>1,
        ]);

        //search query
        if (!empty($this->_dealer_id)) {
            $query->where('de.id', $this->_dealer_id);
        }
        if (!empty($this->start_date)) {
            $query->where('transactions.voucher_date', '>=',$this->start_date);
        }
        if (!empty($this->end_date)) {
            $query->where('transactions.voucher_date', '<=',$this->end_date);
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
        return self::select('transactions.*','coa.id as coa_id','coa.code','de.id as dealer_id','de.name as dealer_name','de.mobile_no')
        ->join('chart_of_accounts as coa','transactions.chart_of_account_id','=','coa.id')
        ->join('dealers as de','coa.dealer_id','de.id')
        ->where([
            'transactions.voucher_type' => self::TYPE,
            'transactions.approve'      => 1,
        ])->get()->count();
    }
    /******************************************
     * * * End :: Custom Datatable Code * * *
    *******************************************/
}
