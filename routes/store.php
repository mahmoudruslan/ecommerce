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
    Route::get('/shopping/{type?}/{param?}', [ShoppingController::class, 'shoppingInProducts'])->name('shopping');
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
        Route::get('orders.refund-request/{order_id}', [CustomerController::class, 'refundRequest'])->name('orders.refund.request');
    });
});

Route::get('test', function(){

    $response = json_decode('{
        "id": "237156028",
        "pending": false,
        "amount_cents": 249900,
        "success": true,
        "is_auth": false,
        "is_capture": false,
        "is_standalone_payment": false,
        "is_voided": false,
        "is_refunded": false,
        "is_3d_secure": false,
        "integration_id": 4872463,
        "profile_id": 1005029,
        "has_parent_transaction": true,
        "order": {
            "id": 266520204,
            "created_at": "2024-11-20T23:19:51.718625",
            "delivery_needed": false,
            "merchant": {
                "id": 1005029,
                "created_at": "2024-11-08T03:18:03.974401",
                "phones": ["+201092199386"],
                "company_emails": ["mahmoudahmedruslan@gmail.com"],
                "company_name": "medical store",
                "state": "",
                "country": "EGY",
                "city": "Cairo",
                "postal_code": "",
                "street": ""
            },
            "collector": null,
            "amount_cents": 249900,
            "shipping_data": {
                "id": 132048921,
                "first_name": "سدين",
                "last_name": "الحصين",
                "street": "849536",
                "building": "NA",
                "floor": "NA",
                "apartment": "NA",
                "city": "الابراهيمية",
                "state": "الأسكندرية",
                "country": "Egypt",
                "email": "brashwani@example.com",
                "phone_number": "779.830.9980",
                "postal_code": "NA",
                "extra_description": "",
                "shipping_method": "UNK",
                "order_id": 266520204,
                "order": 266520204
            },
            "currency": "EGP",
            "is_payment_locked": false,
            "is_return": false,
            "is_cancel": false,
            "is_returned": false,
            "is_canceled": false,
            "merchant_order_id": "9_1732137590",
            "wallet_notification": null,
            "paid_amount_cents": 249900,
            "notify_user_with_email": false,
            "items": [],
            "order_url": "NA",
            "commission_fees": 0,
            "delivery_fees_cents": 0,
            "delivery_vat_cents": 0,
            "payment_method": "tbc",
            "merchant_staff_tag": null,
            "api_source": "OTHER",
            "data": {}
        },
        "created_at": "2024-11-20T23:22:51.882319",
        "transaction_processed_callback_responses": [],
        "currency": "EGP",
        "source_data": {
            "pan": "8769",
            "type": "card",
            "tenure": null,
            "sub_type": "Visa"
        },
        "api_source": "OTHER",
        "terminal_id": null,
        "merchant_commission": 0,
        "installment": null,
        "discount_details": [],
        "is_void": false,
        "is_refund": true,
        "data": {
            "gateway_integration_pk": 4872463,
            "klass": "MigsPayment",
            "created_at": "2024-11-20T21:22:52.952165",
            "amount": 249900.0,
            "currency": "EGP",
            "migs_order": {
                "amount": 2499.0,
                "chargeback": { "amount": 0, "currency": "EGP" },
                "creationTime": "2024-11-20T21:20:34.560Z",
                "currency": "EGP",
                "id": "266520204",
                "lastUpdatedTime": "2024-11-20T21:22:52.807Z",
                "merchantAmount": 2499.0,
                "merchantCategoryCode": "7299",
                "merchantCurrency": "EGP",
                "status": "REFUNDED",
                "totalAuthorizedAmount": 2499.0,
                "totalCapturedAmount": 2499.0,
                "totalRefundedAmount": 2499.0
            },
            "merchant": "TESTMERCH_C_25P",
            "migs_result": "SUCCESS",
            "migs_transaction": {
                "acquirer": {
                    "batch": 20241120,
                    "date": "1120",
                    "id": "BMNF_S2I",
                    "merchantId": "MERCH_C_25P",
                    "settlementDate": "2024-11-20",
                    "timeZone": "+0200",
                    "transactionId": "123456789012345"
                },
                "amount": 2499.0,
                "currency": "EGP",
                "id": "237156028",
                "receipt": "432521143906",
                "source": "INTERNET",
                "stan": "143906",
                "terminal": "BMNF0506",
                "type": "REFUND"
            },
            "txn_response_code": "APPROVED",
            "acq_response_code": "00",
            "message": "Approved",
            "merchant_txn_ref": "237156028",
            "order_info": "266520204",
            "receipt_no": "432521143906",
            "transaction_no": "123456789012345",
            "batch_no": 20241120,
            "authorize_id": null,
            "card_type": "VISA",
            "card_num": "498765xxxxxx8769",
            "secure_hash": "",
            "avs_result_code": "",
            "avs_acq_response_code": "00",
            "captured_amount": 2499.0,
            "authorised_amount": 2499.0,
            "refunded_amount": 2499.0,
            "acs_eci": ""
        },
        "is_hidden": false,
        "payment_key_claims": null,
        "error_occured": false,
        "is_live": false,
        "other_endpoint_reference": null,
        "refunded_amount_cents": 0,
        "source_id": -1,
        "is_captured": false,
        "captured_amount": 0,
        "merchant_staff_tag": null,
        "updated_at": "2024-11-20T23:22:52.959462",
        "is_settled": false,
        "bill_balanced": false,
        "is_bill": false,
        "owner": 1865476,
        "parent_transaction": 237155437
    }');

return $response->success;



});
Route::get('/lang/{lang}', function ($lang) {
    app()->setLocale($lang);
    session()->put('local', $lang);
    return redirect()->back();
})->name('setlang');
