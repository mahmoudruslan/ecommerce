<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

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
                if (!Cache::has('sopping_categories_menu')) {
                    $categories = Category::tree();
                    Cache::forever('sopping_categories_menu', $categories);
                }
                if (!Cache::has('sopping_tags_menu')) {
                    $tags = Tag::whereStatus(true)->get();
                    Cache::forever('sopping_tags_menu', $tags);
                }
                $sopping_categories_menu = Cache::get('sopping_categories_menu');
                $sopping_tags_menu = Cache::get('sopping_tags_menu');
                $view->with([
                    'sopping_categories_menu' => $sopping_categories_menu,
                    'sopping_tags_menu' => $sopping_tags_menu,

                ]);
            });
        }
    }
}
