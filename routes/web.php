<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
});

Route::post('user/login', [AuthController::class,'method_login']);



// Index
Route::get('index', [AuthController::class,'method_login']);
