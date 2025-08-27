<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Darryldecode\Cart\Cart;


class CartProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        dd(true);

//        $this->app->singleton('cart', function($app)
//        {
//            $storage = $app['session'];
//            $events = $app['events'];
//            $instanceName = 'cart_1';
//            $session_key = '88uuiioo99888';
//            return new Cart(
//                $storage,
//                $events,
//                $instanceName,
//                $session_key,
//                config('shopping_cart')
//            );
//        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
