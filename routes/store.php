<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\IndexController;
use App\Http\Controllers\Store\OrderController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\Store\ShoppingController;
use App\Http\Controllers\Store\WishListController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\PaymobController;
use App\Http\Controllers\Store\customerController;
use Illuminate\Http\Request;

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

Route::group(['middleware' => [/*'auth',*/'if_admin'], 'as' => 'customer.'], function () {
    Route::get('/', [IndexController::class, 'index'])->name('store');
    Route::get('/shopping/{type?}/{parent?}/{category?}', [ShoppingController::class, 'shoppingInProducts'])->name('shopping');
    Route::post('add-to-cart/{product_id}', [CartController::class, 'addToCart'])->name('add.cart');
    Route::get('/cart', [CartController::class, 'cart'])->name('cart');
    Route::post('apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply.coupon');
    Route::post('remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('remove.coupon');
    Route::any('/shopping-sort-by/{type?}/{param?}', [ShoppingController::class, 'shoppingInProducts'])->name('products.sortBy');
    Route::get('/product/{slug}', [ShoppingController::class, 'productDetails'])->name('product.detail');
    Route::post('cart-increase-quantity/{product_id}', [CartController::class, 'increaseQuantity'])->name('cart.increase.quantity');
    Route::post('cart-decrease-quantity/{product_id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease.quantity');
    Route::post('remove-from-cart/{product_id}', [CartController::class, 'removeFromCart'])->name('remove.from.cart');
    Route::post('add-to-wishlist/{product_id}', [WishListController::class, 'addToWishList'])->name('add.wishlist');
    Route::get('/wishlist', [WishListController::class, 'wishlist'])->name('wishlist');
    Route::post('remove-from-wishlist/{product_id}', [WishListController::class, 'removeFromWishList'])->name('remove.from.wishlist');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/add-shipping-cost/{id}', [CheckoutController::class, 'addShippingCost'])->name('shipping.cost');
    Route::post('customer-add-address', [CheckoutController::class, 'addAddress'])->name('add.address');
    Route::post('complete-order', [OrderController::class, 'completeOrder'])->name('complete.order');
    Route::get('card', [PaymobController::class, 'process'])->name('pay');
    Route::get('paymob/callback', [OrderController::class, 'callback']);
    Route::group(['middleware' => ['auth']], function () {
        Route::get('profile', [CustomerController::class, 'editProfile'])->name('profile');
        Route::put('profile-update', [CustomerController::class, 'updateProfile'])->name('profile.update');
        Route::delete('profile-remove-image', [CustomerController::class, 'removeImage'])->name('profile.remove.image');
        Route::get('profile-addresses', [CustomerController::class, 'addresses'])->name('addresses');
        Route::delete('profile-delete-address/{id}', [CustomerController::class, 'removeAddress'])->name('profile.address.remove');
        Route::put('profile-update-address/{id}', [CustomerController::class, 'UpdateAddress'])->name('profile.address.update');
        Route::put('profile-add-address', [CustomerController::class, 'storeAddress'])->name('profile.address.store');
        Route::get('orders', [CustomerController::class, 'orders'])->name('orders');
        Route::get('orders/details/{id}', [CustomerController::class, 'orderDetails'])->name('order.details');
        Route::get('orders.refund-request/{order_id}', [CustomerController::class, 'refundRequest'])->name('orders.refund.request');
        Route::get('orders/buy-again/replace/{order_id}', [OrderController::class, 'buyAgainReplaceWithCart'])->name('order.buy.again.replace');
        Route::get('orders/buy-again/merge/{order_id}', [OrderController::class, 'buyAgainMergeWithCart'])->name('order.buy.again.merge');
    });
});


Route::get('/lang/{lang}', function ($lang) {
    app()->setLocale($lang);
    session()->put('local', $lang);
    return redirect()->back();
})->name('setlang');
