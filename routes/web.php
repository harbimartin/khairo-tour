<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class,'view_index']);
Route::resource('/masterdata/period', 'MasterPeriodController');
Route::resource('/masterdata/material', 'MasterMaterialController');
Route::resource('/masterdata/type', 'MasterTypeController');
Route::resource('/masterdata', 'MasterController');
Route::resource('/pengajuan/item', 'PengajuanItemController');
Route::resource('/pengajuan/service', 'PengajuanServiceController');
Route::resource('/pengajuan/assignment', 'PengajuanAssignController');
Route::resource('/pengajuan', 'PengajuanController');
Route::resource('/overview', 'OverviewController');
Route::resource('/persetujuan', 'PersetujuanController');
Route::get('/pengalihan_anggaran', [ViewController::class, 'pengalihan_angg']);
Route::get('/pengalihan_anggaran/view', [ViewController::class, 'pengalihan_angg_view']);

Route::get('/login', [AuthController::class,'view_login']);
Route::post('user/login', [AuthController::class,'method_login']);


