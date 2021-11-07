<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $fillable = ['product_id', 'dealer_group_id', 'base_unit_price', 'unit_price'];

}
