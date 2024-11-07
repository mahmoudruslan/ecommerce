<?php

namespace App\Http\Controllers\Store;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Darryldecode\Cart\Facades\CartFacade as Cart;



// use Alert;

class CartController extends Controller
{

    public function cart()
    {
        Cart::session('cart')->clearCartConditions();
        $cart_items = Cart::session('cart')->getContent();
        if (count($cart_items)  == 0) {
            return redirect()->route('store')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);;
        }
        // return $cart_items;
        return view('store.cart', compact('cart_items'));
    }


    public function addToCart(Request $request, $product_id)
    {
        $cart = [];
        $product = Product::with('firstMedia')->find($product_id);
        $items = Cart::session('cart')->getContent()->pluck('id');
        if ($items->contains($product_id)) {
            Cart::session('cart')->update($product_id, [
                'quantity' => $request->quantity ?? 1,
                'price' => $product->price
            ]);

            $cart['count'] = Cart::session('cart')->getContent()->count();
            $cart['total'] = Cart::session('cart')->getTotal();
            $cart['subTotal'] = Cart::session('cart')->getSubTotal();

            return response()->json([
                'message' => __('product data updated successfully in your cart.'),
                'type' => 'info',
                'title' => __('Success'),
                'status' => true,
                'cart' => $cart
            ]);
        } else {
            //add to as user wishlist
            Cart::session('cart')->add([
                'id' => $product->id,
                'name' => $product->name_ar,
                'price' => $product->price,
                'quantity' => $request->quantity ?? 1,
                'associatedModel' => $product,
            ]);
            $cart['count'] = Cart::session('cart')->getContent()->count();
            $cart['total'] = Cart::session('cart')->getTotal();
            $cart['subTotal'] = Cart::session('cart')->getSubTotal();
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
        Cart::session('cart')->remove($item_id);
        $cart = [];
        $cart['count'] = Cart::session('cart')->getContent()->count();
        $cart['total'] = Cart::session('cart')->getTotal();
        $cart['subTotal'] = Cart::session('cart')->getSubTotal();
        return response()->json([
            'status' => true,
            'cart' => $cart
        ]);
    }



    public function increaseQuantity($product_id)
    {
        $cart = [];
        $product = Product::with('firstMedia')->find($product_id);
        $items = Cart::session('cart')->getContent()->pluck('id');
        if ($items->contains($product_id)) {
            // update the item on cart
            Cart::session('cart')->update($product_id, [
                'quantity' => 1,
                'price' => $product->price
            ]);

            $cart['count'] = Cart::session('cart')->getContent()->count();
            $cart['total'] = Cart::session('cart')->getTotal();
            $cart['subTotal'] = Cart::session('cart')->getSubTotal();

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
        $items = Cart::session('cart')->getContent()->pluck('id');
        if ($items->contains($product_id)) {
            // update the item on cart
            Cart::session('cart')->update($product_id, [
                'quantity' => -1,
                'price' => $product->price
            ]);

            $cart['count'] = Cart::session('cart')->getContent()->count();
            $cart['total'] = Cart::session('cart')->getTotal();
            $cart['subTotal'] = Cart::session('cart')->getSubTotal();

            return response()->json([
                'cart' => $cart
            ]);
        }
    }
}
