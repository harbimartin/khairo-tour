<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    public $tables = 'divisions';
    public $filleable =[
        'no',
        'name',
        'prefix',
        'div_status',
        'pengelola_aset',
        'flag_divisi',
        'directorate_id'
    ];
}
