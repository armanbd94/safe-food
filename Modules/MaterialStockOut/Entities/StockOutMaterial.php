<?php

namespace Modules\MaterialStockOut\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Material\Entities\Material;

class StockOutMaterial extends Model
{
    protected $fillable = ['stock_out_id', 'batch_no', 'material_id', 'unit_id', 'qty', 'net_unit_cost', 'total'];

    public function stock_out()
    {
        return $this->belongsTo(StockOut::class,'stock_out_id','id'); 
    }
    public function material()
    {
        return $this->belongsTo(Material::class,'material_id','id'); 
    }
}
