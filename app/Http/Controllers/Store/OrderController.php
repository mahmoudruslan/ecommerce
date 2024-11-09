<?php

namespace App\Http\Controllers\Store;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use App\Services\OrderService;
use App\Services\PaymobService;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Store\PaymobController;

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
        $order = $this->order_service->createOrder($request->all());

        // return redirect()->route('store');

        if ($request['payment_method'] == 'cash-on-delivery') {
            dd('cash-on-delivery');
            //code.......

        } else if ($request['payment_method'] == 'pay') {

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
            // return $billing;
           return $this->paymob->process($billing, $order['id'], $order['total'], 'EGP');

            // return redirect()->route('pay');


            // return $this->paymob->sendPayment($data);
        } else {
            return redirect()->back();
        }
    }

    public function callback(Request $request)
    {
        $this->paymob->callback($request);
    }
}
