<?php

namespace Modules\Sale\Entities;

use App\Models\BaseModel;
use Modules\Depo\Entities\Depo;
use Illuminate\Support\Facades\DB;
use Modules\Dealer\Entities\Dealer;
use Modules\Location\Entities\Area;
use Modules\Product\Entities\Product;
use Modules\Location\Entities\Upazila;
use Modules\Location\Entities\District;
use Modules\Setting\Entities\Warehouse;


class Sale extends BaseModel
{
    protected $fillable = [ 'memo_no', 'order_from', 'warehouse_id','depo_id', 'dealer_id', 'district_id', 'upazila_id', 'area_id',
    'item', 'total_qty', 'total_price', 'grand_total', 'previous_due', 'net_total', 'payable_amount','paid_amount', 'due_amount',
    'commission_rate', 'total_commission', 'payment_status', 'payment_method', 'account_id', 'reference_no',
    'document', 'note', 'sale_date', 'delivery_status', 'delivery_date', 'created_by', 'modified_by'];

    public function depo()
    {
        return $this->belongsTo(Depo::class,'depo_id','id')->withDefault(['name'=>'','mobile_no'=>'','address'=>'']);
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class,'dealer_id','id')->withDefault(['name'=>'','mobile_no'=>'','address'=>'']);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
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


    public function sale_products()
    {
        return $this->belongsToMany(Product::class,'sale_products','sale_id','product_id','id','id')
        ->withPivot('id', 'qty', 'sale_unit_id', 'net_unit_price', 'total')
        ->withTimestamps(); 
    }


     /******************************************
     * * * Begin :: Custom Datatable Code * * *
    *******************************************/
    protected $order = ['s.id' => 'desc'];
    //custom search column property
    protected $_memo_no; 
    protected $_from_date; 
    protected $_to_date; 
    protected $_depo_id; 
    protected $_dealer_id; 
    protected $_district_id; 
    protected $_upazila_id; 
    protected $_area_id; 
    protected $_payment_status; 
    protected $_delivery_status; 

    //methods to set custom search property value
    public function setInvoiceNo($memo_no)
    {
        $this->_memo_no = $memo_no;
    }

    public function setFromDate($from_date)
    {
        $this->_from_date = $from_date;
    }

    public function setToDate($to_date)
    {
        $this->_to_date = $to_date;
    }

    public function setDepoID($depo_id)
    {
        $this->_depo_id = $depo_id;
    }

    public function setDealerID($dealer_id)
    {
        $this->_dealer_id = $dealer_id;
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

    public function setPaymentStatus($payment_status)
    {
        $this->_payment_status = $payment_status;
    }

    public function setDeliveryStatus($delivery_status)
    {
        $this->_delivery_status = $delivery_status;
    }

    private function get_datatable_query()
    {
        if(permission('sale-bulk-delete'))
        {
            $this->column_order = ['s.id','s.id','s.memo_no', 's.order_from',null, 's.area_id','s.upazila_id','d.district_id','s.item',
            's.grand_total','s.previous_due','s.net_total', 's.commission_rate','s.total_commission','s.payable_amount','s.paid_amount', 's.due_amount',
            's.sale_date','s.payment_status','s.payment_method','s,delivery_status','s.delivery_date', null];
        }else{
            $this->column_order = ['s.id','s.memo_no', 's.order_from',null, 's.area_id','s.upazila_id','d.district_id','s.item',
            's.grand_total','s.previous_due','s.net_total', 's.commission_rate','s.total_commission','s.payable_amount','s.paid_amount', 's.due_amount',
            's.sale_date','s.payment_status','s.payment_method','s,delivery_status','s.delivery_date', null];
        }

        $query = DB::table('sales as s')
        ->selectRaw('s.*,dp.name as depo_name,dp.mobile_no as depo_mobile_no,dl.name as dealer_name,dl.mobile_no as dealer_mobile_no,
        d.name as district_name,u.name as upazila_name,a.name as area_name')
        ->leftJoin('depos as dp','s.depo_id','=','dp.id')
        ->leftJoin('dealers as dl','s.dealer_id','=','dl.id')
        ->join('locations as d', 's.district_id', '=', 'd.id')
        ->join('locations as u', 's.upazila_id', '=', 'u.id')
        ->join('locations as a', 's.area_id', '=', 'a.id');

        //search query
        if (!empty($this->_memo_no)) {
            $query->where('s.memo_no', $this->_memo_no);
        }

        if (!empty($this->_from_date) && !empty($this->_to_date)) {
            $query->whereDate('s.sale_date', '>=',$this->_from_date)
                ->whereDate('s.sale_date', '<=',$this->_to_date);
        }

        if (!empty($this->_depo_id)) {
            $query->where('s.depo_id', $this->_depo_id);
        }
       
        if (!empty($this->_dealer_id)) {
            $query->where('s.dealer_id', $this->_dealer_id);
        }
        
        if (!empty($this->_district_id)) {
            $query->where('s.district_id', $this->_district_id);
        }
        if (!empty($this->_upazila_id)) {
            $query->where('s.upazila_id', $this->_upazila_id);
        }

        if (!empty($this->_area_id)) {
            $query->where('s.area_id', $this->_area_id);
        }
        if (!empty($this->_payment_status)) {
            $query->where('s.payment_status', $this->_payment_status);
        }
        if (!empty($this->_delivery_status)) {
            $query->where('s.delivery_status', $this->_delivery_status);
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
        return DB::table('sales')->get()->count();
    }
    /******************************************
     * * * End :: Custom Datatable Code * * *
    *******************************************/


}
