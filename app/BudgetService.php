<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetService extends Model{
    public $table = 't_budget_service_tab';
    public $timestamps = false;
    public $fillable =[
        't_budget_item_id',
        'seq_no',
        'qty_proposed',
        'unit_qty',
        'price_proposed',
        'price_unit',
        'short_text',
        'gl_account',
        'cost_center',
        'internal_order',
        'item_status',
        'price_verified'
    ];
    public function item(){
        return $this->hasOne(BudgetItem::class, 'id', 't_budget_item_id');
    }
    public function uom(){
        return $this->hasOne(SapUnitMeasure::class, 'id', 'unit_qty');
    }
    public function gl_accounts(){
        return $this->hasOne(SapGlAccount::class, 'id', 'gl_account');
    }
    public function cost_centers(){
        return $this->hasOne(SapCostCenter::class, 'id', 'cost_center');
    }
    public function internal_orders(){
        return $this->hasOne(InternalOrder::class, 'id', 'internal_order');
    }
}
