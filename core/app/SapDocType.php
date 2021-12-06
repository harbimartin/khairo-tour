<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SapDocType extends Model
{
    public $table = 'm_sap_doc_type_tab';
    public $timestamps = false;
    public $fillable =[
        'doc_type',
        'doc_type_desc',
        'status'
    ];
}
