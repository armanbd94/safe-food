<?php

namespace Modules\Production\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderSheetMemo extends Model
{
    protected $fillable = ['order_sheets_id', 'sale_id'];
    
}
