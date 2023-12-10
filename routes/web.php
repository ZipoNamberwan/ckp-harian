<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MonitoringController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index']);

    Route::get('/activities/data/{monitoring}/{user}/{start}/{end}', [ActivityController::class, 'getData']);
    Route::post('/activities/download', [ActivityController::class, 'download']);
    Route::resource('activities', ActivityController::class);

    Route::group(['middleware' => ['role:Admin|Chief|Coordinator']], function () {
        Route::get('/monitoring', [MonitoringController::class, 'index']);
    });
});

