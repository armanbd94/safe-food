<?php

namespace Modules\Depo\Entities;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Modules\Location\Entities\District;


class Depo extends BaseModel
{
    protected $fillable = ['name', 'mobile_no', 'email', 'district_id', 'address', 'status', 'created_by', 'modified_by'];
    
    public function district()
    {
        return $this->belongsTo(District::class,'district_id','id');
    }

    /******************************************
     * * * Begin :: Custom Datatable Code * * *
    *******************************************/
    //custom search column property
    protected $order = ['w.id' => 'desc'];
    protected $name; 

    //methods to set custom search property value
    public function setName($name)
    {
        $this->name = $name;
    }


    private function get_datatable_query()
    {
        //set column sorting index table column name wise (should match with frontend table header)
        if (permission('depo-bulk-delete')){
            $this->column_order = [null,'d.id','d.name','d.district_id', 'd.mobile_no','d.email','d.address','d.status',null];
        }else{
            $this->column_order = ['d.id','d.name','d.district_id', 'd.mobile_no','d.email','d.address','d.status',null];
        }
        
        $query = DB::table('depos as d')
                ->select('d.id','d.name', 'd.mobile_no', 'd.email', 'd.address','d.district_id',
                'd.status', 'l.name as district_name')
                ->leftjoin('locations as l','d.district_id','=','l.id');

        //search query
        if (!empty($this->name)) {
            $query->where('d.name', 'like', '%' . $this->name . '%');
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

    /*************************************
    * * *  Begin :: Cache Data * * *
    **************************************/
    protected const ACTIVE_DEPOS    = '_active_depos';

    public static function activeDepos(){
        return Cache::rememberForever(self::ACTIVE_DEPOS, function () {
            return self::toBase()->where('status',1)->get();
        });
    }


    public static function flushCache(){
        Cache::forget(self::ACTIVE_DEPOS);
    }


    public static function boot(){
        parent::boot();

        static::updated(function () {
            self::flushCache();
        });

        static::created(function() {
            self::flushCache();
        });

        static::deleted(function() {
            self::flushCache();
        });
    }
    /***********************************
    * * *  Begin :: Cache Data * * *
    ************************************/
}
