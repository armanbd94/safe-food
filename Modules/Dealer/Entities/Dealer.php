<?php

namespace Modules\Dealer\Entities;

use App\Models\BaseModel;
use Modules\Depo\Entities\Depo;
use Illuminate\Support\Facades\DB;
use Modules\Location\Entities\Area;
use Modules\Location\Entities\Upazila;
use Modules\Location\Entities\District;
use Modules\Account\Entities\ChartOfAccount;


class Dealer extends BaseModel
{

    protected $fillable = [  'name', 'mobile_no', 'email', 'type', 'depo_id', 'district_id', 'upazila_id',
     'address', 'commission_rate', 'status', 'created_by', 'modified_by'];

    protected $hidden = [
        'password',
        'remember_token',  
    ];
    public function coa(){
        return $this->hasOne(ChartOfAccount::class,'dealer_id','id');
    }

    public function depo()
    {
        return $this->belongsTo(Depo::class,'depo_id','id')->default(['name'=>'']);
    }
    public function district()
    {
        return $this->belongsTo(District::class,'district_id','id');
    }
    public function upazila()
    {
        return $this->belongsTo(Upazila::class,'upazila_id','id');
    }
    public function areas()
    {
        return $this->belongsToMany(Area::class,'dealer_areas','dealer_id','area_id','id','id')
        ->withPivot('id')            
        ->withTimestamps();
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

    /******************************************
     * * * Begin :: Custom Datatable Code * * *
    *******************************************/
    protected $order = ['d.id' => 'desc'];


    protected $_type;
    protected $_name;
    protected $_mobile_no;
    protected $_email;
    protected $_depo_id;
    protected $_district_id;
    protected $_upazila_id;
    protected $_status;

    public function setType($type)
    {
        $this->_type = $type;
    }
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

    public function setStatus($status)
    {
        $this->_status = $status;
    }

    private function get_datatable_query()
    { 
        if (permission('dealer-bulk-delete')){
            $this->column_order = ['d.id','d.id', 'd.name', 'd.mobile_no', 'd.email', 'd.type', 'd.depo_id', 'd.district_id', 'd.upazila_id','d.commission_rate',null, 'd.status',null];
        }else{
            $this->column_order = ['d.id', 'd.name', 'd.mobile_no', 'd.email', 'd.type', 'd.depo_id', 'd.district_id', 'd.upazila_id','d.commission_rate',null, 'd.status',null];
        }

        $query = DB::table('dealers as d')
        ->leftJoin('depos','d.depo_id','=','depos.id')
        ->join('locations as di','d.district_id','=','di.id')
        ->join('locations as u','d.upazila_id','=','u.id')
        ->leftjoin('chart_of_accounts as b', 'd.id', '=', 'b.dealer_id')
        ->selectRaw('d.*,depos.name as depo_name,di.name as district_name,u.name as upazila_name,
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
        if (!empty($this->_status)) {
            $query->where('d.status', $this->_status );
        }
        if (!empty($this->_type)) {
            $query->where('d.type', $this->_type );
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
}
