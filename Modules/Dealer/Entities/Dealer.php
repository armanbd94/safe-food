<?php

namespace Modules\Dealer\Entities;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Modules\Location\Entities\Area;
use Modules\Location\Entities\Upazila;
use Modules\Location\Entities\District;
use Modules\Account\Entities\ChartOfAccount;
use Modules\Setting\Entities\DealerGroup;

class Dealer extends BaseModel
{

    protected $fillable = ['name', 'mobile_no', 'email', 'depo_id','district_id', 'upazila_id', 'area_id', 'address', 'commission_rate', 'type','dealer_group_id','status', 'created_by', 'modified_by'];

    protected $hidden = [
        'password',
        'remember_token',  
    ];

    public function coa(){
        return $this->hasOne(ChartOfAccount::class,'dealer_id','id');
    }

    public function district()
    {
        return $this->belongsTo(District::class,'district_id','id');
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class,'upazila_id','id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class,'area_id','id');
    }

    public function delaer_group()
    {
        return $this->belongsTo(DealerGroup::class,'dealer_group_id','id');
    }

    public function depo()
    {
        return $this->belongsTo(Depo::class,'depo_id','id')->withDefault(['name'=>'']);
    }

    public function balance(int $id)
    {
        $data = DB::table('dealers as d')
            ->selectRaw('d.id,b.id as coaid,b.code,((select ifnull(sum(debit),0) from transactions where chart_of_account_id= b.id AND approve = 1)-(select ifnull(sum(credit),0) from transactions where chart_of_account_id= b.id AND approve = 1)) as balance')
            ->leftjoin('chart_of_accounts as b', 'd.id', '=', 'b.dealer_id')
            ->where('d.id',$id)->first();
        $balance = 0;
        if($data)
        {
            $balance = $data->balance ? $data->balance : 0;
        }
        return $balance;
    }

    public function previous_balance(int $id)
    {
        $data = DB::table('transactions as t')
                ->leftjoin('chart_of_accounts as coa','t.chart_of_account_id','=','coa.id')
                ->select(DB::raw("SUM(t.debit) - SUM(t.credit) as balance"),'coa.id','coa.code')
                ->groupBy('t.chart_of_account_id')
                ->where('coa.dealer_id',$id)
                ->where('t.approve',1)
                ->first();
        return $data ? $data->balance : 0;
    }

    /******************************************
     * * * Begin :: Custom Datatable Code * * *
    *******************************************/
    protected $order = ['d.id' => 'desc'];

    protected $_name;
    protected $_mobile_no;
    protected $_email;
    protected $_depo_id;
    protected $_district_id;
    protected $_upazila_id;
    protected $_area_id;
    protected $_dealer_group_id;
    protected $_type;
    protected $_status;

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setMobileNo($mobile_no)
    {
        $this->_mobile_no = $mobile_no;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
    }

    public function setDepoID($depo_id)
    {
        $this->_depo_id = $depo_id;
    }

    public function setDistrictID($district_id)
    {
        $this->_district_id = $district_id;
    }

    public function setUpazilaID($upazila_id)
    {
        $this->_upazila_id = $upazila_id;
    }

    public function setAreaID($area_id)
    {
        $this->_area_id = $area_id;
    }

    public function setDealerGroupID($dealer_group_id)
    {
        $this->_dealer_group_id = $dealer_group_id;
    }

    public function setType($type)
    {
        $this->_type = $type;
    }

    public function setStatus($status)
    {
        $this->_status = $status;
    }

