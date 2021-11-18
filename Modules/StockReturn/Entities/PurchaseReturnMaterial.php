<?php

namespace Modules\StockReturn\Entities;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Model;
use Modules\Material\Entities\Material;

class PurchaseReturnMaterial extends Model
{
    protected $fillable = ['purchase_return_id', 'material_id', 'return_qty', 'unit_id', 'material_rate', 'deduction_rate', 'deduction_amount', 'total'];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    
}
