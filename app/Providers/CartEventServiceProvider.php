<?php

namespace App\Providers;

use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Support\ServiceProvider;

class CartEventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['events']->listen('cart.added', function ($cart) {
            $this->saveCartToDatabase();
        });

        $this->app['events']->listen('cart.updated', function ($cart) {
            $this->saveCartToDatabase();
        });

        $this->app['events']->listen('cart.removed', function ($cart) {
            $this->saveCartToDatabase();
        });
    }

    protected function saveCartToDatabase()
    {
        if (auth()->check()) {
            $userId = auth()->id();
            $cartContent = CartFacade::session($userId)->getContent()->toArray();

            \DB::table('carts')->updateOrInsert(
                ['user_id' => $userId],
                ['content' => json_encode($cartContent)]
            );
        }
    }
}
