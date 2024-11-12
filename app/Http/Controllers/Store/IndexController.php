<?php

namespace App\Http\Controllers\Store;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function index()
    {
        $categories = Category::whereNull('parent_id')->whereStatus(1)->take(4)->get();
        $featured_products =
            Product::with('media')
            ->withAvg('reviews', 'rating')
            ->active()
            ->hasQuantity()
            ->activeCategory()
            ->featured()
            ->inRandomOrder()
            ->take(8)
            ->get();
        return view('store.index', compact('categories', 'featured_products'));
    }
}
