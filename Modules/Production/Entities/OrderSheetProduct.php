<?php

namespace Modules\Production\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderSheetProduct extends Model
{
    protected $table = 'order_sheet_products';
    protected $fillable = ['order_sheet_id', 'product_id', 'stock_qty', 'ordered_qty', 'required_qty', 'price', 'total'];
    
}
