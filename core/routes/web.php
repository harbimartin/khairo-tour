<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::resource('/masterdata/period', 'MasterPeriodController');
    Route::resource('/masterdata/material', 'MasterMaterialController');
    Route::resource('/masterdata/type', 'MasterTypeController');
    Route::resource('/masterdata/io', 'MasterIoController');
    Route::resource('/masterdata', 'MasterController');

    Route::prefix('pengajuan')->group(function () {
        Route::resource('/item', 'PengajuanItemController');
        Route::resource('/service', 'PengajuanServiceController');
        Route::resource('/assignment', 'PengajuanAssignController');
        Route::resource('/propose', 'PengajuanProposeController');
    });
    Route::resource('/pengajuan', 'PengajuanController');

    Route::resource('/pengajuan_head', 'PengajuanHeadController');
    Route::resource('/overview', 'OverviewController');
    Route::resource('/persetujuan', 'PersetujuanController');
    Route::prefix('verifikasi')->group(function () {
        Route::resource('/items', 'VerifikasiItemController');
        Route::resource('/services', 'VerifikasiServiceController');
        Route::resource('/proposes', 'VerifikasiProposeController');
    });
    Route::resource('/verifikasi', 'VerifikasiController');
    Route::resource('/email', 'EmailSendController');
    Route::get('/pengalihan_anggaran', [ViewController::class, 'pengalihan_angg']);
    Route::get('/pengalihan_anggaran/view', [ViewController::class, 'pengalihan_angg_view']);
});

Route::get('/login', [AuthController::class,'view_login']);
Route::post('user/login', [AuthController::class,'method_login']);
Route::get('/', 'AuthController@view_index');
