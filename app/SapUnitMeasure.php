<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SapUnitMeasure extends Model
{
    public $table = 'm_sap_unit_measurement_tab';
    public $timestamps = false;
    public $fillable =[
        'unit_measurement_comm',
        'unit_measurement',
        'unit_measurement_desc',
        'unit_measurement_dimension',
        'status'
    ];
}
