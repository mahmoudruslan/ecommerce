<?php

namespace App\Http\Controllers\Store;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Darryldecode\Cart\Facades\CartFacade as Cart;



// use Alert;

class CartController extends Controller
{

    public function cart()
    {
        Cart::session('cart')->clearCartConditions();
        $cart = cartData();
        if (!isset($cart['items']) || count($cart['items']) == 0) {
            Alert::toast(__('No products available in your cart.'), 'error');
            return redirect()->route('customer.store');
        }
        $cart_items = $cart['items'];
        return view('store.cart', compact('cart_items'));
    }


    public function addToCart(Request $request, $product_id)
    {
        $quantity_requested = $request->quantity;
        $cart = cartData();
        $product = Product::with(['firstMedia'])->find($product_id);

        $size = $product->sizes->where('id', $request->size_id)->first();
        $size_quantity = $size->pivot->quantity;
        $items = Cart::session('cart')->getContent()->pluck('id');
        $product_quantity_in_cart = Cart::session('cart')->get($product_id . '_' . $size->id)->quantity ?? 0;

        if (!$size || $product_quantity_in_cart + $quantity_requested > $size_quantity) {

            return response()->json([
                'message' => __('Only pieces of the are currently available', [
                    'quantity' =>  $size_quantity - $product_quantity_in_cart,
                    'product' => $product->name_ar,
                ]),
                'type' => 'warning',
                'title' => __('Warning'),
                'status' => true,
                'cart' => $cart
            ]);
        }
        if ($items->contains($product_id)) {

            updateCart($product, $size->id, $quantity_requested ?? 1);
            $cart = cartData();
            return response()->json([
                'message' => __('product data updated successfully in your cart.'),
                'type' => 'info',
                'title' => __('Success'),
                'status' => true,
                'cart' => $cart
            ]);
        } else {
            addToCart($product, $size, $quantity_requested ?? 1);
            $cart = cartData();
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
        $cart = cartData();
        return response()->json([
            'status' => true,
            'cart' => $cart
        ]);
    }
    public function increaseQuantity($product_id)
    {
        $product = Product::with('firstMedia')->find($product_id);
        $items = Cart::session('cart')->getContent()->pluck('id');
        if ($items->contains($product_id)) {
            $item = Cart::session('cart')->get($product_id);
            $size = $product->sizes->where('id', $item->attributes->size_id)->first();
            $size_quantity = $size->pivot->quantity;

            if ($size_quantity < $item->quantity + 1) {
                return response()->json([
                    'status' => false,
                    'message' => __('Only :quantity pieces of the :product are currently available', [
                        'quantity' =>  $size_quantity - $item->quantity,
                        'product' => $product['name_' . app()->getLocale()],
                    ]),
                    'type' => 'warning',
                    'title' => __('Warning'),
                    'cart' => cartData()
                ]);
            }

            // update the item on cart
            updateCart($product, $size->id, 1);
            $cart = cartData();

            return response()->json([
                'cart' => $cart
            ]);
        }
    }
    public function decreaseQuantity($product_id)
    {
        $cart = [];
        $product = Product::with('firstMedia')->find($product_id);
        $items = Cart::session('cart')->getContent()->pluck('id');
        if ($items->contains($product_id)) {
            // update the item on cart
            $item = Cart::session('cart')->get($product_id);
            updateCart($product, $item->attributes->size_id, -1);
            $cart = cartData();
            return response()->json([
                'cart' => $cart
            ]);
        }
    }
}
