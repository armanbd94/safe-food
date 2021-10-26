<?php

namespace Modules\Depo\Entities;

use App\Models\BaseModel;
use Modules\Depo\Entities\Depo;
use Illuminate\Support\Facades\DB;
use Modules\Account\Entities\ChartOfAccount;


class DepoLedger extends BaseModel
{
    
    protected $table = 'transactions';
    protected $order = ['t.voucher_date' => 'asc'];

    private const TYPE = 'Account Payable'; //Voucher Type In Transaction Table

    protected $fillable = ['chart_of_account_id', 'voucher_no', 'voucher_type', 'voucher_date', 'description', 'debit', 
    'credit', 'posted', 'approve', 'created_by', 'modified_by'];
    

    public function coa()
    {
        return $this->belongsTo(ChartOfAccount::class,'chart_of_account_id','id');
    }

    public function depo()
    {
        return $this->hasOneThrough(Depo::class,ChartOfAccount::class,'depo_id','chart_of_account_id','id','id');
    }

    /******************************************
     * * * Begin :: Custom Datatable Code * * *
    *******************************************/
    //custom search column property
    protected $depo_id; 
    protected $from_date; 
    protected $to_date; 

    //methods to set custom search property value
    public function setDepoID($depo_id)
    {
        $this->depo_id = $depo_id;
    }
    public function setFromDate($from_date)
    {
        $this->from_date = $from_date;
    }
    public function setToDate($to_date)
    {
        $this->to_date = $to_date;
    }

    private function get_datatable_query()
    {
        //set column sorting index table column name wise (should match with frontend table header)

        $this->column_order = ['t.voucher_date','t.description', 't.voucher_no','t.debit','t.credit',null];
        
        $query = DB::table($this->table.' as t')
        ->select('t.*','coa.id as coa_id','coa.code','coa.name','coa.parent_name','d.id as depo_id','d.name as depo_name','d.mobile_no')
        ->join('chart_of_accounts as coa','t.chart_of_account_id','=','coa.id')
        ->join('depos as d','coa.depo_id','d.id')
        ->where(['coa.parent_name'=>self::TYPE,'t.approve'=>1]);

        //search query
        if (!empty($this->depo_id)) {
            $query->where('coa.depo_id', $this->depo_id);
        }
        if (!empty($this->from_date)) {
            $query->where('t.voucher_date', '>=',$this->from_date);
        }
        if (!empty($this->to_date)) {
            $query->where('t.voucher_date', '<=',$this->to_date);
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
        ->select('t.*','coa.id as coa_id','coa.code','coa.name','coa.parent_name','d.id as depo_id','d.name as depo_name','d.mobile_no')
        ->join('chart_of_accounts as coa','t.chart_of_account_id','=','coa.id')
        ->join('depos as d','coa.depo_id','d.id')
        ->where(['coa.parent_name'=>self::TYPE,'t.approve'=>1])->get()->count();
    }
    /******************************************
     * * * End :: Custom Datatable Code * * *
    *******************************************/
}
