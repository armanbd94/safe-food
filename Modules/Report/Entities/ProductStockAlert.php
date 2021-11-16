<?php

namespace Modules\Report\Entities;

use App\Models\Tax;
use App\Models\Unit;
use App\Models\Category;
use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Modules\Material\Entities\Material;
use Modules\Setting\Entities\DealerGroup;
use Modules\Product\Entities\WarehouseProduct;

class ProductStockAlert extends BaseModel
{
    protected $table = "products";
    protected $fillable = [ 'category_id', 'name', 'code',  'product_type', 'barcode_symbology', 
    'base_unit_id', 'unit_id', 'cost', 'base_unit_qty', 'alert_quantity', 'image',
    'tax_id', 'tax_method', 'status', 'description', 'created_by', 'modified_by'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class,'unit_id','id');
    }

    public function base_unit()
    {
        return $this->belongsTo(Unit::class,'base_unit_id','id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class)->withDefault(['name'=>'No Tax','rate' => 0]);
    }

    public function product_material(){
        return $this->belongsToMany(Material::class,'product_material','product_id','material_id','id','id')
                    ->withTimestamps();
    }

    public function product_prices(){
        return $this->belongsToMany(DealerGroup::class,'product_prices','product_id','dealer_group_id','id','id')
        ->withPivot('id','base_unit_price', 'unit_price')        
        ->withTimestamps();
    }

    public function warehouse_product()
    {
        return $this->hasMany(WarehouseProduct::class,'product_id','id')
        ->selectRaw('warehouse_product.product_id,SUM(warehouse_product.qty) as qty')
        ->groupBy('warehouse_product.product_id');
    }



    
    /******************************************
     * * * Begin :: Custom Datatable Code * * *
    *******************************************/
    //custom search column property

    protected $_name; 
    protected $_category_id; 

    //methods to set custom search property value
    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setCategoryID($category_id)
    {
        $this->_category_id = $category_id;
    }

    private function get_datatable_query()
    {
        //set column sorting index table column name wise (should match with frontend table header)

        $this->column_order = ['id', 'name', 'code','category_id', 'base_unit_id', 'base_unit_qty', 'alert_qty'];
        
        
        $query = self::with('category:id,name','base_unit:id,unit_name')
        ->where('status',1)
        ->whereColumn('alert_quantity','>','base_unit_qty');

        //search query
        if (!empty($this->_name)) {
            $query->where('name', 'like', '%' . $this->_name . '%');
        }

        if (!empty($this->_category_id)) {
            $query->where('category_id', $this->_category_id);
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
        return self::with('category:id,name','unit:id,unit_name')
        ->where('status',1)
        ->whereColumn('alert_quantity','>','base_unit_qty')->count();
    }
    /******************************************
     * * * End :: Custom Datatable Code * * *
    *******************************************/
}
