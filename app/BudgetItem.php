<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model{
    public $table = 't_budget_item_tab';
    public $timestamps = false;
    protected $appends = ['total_proposed','total_verified'];
    public $fillable =[
        't_budget_id',
        'seq_no',
        'purchase_group',
        'plant',
        'item_category',
        'account_assignment',
        'info_req',
        'request_date',
        'package_no',
        'material_no',
        'material_group',
        'short_text',
        'qty_proposed',
        'unit_qty',
        'price_proposed',
        'price_unit',
        'currency',
        'delivery_date_exp',
        'note_item',
        'gl_account',
        'cost_center',
        'internal_order',
        'item_status',
        'price_verified'
    ];
    public function getTotalProposedAttribute(){
        $v = $this->service->sum('total_proposed');
        return $v ? $v : $this->price_proposed;
    }
    public function getTotalVerifiedAttribute(){
        $v = $this->service->sum('total_verified');
        return $v ? $v : $this->price_verified;
    }
    public $hidden = [
        'total_proposed',
        'total_verified'
    ];
    public function accounts(){
        return $this->hasOne(SapAccount::class, 'id', 'account_assignment');
    }
    public function materials(){
        return $this->hasOne(SapMaterial::class, 'id', 'material_no');
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
    public function currencies(){
        return $this->hasOne(SapCurrency::class, 'id', 'currency');
    }
    public function purchase_groups(){
        return $this->hasOne(SapPurchaseGroup::class, 'id', 'purchase_group');
    }
    public function item_categories(){
        return $this->hasOne(SapItemCategory::class, 'id', 'item_category');
    }
    public function service(){
        return $this->hasMany(BudgetService::class, 't_budget_item_id', 'id');
    }
    public function budget(){
        return $this->hasOne(Budget::class, 'id', 't_budget_id');
    }

    // public function getTotalProposed() {
    //     return $this->service->sum(function($item) {
    //       return $item->qty_proposed * $item->price_proposed;
    //     });
    // }
    // public function getTotalVerified() {
    //     return $this->service->sum(function($item) {
    //       return $item->qty_proposed * $item->price_verified;
    //     });
    // }
}
