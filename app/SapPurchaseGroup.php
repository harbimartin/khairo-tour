<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SapPurchaseGroup extends Model
{
    public $table = 'm_sap_purchase_group_tab';
    public $timestamps = false;
    public $fillable =[
        'purchase_group',
        'purchase_group_desc',
        'status'
    ];
}
