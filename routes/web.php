<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

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
Route::group(
    [
        'prefix' => '{local}',
        'middleware' => ['setapplang']
    ],
    function () {


Route::get('admin-dashboard', function () {
    return view('dashboard.index');
});
Route::get('/', function () {
    return view('store.index');
});

Route::get('/f', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//switch default lang
Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'ar'])) {
        abort(400);
    }

    App::setLocale($locale);

    return redirect()->back();
});


//get current lang
Route::get('/current-lang', function (string $locale) {
    $locale = App::currentLocale();
    return $locale;
});
//check current lang
Route::get('/check-lang/{lang}', function (string $locale) {
    if (App::isLocale($locale)) {
        return true;
    }
    return false;

});

Route::get('test', function(){
     echo __('test');
     return;
});
});






