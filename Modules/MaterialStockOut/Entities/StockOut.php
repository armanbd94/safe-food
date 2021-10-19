<?php

namespace Modules\MaterialStockOut\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockOut extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\MaterialStockOut\Database\factories\StockOutFactory::new();
    }
}
