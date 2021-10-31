<?php

namespace Modules\Production\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderSheetMemo extends Model
{
    protected $table = 'order_sheet_memos';
    protected $fillable = ['order_sheet_id', 'sale_id'];
    
}
