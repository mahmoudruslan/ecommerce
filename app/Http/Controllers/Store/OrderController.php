<?php

namespace App\Http\Controllers\Store;

use App\Events\OrderCreated;
use App\Models\User;
use App\Services\OrderService;
use App\Services\PaymobService;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Customer\OrderRequest;
use App\Notifications\ToDashboard\OrderCompletedNotification;
use Illuminate\Console\Scheduling\Event;

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
        //send notify to admins
        User::whereHas('roles', function($query){
            $query->whereIn('name', ['admin', 'super-admin']);
        })->each(function($admin) use ($order){
            $admin->notify(new OrderCompletedNotification($order));
        });
        //
        Alert::success(__('Order created successfully.'));
        return redirect()->route('customer.store');
    }

    public function refund($order_id)
    {
        return $this->paymob->refund($order_id);
    }

    public function callback()
    {
        return $this->paymob->callback();
    }
    public function buyAgainReplaceWithCart($order_id)
    {
        return $this->order_service->cartReplace($order_id);

    }

    public function buyAgainMergeWithCart($order_id)
    {
        return $this->order_service->CartMerge($order_id);
    }
}
