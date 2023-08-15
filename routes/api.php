<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ApproverController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\Request_otController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\Shift_memberController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\Profile_pictureController;
use App\Models\Request_ot;
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
Route::resource('employee',EmployeeController::class);
Route::resource('department',DepartmentController::class);
Route::resource('approver',ApproverController::class);
Route::resource('command',CommandController::class);
Route::resource('shift',ShiftController::class);
Route::resource('shift_member',Shift_memberController::class);
Route::resource('request_ot',Request_otController::class);
Route::resource('history',HistoryController::class);
Route::resource('profile_picture',Profile_pictureController::class);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
