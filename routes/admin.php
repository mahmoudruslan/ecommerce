<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;




// Auth::routes();
    Route::group(['prefix' => 'admin'], function(){
        Route::get('/login', function(){
            return view('layouts.admin.auth.login');
        });

        Route::get('/', [HomeController::class, 'index'])->name('backend.index');

        Route::get('/cards', function(){
            return view('admin.cards');
        })->name('backend.cards');

        Route::get('/charts', function(){
            return view('admin.charts');
        })->name('backend.cartes');


    });