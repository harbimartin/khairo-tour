<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SapCostCenter extends Model{
    public $table = 'm_sap_cost_center_tab';
    public $timestamps = false;
    public $fillable =[
        'cost_center',
        'cost_center_desc',
        'status'
    ];
}
