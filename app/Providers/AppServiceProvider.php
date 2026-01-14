<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
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

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
