<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\OrderAddress;
use App\Models\OrderTransaction;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class OrderService
{
    public function createOrder($request)
    {
        $cart = Cart::session('cart')->getContent();
        $total = Cart::session('cart')->getTotal();
        $sub_total = Cart::session('cart')->getSubTotal();
        $sale_condition = Cart::session('cart')->getConditionsByType('sale');
        $discount = $sale_condition->sum('parsedRawValue');
        $coupon_code = count($sale_condition) > 0 ? $sale_condition->first()->getName() : null;
        $shipping = Cart::session('cart')->getConditionsByType('shipping')->sum('parsedRawValue');
        $order_address_id = null;
        if (!isset($request['address_id'])) {
            $order_address = OrderAddress::create([
                'governorate_id' => $request['governorate_id'],
                'city_id' => $request['city_id'],
                'email' => $request['email'],
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'mobile' => $request['mobile'],
                'address' => $request['address'],
                'zip_code' => $request['zip_code'],
            ]);
            $order_address_id = $order_address->id;
        }
        $latestOrder = Order::orderBy('created_at','DESC')->first();
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->id() : null,
            'payment_method_id' => 1,
            'user_address_id' => $request['address_id'] ?? null,
            'order_address_id' => $order_address_id,
            'discount_code' => $coupon_code,
            'ref_id' => '#'.str_pad(($latestOrder ? $latestOrder->id : 0) + 1, 8, "0", STR_PAD_LEFT),
            'total' => $total,
            'sub_total' => $sub_total,
            'shipping' => $shipping,
            'discount' => $discount,
            'status' => 0
        ]);
        foreach ($cart as $item) {
            //create order products with relationship
            DB::table('order_product')->insert([
                'product_id' => $item->id,
                'order_id' => $order->id,
                'quantity' => $item->quantity,
            ]);
            $product = Product::find($item->id);
            $product->update([
                'quantity' => $product->quantity - $item->quantity,
            ]);

        }
        $coupon = Coupon::where('code', $coupon_code)->first();
            if ($coupon) {
                $coupon->increment('used_times');

            }
            $order->transactions()->create([
                'transaction' => OrderTransaction::NEW_ORDER,

            ]);
        Cart::session('cart')->clear();
        return $order;

    }
}
