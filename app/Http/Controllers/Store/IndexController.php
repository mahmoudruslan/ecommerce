<?php

namespace App\Http\Controllers\Store;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->whereStatus(1)->take(4)->get();
        $featured_products = Product::whereId(500)
            ->with([
                'variants',
                'variants.primaryAttribute', 'variants.primaryAttributeValue',
                'variants.secondaryAttribute', 'variants.secondaryAttributeValue'
                ])
            ->withAvg('reviews', 'rating')
            ->active()
            ->activeCategory()
//            ->featured()
            ->inRandomOrder()
            ->take(8)
            ->get();
            // return $featured_products;
//        return $featured_products;
//        return collect($featured_products->first()->variantAttributeValues)->groupBy('attribute_id');
        return view('store.index', compact('categories', 'featured_products'));
    }
}
