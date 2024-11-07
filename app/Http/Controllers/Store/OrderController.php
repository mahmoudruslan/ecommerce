<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function completeOrder(OrderRequest $request, OrderService $order_service)
    {
        $order = $order_service->createOrder($request->all());

        return redirect()->route('store');
        if ($request['payment_method'] == 'cash-on-delivery') {
            dd('cash-on-delivery');
        } else if ($request['payment_method'] == 'pay') {
            dd('pay');
        } else {
            return redirect()->back();
        }
    }
}
