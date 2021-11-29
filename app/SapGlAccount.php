<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SapGlAccount extends Model{
    public $table = 'm_sap_gl_account_tab';
    public $timestamps = false;
    public $fillable =[
        'gl_account',
        'gl_account_desc',
        'status'
    ];
}
