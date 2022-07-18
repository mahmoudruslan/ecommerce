<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TagController;
use App\Models\Product;

    Route::get('testt', function () {
        return Route::getFacadeRoot()->current()->uri();
    });

    Route::get('test', function () {
        return auth()->user()->roles->first()->allowed_route;
    });
// Auth::routes();
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::group(['middleware' => 'guest'], function () {

        Route::get('/login', function () {
            return view('layouts.admin.login');
        })->name('login');

        Route::get('/forget-password', function () {
            return view('layouts.admin.forgot_password');
        })->name('forget.password');
    });


    Route::group(['middleware' => ['roles', 'role:admin|supervisor']], function () {
        Route::get('/', [HomeController::class, 'index'])->name('index');
        Route::get('/cards', [HomeController::class, 'cards'])->name('cards');
        Route::get('/charts', [HomeController::class, 'charts'])->name('cartes');
        Route::get('/blanks', [HomeController::class, 'blanks'])->name('blank');

        Route::resource('product_categories', ProductCategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('tags', TagController::class);
    });
});
