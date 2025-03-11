<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
//admin
use App\Http\Controllers\admin\ManagerCtrl as AdminManagerCtrl;
use App\Http\Controllers\admin\CarCtrl as AdmincarCtrl;
use App\Http\Controllers\admin\UserCtrl as AdminUserCtrl;
use App\Http\Controllers\admin\DashboardCtrl as DashboardCtrl;
//manager
use App\Http\Controllers\manager\CarCtrl as managercarCtrl;
use App\Http\Controllers\manager\UserCtrl as managerUserCtrl;
use App\Http\Controllers\Manager\ManagerCtrl as ManagerCtrl;


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

Route::get('/', function () {
    return view('login');
    
});
//Admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
    //admin manager
    Route::get('/viewmanager', [AdminManagerCtrl::class, 'viewmanager'])->name('admin.viewmanager');
    Route::get('/editmanager', [AdminManagerCtrl::class, 'editmanager'])->name('admin.editmanager');
    Route::post('/updatemanager', [AdminManagerCtrl::class, 'updatemanager'])->name('admin.updatemanager');
    Route::get('/deletemanager/{id}', [AdminManagerCtrl::class, 'deletemanager'])->name('admin.deletemanager');
    //admin customer
    Route::get('/viewuser', [AdminUserCtrl::class, 'viewcustomer'])->name('admin.viewuser');
    Route::get('/editcustomer', [AdminUserCtrl::class, 'editcustomer'])->name('admin.editcustomer');
    Route::post('/updatecustomer', [AdminUserCtrl::class, 'updatecustomer'])->name('admin.updatecustomer');
    Route::get('/deletecustomer/{id}', [AdminUserCtrl::class, 'deletecustomer'])->name('admin.deletecustomer');
    //dashboard
    Route::get('/dashboard', [DashboardCtrl::class, 'index'])->name('admin.dashboard');
    //regis
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('admin.register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    //view car admin
    Route::get('/editcar', [AdmincarCtrl::class, 'editcar'])->name('admin.editcar');
    Route::post('/updatecar', [AdmincarCtrl::class, 'updatecar'])->name('admin.updatecar');
    Route::get('/viewcar', [AdmincarCtrl::class, 'viewcar'])->name('admin.viewcar');
    Route::get('/vieworder', [AdmincarCtrl::class, 'vieworder'])->name('admin.vieworder');
    Route::get('/deletecar/{id}', [AdmincarCtrl::class, 'deletecar'])->name('admin.deletecar');
    
});

// Manager
Route::group(['prefix' => 'manager', 'middleware' => ['auth', 'role:manager']], function () {
    //index manager
    Route::get('/index', [ManagerCtrl::class, 'index'])->name('manager.index');
    //logout
    Route::get('/logout', [ManagerCtrl::class, 'logout'])->name('manager.logout');
    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //view order
    Route::get('/vieworder', [managerUserCtrl::class, 'vieworder'])->name('manager.vieworder');
   
    //crud car
    Route::post('/viewcar',[managercarCtrl::class,'createcar'])->name('manager.createcar');
    Route::get('/viewcar', [managerCarCtrl::class, 'viewcar'])->name('manager.viewcar');
    Route::get('/editcar', [managerCarCtrl::class, 'editcar'])->name('manager.editcar');
    Route::post('/updatecar', [managerCarCtrl::class, 'updatecar'])->name('manager.updatecar');
    Route::get('/deletecar/{id}', [managerCarCtrl::class, 'deletecar'])->name('manager.deletecar');
});



require __DIR__.'/auth.php';
