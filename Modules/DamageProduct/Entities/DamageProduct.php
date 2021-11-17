<?php

namespace Modules\DamageProduct\Entities;

use App\Models\BaseModel;
use Modules\Product\Entities\Product;

class DamageProduct extends BaseModel
{
    protected $fillable = ['damage_id', 'product_id', 'damage_qty', 'base_unit_id', 'net_unit_price', 'total'];


}
