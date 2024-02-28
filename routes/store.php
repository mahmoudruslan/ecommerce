<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Store\BaseController;


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

Route::group(['middleware' => 'auth'], function(){

    Route::get('/cart', [BaseController::class, 'cart'])->name('cart');
    Route::get('/checkout', [BaseController::class, 'checkout'])->name('checkout');
    Route::get('/detail', [BaseController::class, 'detail'])->name('detail');
    Route::get('/shop', [BaseController::class, 'shop'])->name('shop');

});
Route::get('/', [BaseController::class, 'store'])->name('store');

Route::get('/lang/{lang}', function($lang){
    app()->setLocale($lang);
    session()->put('local', $lang);
    return redirect()->back();
})->name('setlang');







