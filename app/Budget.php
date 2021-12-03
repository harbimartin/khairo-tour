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
        'verified',
        'verified_by',
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
    public function services(){
        return $this->hasManyThrough(BudgetService::class, BudgetItem::class, 't_budget_id', 't_budget_item_id', 'id', 'id');
    }
    public function getTotalPropose() {
      return $this->items->sum(function($item) {
        return $item->qty_proposed * $item->price_proposed;
      });
    }
    public function getLevelPropose() {
        $total = $this->getTotalPropose();
        if ($total <= 100000000)    //100 juta
            return 4;
        if ($total <= 500000000)    //100 Juta < Total <= 500 Juta
            return 3;
        if ($total <= 5000000000)   //500 Juta < Total <= 5 Miliar
            return 2;
        return 1;
    }
    public function getTotalVerify() {
      return $this->items->sum(function($item) {
        return $item->qty_proposed * $item->price_verified;
      });
    }
    public function getLevelVerify() {
        $total = $this->getTotalVerify();
        if ($total <= 100000000)    //100 juta
            return 8;
        if ($total <= 500000000)    //100 Juta < Total <= 500 Juta
            return 7;
        if ($total <= 5000000000)   //500 Juta < Total <= 5 Miliar
            return 6;
        return 5;
    }
}
