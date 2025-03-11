<?php

use App\Http\Controllers\FormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TblCarsController;
use App\Http\Controllers\searchDataController;


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