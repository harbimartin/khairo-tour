<?php

namespace App\Http\Controllers;

use App\BudgetPeriod;
use App\BudgetVersion;
use App\BudgetVType;
use App\Division;
use Illuminate\Http\Request;

class ViewController extends Controller{
    public function pengalihan_angg(){
        return view('pages.pengalihan_angg');
    }
    public function pengalihan_angg_view(){
        return view('pages.pengalihan_angg.view');
    }
}
