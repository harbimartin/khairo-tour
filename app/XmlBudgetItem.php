<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XmlBudgetItem extends Model{
    public $table = 't_budget_item_xml_rpt';
    public $timestamps = false;
    public $fillable =[
        'note_item',
    ];
    public function services(){
        return $this->hasMany(XmlBudgetService::class, 't_budget_item_id','id');
    }
}
