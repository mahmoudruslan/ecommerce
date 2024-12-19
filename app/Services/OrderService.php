<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderAddress;
use App\Models\OrderTransaction;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class OrderService
{


    public function createOrder($request)
    {
        //data
        $cart = Cart::session('cart')->getContent();
        $total = Cart::session('cart')->getTotal();
        $sub_total = Cart::session('cart')->getSubTotal();
        $sale_condition = Cart::session('cart')->getConditionsByType('sale');
        $discount = $sale_condition->sum('parsedRawValue');
        $coupon_code = count($sale_condition) > 0 ? $sale_condition->first()->getName() : null;
        $shipping = Cart::session('cart')->getConditionsByType('shipping')->sum('parsedRawValue');
        $order_address_id = null;

        if (!isset($request['address_id'])) { // if no address
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
        $latest_order = Order::orderBy('created_at', 'DESC')->first();
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->id() : null,
            'payment_method' => $request['payment_method'],
            'user_address_id' => $request['address_id'] ?? null,
            'order_address_id' => $order_address_id,
            'discount_code' => $coupon_code,
            'ref_id' => '#' . str_pad(($latest_order ? $latest_order->id : 0) + 1, 8, "0", STR_PAD_LEFT),
            'total' => $total,
            'sub_total' => $sub_total,
            'shipping' => $shipping,
            'discount' => $discount,
            'status' => 0
        ]);
        //order products
        foreach ($cart as $item) {

            DB::table('order_product')->insert([
                'product_id' => $item->associatedModel->id,
                'order_id' => $order->id,
                'quantity' => $item->quantity,
                'price' => $item->associatedModel->price,
            ]);
            //update product quantity
            $product = Product::find($item->id);

            $product->update([
                'quantity' => $product->quantity - $item->quantity,
            ]);
        }

        $cache = $request['payment_method'] == 'cash-on-delivery';
        $order->update([
            'status' => $cache  ? OrderTransaction::PROCESSING : OrderTransaction::PENDING,
        ]);
        $order->transactions()->create([
            'transaction' => $cache  ? OrderTransaction::PROCESSING : OrderTransaction::PENDING,
            'payment_method' => $cache  ? 'cash-on-delivery' : 'card',
        ]);
        Cart::session('cart')->clear();
        $address = isset($request['address_id']) ? $order->userAddress : $order->orderAddress;
        $data = [
            'id' => $order->id,
            'total' => $order->total,
            'email' => $address->email,
            'first_name' => $address->first_name,
            'last_name' => $address->last_name,
            'phone_number' => $address->mobile,
            'country' => 'Egypt',
            'state' => $address->governorate['name_' . currentLang()],
            'city' => $address->city['name_' . currentLang()],
            "street" => $address->zip_code,
            "postal_code" => $address->zip_code,
            "order" => $order,

        ];

        return $data;
    }
    public function cartReplace($order_id)
    {
        $order = Order::with('products')->findOrFail($order_id);
        Cart::session('cart')->clear();
        $shortages = [];
        foreach ($order->products as $product) {
            $quantity_requested = $product->pivot->quantity;
            $available_quantity = $product->quantity;
            if ($available_quantity == 0) {
                $shortages[] = $this->makeShortage($product['name_' . currentLang()], $quantity_requested, $available_quantity);
                continue;
            }
            if ($quantity_requested > $available_quantity) {
                $shortages[] = $this->makeShortage($product['name_' . currentLang()], $quantity_requested, $available_quantity);
                $quantity_requested = $available_quantity;
            }
            addToCart($product, $quantity_requested);
        }
        if (!empty($shortages)) {
            $this->shortageAlert($shortages);
        } else {
            Alert::success(__('The products in your shopping cart have been replaced with the new order.'));
        }
        return redirect()->route('customer.cart');
    }

    public function CartMerge($order_id)
    {
        $shortages = [];
        $order = Order::with('products')->findOrFail($order_id);
        $cart_items = Cart::session('cart')->getContent();
        foreach ($order->products as $product) {
            $available_quantity = $product->quantity;
            if ($cart_items->pluck('id')->contains($product->id)) {
                $item = Cart::session('cart')->get($product->id);

                $quantity_requested = $item->quantity + $product->pivot->quantity;

                if ($quantity_requested > $available_quantity) {
                    $shortages[] = $this->makeShortage($product['name_' . currentLang()], $quantity_requested, $available_quantity);
                    $quantity_requested = $available_quantity;
                }
                updateCart($product, $quantity_requested - $item->quantity);
            } else {
                $quantity_requested = $product->pivot->quantity;
                if ($quantity_requested > $available_quantity) {
                    $shortages[] = $this->makeShortage($product['name_' . currentLang()], $quantity_requested, $available_quantity);

                    $quantity_requested = $available_quantity;
                }
                addToCart($product, $quantity_requested);
            }
        }

        if (!empty($shortages)) {
            $this->shortageAlert($shortages);
        } else {
            Alert::success(__('The products in your shopping cart have been combined with the new order.'));
        }
        return redirect()->route('customer.cart');
    }

    public function makeShortage($product_name, $quantity_requested, $available_quantity)
    {
        return [
            'name' => $product_name,
            'requested' => $quantity_requested,
            'available' => $available_quantity,
        ];
    }
    public function shortageAlert($shortages)
    {
        $shortageMessage = '<ul>';
        foreach ($shortages as $shortage) {
            $shortageMessage .= '<li>'
                . __('Product') . ': ' . $shortage['name'] . ','
                . __('Required') . ': ' . $shortage['requested'] . ','
                . __('Available') . ': ' . $shortage['available'] . '</li>';
        }
        $shortageMessage .= "</ul>";

        Alert::html(
            __('The order was successfully placed, but the following quantities were not fully available:'),
            $shortageMessage,
            'success'
        )->autoClose(7000);
    }
}
