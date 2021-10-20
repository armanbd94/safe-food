<?php

namespace Modules\Transfer\Entities;

use Illuminate\Database\Eloquent\Model;

class TransferProduct extends Model
{
    protected $fillable = ['transfer_id', 'product_id', 'unit_id', 'qty', 'price', 'tax_rate', 'tax', 'total'];

}
