<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternalOrderRpt extends Model
{
    public $table = 'm_internal_order_rpt';
    public $timestamps = false;
    public $fillable =[
        'io_code',
        'io_date',
        'id_budget_detail',
        'item',
        't_budget_id'
    ];
}
