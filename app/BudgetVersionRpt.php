<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetVersionRpt extends Model
{
    //
    public $table = 'budget_version_rpt';
    public $timestamps = false;
    public $fillable =[
        'id',
        'budget_version_code',
        'version_type',
        'budget_name',
        'sisa_budget',
        'name'
    ];
}
