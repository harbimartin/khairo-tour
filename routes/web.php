<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('pages.home');
});
Route::get('/masterdata', function () {
    return view('pages.masterdata');
});

Route::post('user/login', [AuthController::class,'method_login']);



// Index
Route::get('index', [AuthController::class,'method_login']);
