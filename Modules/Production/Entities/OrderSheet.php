<?php

namespace Modules\Production\Entities;

use App\Models\BaseModel;
use Modules\Sale\Entities\Sale;
use Modules\Product\Entities\Product;


class OrderSheet extends BaseModel
{
    protected $fillable = ['sheet_no', 'order_date','delivery_date','delivery_status', 'item', 'total_qty', 'total', 'total_commission'];

    public function products()
    {
        return $this->belongsToMany(Product::class,'order_sheet_products','order_sheet_id','product_id','id','id')
        ->withPivot('id', 'stock_qty', 'ordered_qty', 'required_qty', 'total')
        ->withTimestamps(); 
    }
    public function memos()
    {
        return $this->belongsToMany(Sale::class,'order_sheet_memos','order_sheet_id','sale_id','id','id')
        ->withPivot('id')
        ->withTimestamps(); 
    }

    
}
