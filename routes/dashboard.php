<?php

use App\Http\Controllers\Dashboard\AttributeController;
use App\Http\Controllers\Dashboard\AttributeValueController;
use App\Http\Controllers\VariantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\RolePermissionController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\CouponController;
use App\Http\Controllers\Dashboard\GovernorateController;
use App\Http\Controllers\Dashboard\PaymentMethodController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ReviewController;
use App\Http\Controllers\Dashboard\ShippingCompanyController;
use App\Http\Controllers\Dashboard\SupervisorController;
use App\Http\Controllers\Dashboard\TagController;
use App\Http\Controllers\Dashboard\UserAddressController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\SizeController;
use App\Models\Order;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the bootstrap/app.php within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::view('/404', 'dashboard.404');
Route::view('/blank', 'dashboard.blank');
Route::view('/cards', 'dashboard.cards');
Route::view('/charts', 'dashboard.charts');
Route::view('/tables', 'dashboard.tables');
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
    // Route::get('forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('password.request')->middleware('guest');
    Route::middleware(['auth', 'if_customer'])
    ->group( function () {
        //main dashboard routes
        Route::view('/', 'dashboard.index')->name('dashboard')->can('main');//main page
        Route::post('/users/delete-image/{user_id}', [UserController::class, 'removeImage'])->name('users.remove-image');//delete user image
        Route::post('/supervisors/delete-image/{product_id}', [SupervisorController::class, 'removeImage'] )->name('supervisors.remove-image');//delete supervisor image
        Route::post('/categories/delete-image/{category_id}', [CategoryController::class, 'removeImage'])->name('categories.remove-image');//delete category image
        Route::post('/products/{product}/media/{media}', [ProductController::class, 'removeMedia'] )->name('products.remove-media');//delete product image
        Route::post('/products/variants/{variant}/media/{media}', [VariantController::class, 'removeMedia'] )->name('products.variants.remove-media');//delete product image
        Route::get('/user-addresses/create/{user_id}', [UserAddressController::class, 'createAddress'] )->name('user-addresses.create-address');//delete product image
        Route::resources([
            'permission-roles' => RolePermissionController::class,//roles and permissions routes
            'users' => UserController::class,//users routes
            'supervisors' => SupervisorController::class,//supervisor routes
            'categories' => CategoryController::class,//categories routes
            'products' => ProductController::class,//products routes
            'sizes' => SizeController::class,//categories routes
            'coupons' => CouponController::class,//coupon routes
            'tags' => TagController::class,//tags routes
            'reviews' => ReviewController::class,//tags routes
            'governorates' => GovernorateController::class,//governorate routes
            'cities' => CityController::class,//city routes
            'user-addresses' => UserAddressController::class,//user_address routes
            'shipping-companies' => ShippingCompanyController::class,//user_address routes
            'payment-methods' => PaymentMethodController::class,//user_address routes
            'orders' => OrderController::class,//user_address routes
            'attributes' => AttributeController::class,//attributes routes
            'attribute-values' => AttributeValueController::class,//attribute values route
        ]);
        Route::get('get-attribute-values/{id}', [AttributeValueController::class, 'getAttributeValues'])->name('get.attribute.values');//get attribute values by attribute id
        Route::group(['prefix' => 'products/{product}/', 'as' => 'products.'], function(){
            Route::resource('variants', VariantController::class);
        });

        Route::post('orders.refund/{order_id}', [OrderController::class, 'refund'])->name('orders.refund');
    });
});














