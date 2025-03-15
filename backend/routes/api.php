<?php

use App\Http\Controllers\FormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TblCarsController;
use App\Http\Controllers\searchDataController;
use App\Http\Controllers\ContactFormController;
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

// Handle preflight OPTIONS requests
Route::options('/{any}', function() {
    return response('', 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-XSRF-TOKEN');
})->where('any', '.*');

// Get the authenticated user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Resource routes for tbl_cars
Route::resource('cars', TblCarsController::class);
//user / customer route
    Route::resource('form', FormController::class);
    Route::resource('searchData', searchDataController::class);
    Route::get('cars_cors', [TblCarsController::class, 'car_testcors']);
    

    Route::resource('/contact', ContactFormController::class);

