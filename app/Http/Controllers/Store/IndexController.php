<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class IndexController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->whereStatus(1)->take(4)->get();
        $featured_products = 
        Product::with('media')
        // ->withAvg('reviews', 'rating')
        // ->Rating()
        ->with('reviews')
        ->active()
        ->hasQuantity()
        ->activeCategory()
        ->featured()
        ->inRandomOrder()
        ->take(8)
        ->get();
        return view('store.index', compact('categories', 'featured_products'));
    }

    public function cart()
    {
        return view('store.cart');
    }

    public function checkout()
    {
        return view('store.checkout');
    }

    public function detail()
    {
        return view('store.detail');
    }

    public function shop()
    {
        return view('store.shop');
    }



}
