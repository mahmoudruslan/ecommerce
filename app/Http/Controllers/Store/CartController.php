<?php

namespace App\Http\Controllers\Store;

use Carbon\Carbon;
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
        $cart_items = Cart::session('cart')->getContent();

        if (count($cart_items)  == 0) {
            Alert::toast(__('No products available in your cart.'), 'error');
            return redirect()->route('customer.store');
        }
        // return $cart_items;
        return view('store.cart', compact('cart_items'));
    }


    public function addToCart(Request $request, $product_id)
    {
        $cart = cartData();
        $product = Product::with('firstMedia')->find($product_id);
        $items = Cart::session('cart')->getContent()->pluck('id');

        $product_quantity_in_cart = Cart::session('cart')->get($product_id)->quantity ?? 0;

        if ($product_quantity_in_cart + $request->quantity > $product->quantity) {

            return response()->json([
                'message' => __('Only pieces of the are currently available', [
                    'quantity' =>  $product->quantity - $product_quantity_in_cart,
                    'product' => $product->name_ar,
                ]),
                'type' => 'warning',
                'title' => __('Warning'),
                'status' => true,
                'cart' => $cart
            ]);
        }

        if ($items->contains($product_id)) {
            updateCart($product, $request->quantity ?? 1);
            $cart = cartData();
            return response()->json([
                'message' => __('product data updated successfully in your cart.'),
                'type' => 'info',
                'title' => __('Success'),
                'status' => true,
                'cart' => $cart
            ]);
        } else {
            addToCart($product, $request->quantity ?? 1);
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
            if($product->quantity < $item->quantity + 1)
            {
                return response()->json([
                    'status' => false,
                    'message' => __('Only :quantity pieces of the :product are currently available', [
                        'quantity' =>  $product->quantity - $item->quantity,
                        'product' => $product['name_'. app()->getLocale()],
                    ]),
                    'type' => 'warning',
                    'title' => __('Warning'),
                    'cart' => cartData()
                ]);
            }
            // update the item on cart
            updateCart($product, 1);
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
            updateCart($product, -1);
            $cart = cartData();
            return response()->json([
                'cart' => $cart
            ]);
        }
    }
}
