<?php

namespace App\Http\Controllers\Store;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Darryldecode\Cart\Facades\CartFacade as Cart;



// use Alert;

class CartController extends Controller
{

    public function cart()
    {
        Cart::session('cart')->clearCartConditions();
        $cart_items = Cart::session('cart')->getContent();

        if (count($cart_items)  == 0) {
            return redirect()->route('customer.store')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success'
            ]);;
        }
        // return $cart_items;
        return view('store.cart', compact('cart_items'));
    }


    public function addToCart(Request $request, $product_id)
    {
        $cart = $this->cartData();
        $product = Product::with('firstMedia')->find($product_id);
        $items = Cart::session('cart')->getContent()->pluck('id');

        $product_quantity_in_cart = Cart::session('cart')->get($product_id)->quantity ?? 0;

        if ($product_quantity_in_cart + $request->quantity > $product->quantity) {

            return response()->json([
                'message' => __('Only pieces of the product are currently available', [
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
            Cart::session('cart')->update($product_id, [
                'quantity' => $request->quantity ?? 1,
                'price' => $product->price
            ]);
            $cart = $this->cartData();
            return response()->json([
                'message' => __('product data updated successfully in your cart.'),
                'type' => 'info',
                'title' => __('Success'),
                'status' => true,
                'cart' => $cart
            ]);
        } else {
            Cart::session('cart')->add([
                'id' => $product->id,
                'name' => $product->name_ar,
                'price' => $product->price,
                'quantity' => $request->quantity ?? 1,
                'attributes' => [
                    'created_at' => Carbon::now(),
                    ],
                'associatedModel' => $product,
            ]);
            $cart = $this->cartData();
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
        $cart = $this->cartData();
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
            $cart = $this->cartData();

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
            Cart::session('cart')->update($product_id, [
                'quantity' => -1,
                'price' => $product->price
            ]);
            $cart = $this->cartData();
            return response()->json([
                'cart' => $cart
            ]);
        }
    }

    protected function cartData()
    {



// $cart = Cart::session('cart')->getContent();
// $cartData = [];
// foreach ($cart as $item) {
//     $cartData[] = [
//         'id' => $item->id,
//         'name' => $item->name,
//         'price' => $item->price,
//         'quantity' => $item->quantity,
//         'image' => $item->firstMedia->file,
//         ];
//         }
//         return $cartData;



        $cart = [];
        $cart['count'] = Cart::session('cart')->getContent()->count();
        $cart['total'] = Cart::session('cart')->getTotal();
        $cart['subTotal'] = Cart::session('cart')->getSubTotal();
        $cart_collection = Cart::session('cart')->getContent()->reverse();
        foreach ($cart_collection as $item) {
            $cart['items'][] = [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'associatedModel' => $item->associatedModel,
                'created_at' => $item->attributes->created_at,

                ];
            }
        return $cart;
    }
}
