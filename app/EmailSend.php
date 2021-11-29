<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailSend extends Model
{
    public $fillable = [
        'name',
        'receiver',
        'title',
        'body',
        'view',
        'error',
        'status',
    ];
}
