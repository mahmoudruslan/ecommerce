<?php

namespace App\Http\Controllers\Store;

use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->whereStatus(1)->take(4)->get();
        $featured_products = Product::with([
                'firstMedia',
                'images',
                'variants',
                'variants.primaryAttribute', 'variants.primaryAttributeValue',
                'variants.secondaryAttribute', 'variants.secondaryAttributeValue'
                ])
            ->withAvg('reviews', 'rating')
            ->active()
            ->activeCategory()
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('store.index', compact('categories', 'featured_products'));
    }
}
