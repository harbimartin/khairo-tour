<?php

use App\Http\Controllers\PersetujuanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('budget_rpt','PengajuanController@budget_rpt');
Route::get('budget_history','PengajuanController@budget_status_rpt');
Route::get('budget_notif','PengajuanController@budget_notif_rpt');
Route::get('budget_notif/count','PengajuanController@budget_notif_count');
Route::get('budget_detail','PengajuanController@budget_detail');
Route::post('budget_approve','PersetujuanController@update_exec');
Route::post('download_file', 'PengajuanController@download');
