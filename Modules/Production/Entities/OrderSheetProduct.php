<?php

namespace Modules\Production\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderSheetProduct extends Model
{
    protected $fillable = ['order_sheets_id', 'product_id', 'stock_qty', 'ordered_qty', 'required_qty', 'price', 'total'];
    
}
