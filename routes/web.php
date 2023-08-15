<?php

use App\Http\Controllers\Request_otController;
use App\Mail\NotificationMail;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Models\Employee;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
    // $test=['name' => 'test'];
    // $test2=["AAA","BBB"];
    // return view('pdf',['aa'=>$test2]);
    // Mail::to('gammop191@gmail.com')->send(new NotificationMail(['emp_id'=>'64210']));
    // $pdf = PDF::loadView('welcome');




});

Route::controller(Request_otController::class)->group(function()
{
    Route::get('pdf','generatePDF');
});

// Route::get('file/{filename}', function ($filename) {
//     dd($filename);
// })->where('filename', '^(.+)\/([^\/]+)$');


