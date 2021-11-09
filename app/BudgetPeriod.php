<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetPeriod extends Model
{
    public $table = 'budget_period_tab';
    public $timestamps = false;
    public $fillable =[
        'budget_period',
        'budget_period_desc',
        'status',
    ];
}
