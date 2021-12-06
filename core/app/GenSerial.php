<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenSerial extends Model{
    public $table = 'gen_serial_tab';
    protected $primaryKey = 'SERIAL_ID'; // or null
    public $incrementing = false;
    public $timestamps = false;
    public $fillable =[
        'SERIAL_ID',
        'PREFIX',
        'START_VALUE',
        'NEXT_VALUE',
        'LENGTH',
    ];
}
