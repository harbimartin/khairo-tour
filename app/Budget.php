<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model{
    public $table = 't_budget_tab';
    public $timestamps = false;
    public $fillable =[
        'budget_code',
        'budget_date',
        'document_type',
        'note_header',
        'budget_version',
        'budget_attachment',
        'budget_available',
        'budget_status',
        'proposed',
        'proposed_by',
        'created',
        'created_by',
        'note_reject'
    ];
    public static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->created = $model->freshTimestamp();
        });
    }
    public function doc_types(){
        return $this->hasOne(SapDocType::class, 'id', 'document_type');
    }
    public function budget_versions(){
        return $this->hasOne(BudgetVersion::class, 'id', 'budget_version');
    }
    public function items(){
        return $this->hasMany(BudgetItem::class, 't_budget_id', 'id');
    }
}
