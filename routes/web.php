<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
});
// Index
Route::get('/', [AuthController::class,'view_index']);
Route::get('/masterdata', function () {
    return view('pages.masterdata');
});

Route::post('user/login', [AuthController::class,'method_login']);


