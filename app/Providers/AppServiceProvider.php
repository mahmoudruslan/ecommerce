<?php

namespace App\Providers;

use App\Services\Cart\DBStorage;
use Darryldecode\Cart\Cart;
use Illuminate\Pagination\Paginator;
use Illuminate\Session\SessionManager;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('cart.storage', function () {
            return new \App\Services\Cart\DBStorage();
        });
//        $this->app->singleton(Cart::class, function($app) {
//            $session = $app->make(SessionManager::class);
//            $events = $app['events'];
//            $instanceName = 'cart';
//            $session_key = '88uuiioo99888';
//            $config = config('shopping_cart');
//
//            return new Cart(
//                $session,
//                $events,
//                $instanceName,
//                $session_key,
//                $config
//            );
//        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
