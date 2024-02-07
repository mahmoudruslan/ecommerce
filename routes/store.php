<?php

use Illuminate\Support\Facades\Route;

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



Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/lang/{lang}', function($lang){
    app()->setLocale($lang);
    session()->put('local', $lang);
    return redirect()->back();
})->name('setlang');







