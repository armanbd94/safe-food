<?php

namespace Modules\GuestGift\Entities;

use Illuminate\Database\Eloquent\Model;

class GuestGiftProduct extends Model
{
    protected $table = 'guest_gift_products';
    protected $fillable = ['guest_gift_id', 'product_id', 'qty'];

}
