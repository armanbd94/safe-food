<?php

namespace Modules\Purchase\Entities;

use App\Models\BaseModel;
use Modules\Setting\Entities\Warehouse;

class Purchase extends BaseModel
{
    protected $fillable = [
        'memo_no', 'warehouse_id', 'supplier_id', 'item', 'total_qty', 'grand_total', 'discount_amount', 'net_total', 
        'paid_amount', 'due_amount', 'payment_status', 'payment_method', 'purchase_date', 'created_by', 'modified_by'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function supplier()
    {
        return $this->belongsTo(\Modules\Supplier\Entities\Supplier::class);
    }

    public function  purchase_materials()
    {
        return $this->belongsToMany(\Modules\Material\Entities\Material::class,'material_purchase','purchase_id',
        'material_id','id','id')
        ->withPivot('id','qty', 'purchase_unit_id', 'net_unit_cost', 'new_unit_cost', 'old_cost', 'total')
        ->withTimeStamps(); 
    }

    public function purchase_payments()
    {
        return $this->hasMany(PurchasePayment::class);
    }


     /******************************************
     * * * Begin :: Custom Datatable Code * * *
    *******************************************/
    //custom search column property
    protected $_memo_no; 
    protected $_from_date; 
    protected $_to_date; 
    protected $_supplier_id; 
    protected $_payment_status; 

    //methods to set custom search property value
    public function setMemoNo($memo_no)
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
    public function setSupplierID($supplier_id)
    {
        $this->_supplier_id = $supplier_id;
    }

    public function setPaymentStatus($payment_status)
    {
        $this->_payment_status = $payment_status;
    }


    private function get_datatable_query()
    {
        //set column sorting index table column name wise (should match with frontend table header)
        if (permission('purchase-bulk-delete')){
            $this->column_order = [null,'id','memo_no','supplier_id', 'item', 'total_qty', 'grand_total', 'discount_amount', 'net_total', 
            'paid_amount', 'due_amount', 'purchase_date','payment_status',  null];
        }else{
            $this->column_order = ['id','memo_no','supplier_id', 'item', 'total_qty', 'grand_total', 'discount_amount', 'net_total', 
            'paid_amount', 'due_amount', 'purchase_date','payment_status', null];
        }
        
        $query = self::with('supplier');

        //search query
        if (!empty($this->_memo_no)) {
            $query->where('memo_no', 'like', '%' . $this->_memo_no . '%');
        }

        if (!empty($this->_from_date)) {
            $query->where('purchase_date', '>=',$this->_from_date);
        }
        if (!empty($this->_to_date)) {
            $query->where('purchase_date', '<=',$this->_to_date);
        }
        if (!empty($this->_supplier_id)) {
            $query->where('supplier_id', $this->_supplier_id);
        }
        if (!empty($this->_payment_status)) {
            $query->where('payment_status', $this->_payment_status);
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
