<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\RolePermissionController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\CouponController;
use App\Http\Controllers\Dashboard\GovernorateController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ReviewController;
use App\Http\Controllers\Dashboard\SupervisorController;
use App\Http\Controllers\Dashboard\TagController;
use App\Models\Governorate;

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
        //main dashboard routes
        Route::get('/', [BaseController::class, 'dashboard'])->name('dashboard');
        //roles and permissions routes
        Route::resource('permission-roles', RolePermissionController::class);
        //users routes
        Route::resource('users', UserController::class);
        Route::post('/users/delete-image/{user_id}', [UserController::class, 'removeImage'])->name('users.remove-image');
        //supervisor routes
        Route::resource('supervisors', SupervisorController::class);
        Route::post('/supervisors/delete-image/{product_id}', [SupervisorController::class, 'removeImage'] )->name('supervisors.remove-image');
        //categories routes
        Route::resource('categories', CategoryController::class);
        Route::post('/categories/delete-image/{category_id}', [CategoryController::class, 'removeImage'])->name('categories.remove-image');
        //products routes
        Route::resource('products', ProductController::class);
        Route::post('/products/delete-image/{product_id}', [ProductController::class, 'removeImage'] )->name('products.remove-image');
        //coupon
        Route::resource('coupons', CouponController::class);
        //tags routes
        Route::resource('tags', TagController::class);
        //tags routes
        Route::resource('reviews', ReviewController::class);
        //governorate routes
        Route::resource('governorates', GovernorateController::class);
        //city routes
        Route::resource('cities', CityController::class);
    });
});














