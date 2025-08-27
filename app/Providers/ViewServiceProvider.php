<?php

namespace App\Providers;

use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class ViewServiceProvider extends ServiceProvider
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
        $this->app->booted(function () {
            if (!request()->is('admin/*')) {
                view()->composer('*', function ($view) {
                    $sopping_categories_menu = Cache::rememberForever('sopping_categories_menu', function () {
                        return Category::tree();
                    });
                    $sopping_tags_menu = Cache::rememberForever('sopping_tags_menu', function () {
                        return Tag::whereStatus(true)->get();
                    });


                    $userId = auth()->id();
                    $cart = $userId
                        ? \Cart::session($userId)
                        : \Cart::session('cart');

                    $cart_count = $cart->getContent()->count();
                    $cart = $cart->getContent()->reverse();
                    $wishlist_count = \Cart::session('wishList')->getContent()->count();
//                    dd($cart->items());

                    $view->with([
                        'sopping_categories_menu' => $sopping_categories_menu,
                        'sopping_tags_menu' => $sopping_tags_menu,
                        'wishlist_count' => $wishlist_count,
                        'cart_count' => $cart_count,
                        'cart_items' => $cart,
                    ]);
                });
            }

        });
    }
}
