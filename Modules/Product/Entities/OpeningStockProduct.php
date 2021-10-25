<?php

namespace Modules\Product\Entities;

use Modules\Product\Entities\Product;
use Illuminate\Database\Eloquent\Model;

class OpeningStockProduct extends Model
{
    protected $table = 'opening_stock_products';
    protected $fillable = ['opening_stock_id', 'product_id', 'base_unit_id', 'base_unit_qty',
     'base_unit_price', 'tax_rate', 'tax', 'total'];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
