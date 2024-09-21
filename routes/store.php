<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Store\IndexController;


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
Auth::routes(['verify' => true]);
Route::get('/', [IndexController::class, 'index'])->name('store');
Route::group(['middleware' => ['auth', 'if_admin']], function(){

    Route::get('/cart', [IndexController::class, 'cart'])->name('cart');
    Route::get('/checkout', [IndexController::class, 'checkout'])->name('checkout');
    Route::get('/detail', [IndexController::class, 'detail'])->name('detail');
    Route::get('/shop', [IndexController::class, 'shop'])->name('shop');
});

Route::get('/lang/{lang}', function($lang){
    app()->setLocale($lang);
    session()->put('local', $lang);
    return redirect()->back();
})->name('setlang');
