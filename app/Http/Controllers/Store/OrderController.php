<?php

namespace App\Http\Controllers\Store;

use App\Models\Order;
use App\Models\Product;
use Paymob\Library\Paymob;
use App\Services\OrderService;
use App\Services\PaymobService;
use App\Models\OrderTransaction;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Darryldecode\Cart\Facades\CartFacade as Cart;


class OrderController extends Controller
{
    private $paymob;
    private $order_service;

    public function __construct(PaymobService $paymob, OrderService $order_service)
    {
        $this->paymob = $paymob;
        $this->order_service = $order_service;
    }

    public function completeOrder(OrderRequest $request)
    {
        // $cart = Cart::session('cart')->getContent();
        // foreach ($cart as $item) {
        //     $product = Product::find($item->id);
        //     if ($item->quantity > $product->quantity) {
        //         Alert::toast(__('Only pieces of the product are currently available', [
        //             'quantity' => $product->quantity,
        //             'product' => $product->name_ar,
        //         ]), 'warning');
        //         return redirect()->back();
        //     }
        // }

        $order = $this->order_service->createOrder($request->all());

        if ($request['payment_method'] == 'card') {

            $billing = [
                "email" => $order['email'],
                "first_name" => $order['first_name'],
                "last_name" => $order['last_name'],
                "street" => $order['street'],
                "phone_number" => $order['phone_number'],
                "city" => $order['city'],
                "country" => $order['country'],
                "state" => $order['state'],
                "postal_code" => '',
            ];

            return $this->paymob->process($billing, $order['id'], $order['total'], 'EGP');
        }
        Alert::success(__('Order created successfully.'));
        return redirect()->route('store');
    }

    public function callback()
    {
        return $this->paymob->callback();
    }
}
