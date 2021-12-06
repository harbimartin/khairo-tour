<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model{
    public $table = 'files_tab';
    public $fillable = [
        'code',
        'name',
        'ext'
    ];
}
