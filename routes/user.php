<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
//587
Auth::routes(['verify' => true]);// #login route & register route & verify & reset password
Route::get('/', [HomeController::class, 'index'])->name('index');

Route::group(['middleware' => ['role:customer']], function(){
    Route::get('/shop', [HomeController::class, 'shop'])->name('user.shop');
    Route::get('/detail', [HomeController::class, 'detail'])->name('user.detail');
    Route::get('/cart', [HomeController::class, 'cart'])->name('user.cart');
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('user.checkout');
});