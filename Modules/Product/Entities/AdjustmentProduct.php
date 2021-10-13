<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class AdjustmentProduct extends Model
{

    protected $fillable = ['adjustment_id', 'product_id', 'base_unit_id', 'base_unit_qty', 'base_unit_cost', 'total_cost'];
    
}
