<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\Setting\RolePermissionController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\BaseController;

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

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('password.request');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [BaseController::class, 'dashboard'])->name('dashboard')->middleware('role:super-admin');
        Route::get('/blank', [BaseController::class, 'blank'])->name('blank');
        Route::get('buttons/', [BaseController::class, 'buttons'])->name('buttons');
        Route::get('/cards', [BaseController::class, 'cards'])->name('cards');
        Route::get('/charts', [BaseController::class, 'charts'])->name('charts');
        Route::get('/tables', [BaseController::class, 'tables'])->name('tables');
        Route::resource('permission-role', RolePermissionController::class)->middleware('can:roles');
        Route::resource('users', UserController::class)->middleware('can:users');
    });
});














