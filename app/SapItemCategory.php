<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SapItemCategory extends Model
{
    public $table = 'm_sap_item_category_tab';
    public $timestamps = false;
    public $fillable =[
        'item_category',
        'item_category_desc',
        'status'
    ];
}
