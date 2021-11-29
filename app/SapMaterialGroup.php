<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SapMaterialGroup extends Model{
    public $table = 'm_sap_material_group_tab';
    public $timestamps = false;
    public $fillable = [
        'material_group',
        'status'
    ];
}
