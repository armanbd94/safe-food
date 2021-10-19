<?php

namespace Modules\MaterialStockOut\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockOutMaterial extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\MaterialStockOut\Database\factories\StockOutMaterialFactory::new();
    }
}
