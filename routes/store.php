<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;

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
Auth::routes();

Route::get('/', function () {
    return view('store.index');
})->name('store');
Route::get('/cart', function () {
    return view('store.cart');
})->name('cart');
Route::get('/checkout', function () {
    return view('store.checkout');
})->name('checkout');
Route::get('/detail', function () {
    return view('store.detail');
})->name('detail');

Route::get('/shop', function () {
    return view('store.shop');
})->name('shop');

Route::get('login', function () {
    return view('store.auth.login');
})->name('login');
Route::get('register', function () {
    return view('store.auth.register');
})->name('register');
Route::get('password/reset', function () {
    return view('store.auth.passwords.reset');
})->name('password.reset');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');




// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/lang/{lang}', function($lang){
    app()->setLocale($lang);
    session()->put('local', $lang);
    return redirect()->back();
})->name('setlang');







