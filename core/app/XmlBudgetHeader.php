<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XmlBudgetHeader extends Model{
    public $table = 't_budget_header_xml_rpt';
    public $timestamps = false;
    public $fillable =[
        'budget_code',
        'doc_type',
        'note_header',
        'name'
    ];
    public function items(){
        return $this->hasMany(XmlBudgetItem::class, 't_budget_id','id');
    }
}
