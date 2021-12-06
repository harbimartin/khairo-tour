<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SapCurrency extends Model
{
    public $table = 'm_sap_currency_tab';
    public $timestamps = false;
    public $fillable =[
        'currency',
        'currency_desc',
        'status'
    ];
}
