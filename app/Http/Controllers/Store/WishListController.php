<?php

namespace App\Http\Controllers\Store;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class WishListController extends Controller
{
    public function removeFromWishList($item_id)
    {
        Cart::session('wishList')->remove($item_id);
        return response()->json([
            'wishListCount' => Cart::session('wishList')->getContent()->count()
        ]);
    }
    public function addToWishList($product_id)
    {
        $items = Cart::session('wishList')->getContent()->pluck('id');

        if ($items->contains($product_id)) {
            return response()->json([
                'message' => __('This product is already in your wish list.'),
                'type' => 'info',
                'title' => __('Success'),
                'status' => true,
                'wishListCount' => Cart::session('wishList')->getContent()->count()
            ]);
        } else {
            $product = Product::find($product_id);

            //add to as user wishlist
            Cart::session('wishList')->add([
                'id' => $product->id,
                'name' => $product->name_ar,
                'price' => $product->price,
                'quantity' => 1,
                'associatedModel' => $product
            ]);
            return response()->json([
                'message' => __('Product added to wish list successfully.'),
                'type' => 'success',
                'title' => __('Success'),
                'status' => true,
                'wishListCount' => Cart::session('wishList')->getContent()->count()
            ]);
        }
    }
    public function wishList()
    {
        $wishlist_items = Cart::session('wishList')->getContent();
        if (count($wishlist_items)  == 0) {
            Alert::toast(__('No products available in your wishlist.'), 'error');
            return redirect()->route('customer.store');
        }
        return view('store.wishlist', compact('wishlist_items'));
    }
}
