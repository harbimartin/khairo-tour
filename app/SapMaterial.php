<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SapMaterial extends Model
{
    public $table = 'm_sap_material_tab';
    public $timestamps = false;
    public $fillable =[
        'material',
        'material_type',
        'plant',
        'sloc',
        'material_desc',
        'uom',
        'material_group',
        'old_number',
        'mrp_type',
        'avail_check',
        'profit_center',
        'val_class',
        'costing_lot_size',
        'price_ctrl',
        'per',
        'moving_price',
        'last_change',
        'order_text',
        'status'
    ];
    public function uoms(){
        return $this->hasOne(SapUnitMeasure::class, 'id', 'uom')->select('id','unit_measurement');
    }
}
