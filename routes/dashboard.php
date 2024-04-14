<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\RolePermissionController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CouponController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\TagController;

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
    Route::middleware(['auth', 'if_customer'])
    ->group( function () {
        Route::get('/', [BaseController::class, 'dashboard'])->name('dashboard');
        // Route::get('/blank', 'blank')->name('blank');
        // Route::get('buttons/', 'buttons')->name('buttons');
        // Route::get('/cards', 'cards')->name('cards');
        // Route::get('/charts', 'charts')->name('charts');
        // Route::get('/tables', 'tables')->name('tables');

        Route::resource('permission-roles', RolePermissionController::class);
        Route::controller(UserController::class)
        ->group( function(){
            Route::resource('users', UserController::class,['except' => ['show', 'edit']]);
            Route::get('/users/details/{id}/{slug}', 'show')->name('users.show');
            Route::get('/users/edit/{id}/{slug}', 'edit')->name('users.edit');
            Route::post('/users/delete-image/{user_id}', 'removeImage')->name('users.remove-image');
        });
        //categories routes
        Route::controller(CategoryController::class)
        ->group( function(){
            Route::resource('categories', CategoryController::class,['except' => ['show', 'edit']]);
            Route::get('/categories/details/{id}/{slug}', 'show')->name('categories.show');
            Route::get('/categories/edit/{id}/{slug}', 'edit')->name('categories.edit');
            Route::post('/categories/delete-image/{category_id}', 'removeImage')->name('categories.remove-image');
        });
        //products routes
        Route::controller(ProductController::class)
        ->group( function(){
            Route::resource('products', ProductController::class,['except' => ['show', 'edit']]);
            Route::get('products/details/{id}/{slug}', 'show')->name('products.show');
            Route::get('products/edit/{id}/{slug}', 'edit')->name('products.edit');
            Route::post('/products/delete-image/{product_id}', 'removeImage')->name('products.remove-image');
        });
        //coupon
        Route::resource('coupons', CouponController::class);

        //tags routes
        Route::controller(TagController::class)
        ->group( function(){
            Route::resource('tags', TagController::class,['except' => ['show', 'edit']]);
            Route::get('tags/details/{id}/{slug}', 'show')->name('tags.show');
            Route::get('tags/edit/{id}/{slug}', 'edit')->name('tags.edit');
        });

    });
});














