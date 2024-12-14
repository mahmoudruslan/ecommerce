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
        if (!request()->is('admin/*')) {


            view()->composer('*', function ($view) {
                $sopping_categories_menu = Cache::rememberForever('sopping_categories_menu', function () {
                    return Category::tree();
                });
                $sopping_tags_menu = Cache::rememberForever('sopping_tags_menu', function () {
                    return Tag::whereStatus(true)->get();
                });
                $cart_count = Cart::getContent()->count();
                $wishlist_count = Cart::session('wishList')->getContent()->count();
                // $sopping_categories_menu = Cache::get('sopping_categories_menu');
                // $sopping_tags_menu = Cache::get('sopping_tags_menu');
                $view->with([
                    'sopping_categories_menu' => $sopping_categories_menu,
                    'sopping_tags_menu' => $sopping_tags_menu,
                    'wishlist_count' => $wishlist_count,
                    'cart_count' => $cart_count,
                ]);
            });
        }
    }
}
