<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternalOrder extends Model{
    public $table = 'm_internal_order_tab';
    public $timestamps = false;
    public $fillable =[
        'io_code',
        'io_date',
        'status'
    ];
}
