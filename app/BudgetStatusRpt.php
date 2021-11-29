<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetStatusRpt extends Model {
    public $table = 't_budget_status_user_rpt';
    public $timestamps = false;
    public $fillable =[
        'budget_code',
        'budget_date',
        'document_type',
        'doc_type_desc',
        'note_header',
        'name',
        'total',
        'budget_attachment',
        'budget_status',
        'created',
        'created_by',
        'division_id',
        'budget_position_user_id',
        'user_status',
        'tgl_status',
        'status_ref',
        'status_active',
        'user_id'
    ];

    public function items(){
        $this->hasMany(BudgetItem::class, 't_budget_id', 'id');
    }
}
