<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\RolePermissionController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;

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
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
    Route::get('forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('password.request')->middleware('guest');
    Route::controller(BaseController::class)
    ->middleware(['auth', 'if_customer'])
    ->group( function () {
        Route::get('/', 'dashboard')->name('dashboard')->middleware('role:super-admin');
        Route::get('/blank', 'blank')->name('blank');
        Route::get('buttons/', 'buttons')->name('buttons');
        Route::get('/cards', 'cards')->name('cards');
        Route::get('/charts', 'charts')->name('charts');
        Route::get('/tables', 'tables')->name('tables');

        Route::resource('permission-role', RolePermissionController::class)->middleware('can:roles');
        Route::resource('users', UserController::class)->middleware('can:users');
        //categories routes
        Route::controller(CategoryController::class)
        ->middleware(['middleware' => 'can:categories'])
        ->group( function(){
            Route::resource('categories', CategoryController::class,['except' => ['show', 'edit']]);
            Route::get('/details/{id}/{slug}', 'show')->name('categories.show');
            Route::get('/edit/{id}/{slug}', 'edit')->name('categories.edit');
        });
        //products routes
        Route::controller(ProductController::class)
        ->middleware(['middleware' => 'can:categories'])
        ->group( function(){
            Route::resource('products', ProductController::class,['except' => ['show', 'edit']]);
            Route::get('/details/{id}/{slug}', 'show')->name('products.show');
            Route::get('/edit/{id}/{slug}', 'edit')->name('products.edit');
        });
    });
});














