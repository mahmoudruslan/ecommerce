<?php

namespace App\Http\Controllers\Store;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShoppingController extends Controller
{
    public function shoppingInProducts(Request $request, $type = null, $parent = null, $slug = null)
    {
        // \Cart::session('cart')->clear();
        $products = Product::with('media');
        if ($type === 'tag' && !empty($slug)) {
            $products = Product::whereHas('tags', function ($query) use ($slug) {
                $query->whereSlug($slug)->whereStatus(true);
            });
        } else {
            if (is_null($slug)) {
                $products = $products->activeCategory();
            } else {
                $category = Category::whereSlug($slug)->active()->firstOrFail();

                if (is_null($category->parent_id)) {
                    $category_children_ids = Category::active()
                        ->whereParentId($category->id)
                        ->pluck('id')
                        ->toArray();
                    $products = $products->whereIn('category_id', $category_children_ids);
                } else {
                    $products = $products->whereHas('category', function ($query) use ($slug) {
                        $query->whereSlug($slug)->active();
                    });
                }
            }
        }

        switch ($request->input('sortBy')) {

            case 'popularity':
                $sort_field = 'id';
                $sort_type = 'desc';
                break;

            case 'low-high':
                $sort_field = 'price';
                $sort_type = 'asc';
                break;

            case 'high-low':
                $sort_field = 'price';
                $sort_type = 'desc';
                break;

            default:
                $sort_field = 'id';
                $sort_type = 'desc';
        }

        $products = $products
            // ->with('media')
            ->withAvg('reviews', 'rating')->active()
            // ->hasQuantity()
            ->orderBy($sort_field, $sort_type)->paginate(9);
        return view('store.shop', compact('products', 'slug', 'type'));
    }

    public function productDetails($slug)
    {
        $d_product = Product::whereSlug($slug)
            ->with('category')
            ->with('media')
            ->with('tags')
            ->withAvg('reviews', 'rating')
            ->active()
            ->activeCategory()
            ->firstOrFail();
        //related products
        $related_products = Product::whereNotIn('slug', [$d_product->slug])
            ->whereCategoryId($d_product->category_id)
            // ->hasQuantity()
            ->activeCategory()
            ->active()
            ->inRandomOrder()
            ->with('firstMedia')
            ->withAvg('reviews', 'rating')
            ->take(4)
            ->get();
        return view('store.product_detail', compact('d_product', 'related_products'));
    }
}
