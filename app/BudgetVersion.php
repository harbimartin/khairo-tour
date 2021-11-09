<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetVersion extends Model
{
    //
    public $table = 'budget_version_tab';
    public $timestamps = false;
    public $fillable =[
        'budget_version_code',
        'budget_period_id',
        'divisions_id',
        'budget_version_type',
        'budget_name',
        'budget',
        'status'
    ];
    public function period(){
        return $this->hasOne(BudgetPeriod::class, 'id', 'budget_period_id')->select('id','budget_period');
    }
    public function division(){
        return $this->hasOne(Division::class, 'id', 'divisions_id')->select('id','name');
    }
    public function type(){
        return $this->hasOne(BudgetVType::class, 'id', 'budget_version_type')->select('id','version_type');
    }
}
