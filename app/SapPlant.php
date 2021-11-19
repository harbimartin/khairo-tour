<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SapPlant extends Model
{
    public $table = 'm_sap_plant_tab';
    public $timestamps = false;
    public $fillable =[
        'plant',
        'plant_desc',
        'status'
    ];
}
