<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\Store\IndexController;
use App\Http\Controllers\Store\ShoppingController;

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

    Route::get('/cart', [CartController::class, 'cart'])->name('cart');
    Route::get('/wishlist', [CartController::class, 'wishlist'])->name('wishlist');
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    // Route::get('/detail', [IndexController::class, 'detail'])->name('detail');
    Route::get('/shopping/{type?}/{param?}', [ShoppingController::class, 'shoppingInProducts'])->name('shopping');
    // Route::get('/shopping-tag/{tag}', [CartController::class, 'shoppingInTagProducts'])->name('shopping.tag');
    Route::any('/shopping-sort-by/{type?}/{param?}', [ShoppingController::class, 'shoppingInProducts'])->name('products.sortBy');

    Route::get('/product/{slug}', [ShoppingController::class, 'productDetails'])->name('product.detail');
    Route::post('add-to-wishlist/{product_id}', [CartController::class, 'addToWishList'])->name('add.wishlist');
    Route::post('add-to-cart/{product_id}', [CartController::class, 'addToCart'])->name('add.cart');
    Route::post('cart-increase-quantity/{product_id}', [CartController::class, 'increaseQuantity'])->name('cart.increase.quantity');
    Route::post('cart-decrease-quantity/{product_id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease.quantity');
    Route::post('remove-from-cart/{product_id}', [CartController::class, 'removeFromCart'])->name('remove.from.cart');
    Route::post('remove-from-wishlist/{product_id}', [CartController::class, 'removeFromWishList'])->name('remove.from.wishlist');
});

Route::get('/lang/{lang}', function($lang){
    app()->setLocale($lang);
    session()->put('local', $lang);
    return redirect()->back();
})->name('setlang');
