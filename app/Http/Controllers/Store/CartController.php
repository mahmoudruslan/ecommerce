<?php

namespace App\Http\Controllers\Store;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

// use Alert;

class CartController extends Controller
{
    // use Alert;


    public function cart()
    {
        $cart_items = \Cart::getContent();
        // return $cart_items;
        return view('store.cart', compact('cart_items'));
    }

    public function wishList()
    {
        $wishlist_items = \Cart::session('wishList')->getContent();
        $cart_items = \Cart::getContent();
        // return $wishlist_items;
        return view('store.wishlist', compact('wishlist_items'));
    }
    public function checkout()
    {
        return view('store.checkout');
    }
    public function detail()
    {
        return view('store.detail');
    }

    public function addToWishList($product_id)
    {
        $items = \Cart::session('wishList')->getContent()->pluck('id');

        if ($items->contains($product_id)) {
            return response()->json([
                'message' => __('This product is already in your wish list.'),
                'type' => 'info',
                'title' => __('Success'),
                'status' => true,
                'wishListCount' => \Cart::session('wishList')->getContent()->count()
            ]);
        } else {
            $product = Product::find($product_id);

            //add to as user wishlist
            \Cart::session('wishList')->add([
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
                'wishListCount' => \Cart::session('wishList')->getContent()->count()
            ]);
        }
    }
    public function addToCart(Request $request, $product_id)
    {
        $cart = [];
        $product = Product::with('firstMedia')->find($product_id);
        $items = \Cart::getContent()->pluck('id');
        if ($items->contains($product_id)) {
            \Cart::update($product_id, [
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);

            $cart['count'] = \Cart::getContent()->count();
            $cart['total'] = \Cart::getTotal();
            $cart['subTotal'] = \Cart::getSubTotal();

            return response()->json([
                'message' => __('product data updated successfully in your cart.'),
                'type' => 'info',
                'title' => __('Success'),
                'status' => true,
                'cart' => $cart
            ]);
        } else {
            //add to as user wishlist
            \Cart::add([
                'id' => $product->id,
                'name' => $product->name_ar,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'associatedModel' => $product
            ]);
            $cart['count'] = \Cart::getContent()->count();
            $cart['total'] = \Cart::getTotal();
            $cart['subTotal'] = \Cart::getSubTotal();
            return response()->json([
                'message' => __('Product added to cart successfully.'),
                'type' => 'success',
                'title' => __('Success'),
                'status' => true,
                'cart' => $cart
            ]);
        }
    }

    public function removeFromCart($item_id)
    {
        \Cart::remove($item_id);
        $cart = [];
        $cart['count'] = \Cart::getContent()->count();
        $cart['total'] = \Cart::getTotal();
        $cart['subTotal'] = \Cart::getSubTotal();
        return response()->json([
            'status' => true,
            'cart' => $cart
        ]);
    }

    public function removeFromWishList($item_id)
    {
        \Cart::session('wishList')->remove($item_id);
        return response()->json([
            'wishListCount' => \Cart::session('wishList')->getContent()->count()
        ]);
    }

    public function increaseQuantity($product_id)
    {
        $cart = [];
        $product = Product::with('firstMedia')->find($product_id);
        $items = \Cart::getContent()->pluck('id');
        if ($items->contains($product_id)) {
            // update the item on cart
            \Cart::update($product_id, [
                'quantity' => 1,
                'price' => $product->price
            ]);

            $cart['count'] = \Cart::getContent()->count();
            $cart['total'] = \Cart::getTotal();
            $cart['subTotal'] = \Cart::getSubTotal();

            return response()->json([
                'cart' => $cart
            ]);
        }
    }
    public function decreaseQuantity($product_id)
    {
        // return response()->json([

        //     'cart' => $product_id
        // ]);
        $cart = [];
        $product = Product::with('firstMedia')->find($product_id);
        $items = \Cart::getContent()->pluck('id');
        if ($items->contains($product_id)) {
            // update the item on cart
            \Cart::update($product_id, [
                'quantity' => -1,
                'price' => $product->price
            ]);

            $cart['count'] = \Cart::getContent()->count();
            $cart['total'] = \Cart::getTotal();
            $cart['subTotal'] = \Cart::getSubTotal();

            return response()->json([
                'cart' => $cart
            ]);
        }
    }
}
