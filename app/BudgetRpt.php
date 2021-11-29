<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetRpt extends Model
{
    public $table = 't_budget_rpt';
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
        'divisions_id'
    ];
}
