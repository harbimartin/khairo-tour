<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SapServiceGroup extends Model
{
    public $table = 'm_sap_service_group_tab';
    public $timestamps = false;
    public $fillable =[
        'service_group',
        'service_group1_desc',
        'status'
    ];
}
