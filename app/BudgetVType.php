<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetVType extends Model
{
    public $table = 'budget_version_type_tab';
    public $timestamps = false;
    public $fillable =[
        'version_type',
        'status'
    ];
}
