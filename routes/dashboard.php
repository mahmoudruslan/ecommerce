<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;


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

// Route::group(['middleware' => 'auth'], function(){
    Route::get('admin-dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('admin-dashboard/login', [AuthController::class, 'showLoginForm']);
    Route::get('admin-dashboard/forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('forget.password');
// });











