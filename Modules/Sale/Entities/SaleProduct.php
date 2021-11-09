<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    protected $fillable = ['sale_id', 'product_id', 'unit_qty','qty', 'free_qty', 'base_unit_id', 'unit_id','net_unit_price', 'total'];


}
