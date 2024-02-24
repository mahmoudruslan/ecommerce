<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\Setting\RolePermissionController;

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

Route::group(['prefix' => 'admin-dashboard'], function () {
    Route::get('login', [AuthController::class, 'showLoginForm']);
    Route::get('forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('forget.password');
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/blank', function () {
        return view('dashboard.blank');
    })->name('blank');
    Route::get('buttons/', function () {
        return view('dashboard.buttons');
    })->name('buttons');
    Route::get('/cards', function () {
        return view('dashboard.cards');
    })->name('cards');
    Route::get('/charts', function () {
        return view('dashboard.charts');
    })->name('charts');
    Route::get('/tables', function () {
        return view('dashboard.tables');
    })->name('tables');
    Route::group(['middleware' => 'permission:create-role-permission|view-role-permissions|update-role-permission|delete-role-permission' , 'prefix' => 'settings'], function () {
        Route::resource('permission-role', RolePermissionController::class);
        Route::get('permission-role/data-table', [RolePermissionController::class,'roleDataTable'])->name('role.dataTables');

});


    
});