    private function get_datatable_query()
    { 
        if (permission('dealer-bulk-delete')){
            $this->column_order = ['d.id','d.id', 'd.name', 'd.type','d.mobile_no', 'd.email', 'd.depo_id','d.district_id', 'd.upazila_id','d.area_id','d.dealer_group_id','d.commission_rate',null, 'd.status',null];
        }else{
            $this->column_order = ['d.id', 'd.name', 'd.type','d.mobile_no', 'd.email', 'd.depo_id','d.district_id', 'd.upazila_id','d.area_id','d.dealer_group_id','d.commission_rate',null, 'd.status',null];
        }

        $query = DB::table('dealers as d')
        ->leftJoin('depos as dp','d.depo_id','=','dp.id')
        ->join('locations as di','d.district_id','=','di.id')
        ->join('locations as u','d.upazila_id','=','u.id')
        ->join('locations as a','d.area_id','=','a.id')
        ->leftJoin('dealer_groups as dg','d.dealer_group_id','=','dg.id')
        ->leftjoin('chart_of_accounts as b', 'd.id', '=', 'b.dealer_id')
        ->selectRaw('d.*,dp.name as depo_name,a.name as area_name,di.name as district_name,u.name as upazila_name,dg.group_name,
        ((select ifnull(sum(debit),0) from transactions where chart_of_account_id= b.id AND approve = 1)-(select ifnull(sum(credit),0) from transactions where chart_of_account_id= b.id AND approve = 1)) as balance');

        if (!empty($this->_name)) {
            $query->where('d.name', 'like', '%' . $this->_name . '%');
        }
        if (!empty($this->_mobile_no)) {
            $query->where('d.mobile_no', 'like', '%' . $this->_mobile_no . '%');
        }
        if (!empty($this->_email)) {
            $query->where('d.email', 'like', '%' . $this->_email . '%');
        }

        if (!empty($this->_depo_id)) {
            $query->where('d.depo_id', $this->_depo_id );
        }

        if (!empty($this->_district_id)) {
            $query->where('d.district_id', $this->_district_id );
        }
        if (!empty($this->_upazila_id)) {
            $query->where('d.upazila_id', $this->_upazila_id );
        }
        if (!empty($this->_area_id)) {
            $query->where('d.area_id', $this->_area_id );
        }
        if (!empty($this->_dealer_group_id)) {
            $query->where('d.dealer_group_id', $this->_dealer_group_id );
        }
        if (!empty($this->_type)) {
            $query->where('d.type', $this->_type );
        }
        if (!empty($this->_status)) {
            $query->where('d.status', $this->_status );
        }

        if (isset($this->orderValue) && isset($this->dirValue)) {
            $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
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
        return  DB::table('dealers')->count();
    }
    /******************************************
     * * * End :: Custom Datatable Code * * *
    *******************************************/

    public function coa_data(string $code,string $head_name,int $dealer_id) : array
    {
        return [
            'code'              => $code,
            'name'              => $head_name,
            'parent_name'       => 'Dealer Receivable',
            'level'             => 4,
            'type'              => 'A',
            'transaction'       => 1,
            'general_ledger'    => 2,
            'dealer_id'         => $dealer_id,
            'budget'            => 2,
            'depreciation'      => 2,
            'depreciation_rate' => '0',
            'status'            => 1,
            'created_by'        => auth()->user()->name
        ];
    }

    public function previous_balance_data($balance, int $coa_id, string $name) : array
    {
        $transaction_id = generator(10);
        $warehouse_id = 1;

        $cosdr = array(
            'chart_of_account_id' => $coa_id,
            'warehouse_id'        => $warehouse_id,
            'voucher_no'          => $transaction_id,
            'voucher_type'        => 'PR Balance',
            'voucher_date'        => date("Y-m-d"),
            'description'         => 'Debit Amount '.$balance.'Tk From Dealer '.$name,
            'debit'               => $balance,
            'credit'              => 0,
            'posted'              => 1,
            'approve'             => 1,
            'created_by'          => auth()->user()->name,
            'created_at'          => date('Y-m-d H:i:s')
        );
        $inventory = array(
            'chart_of_account_id' => DB::table('chart_of_accounts')->where('code', '10101')->value('id'),
            'warehouse_id'        => $warehouse_id,
            'voucher_no'          => $transaction_id,
            'voucher_type'        => 'PR Balance',
            'voucher_date'        => date("Y-m-d"),
            'description'         => 'Inventory Credit Amount '.$balance.'Tk For Old Sale From '.$name,
            'debit'               => 0,
            'credit'              => $balance,
            'posted'              => 1,
            'approve'             => 1,
            'created_by'          => auth()->user()->name,
            'created_at'          => date('Y-m-d H:i:s')
        ); 

        return [$cosdr,$inventory];
        
    }
}
