<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SapAccount extends Model
{
    public $table = 'm_sap_account_tab';
    public $timestamps = false;
    public $fillable =[
        'account',
        'account_desc',
        'status'
    ];
}
