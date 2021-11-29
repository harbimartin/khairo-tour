<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetStatus extends Model{
    public $table = 't_budget_status_tab';
    protected $primaryKey = 't_budget_status_id';
    public $timestamps = false;
    public $fillable =[
        't_budget_id',
        'budget_position_user_id',
        'budget_status',
        'tgl_status',
        'status_ref',
        'status_active',
        'user_id',
        'user_email'
    ];

    public function items(){
        $this->hasMany(BudgetItem::class, 'id', 't_budget_id');
    }
    public function budget(){
        $this->hasOne(Budget::class, 'id', 't_budget_id');
    }
}
