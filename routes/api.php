<?php

use App\Http\Controllers\Api\Customer\Auth\AuthController;
use App\Http\Controllers\Store\PaymobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::group([
    'prefix' => 'v1/auth',
    'as' => 'customer.auth.',
], function(){
    Route::get('login', [AuthController::class, 'login']);
    Route::get('verify', [AuthController::class, 'verify']);

    Route::group([
        'middleware' => 'auth:sanctum'
    ], function(){
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
