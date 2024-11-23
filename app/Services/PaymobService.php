<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Coupon;
use GuzzleHttp\Client;
use Paymob\Library\Paymob;
use GuzzleHttp\Psr7\Request;
use App\Models\OrderTransaction;
use RealRashid\SweetAlert\Facades\Alert;
use Darryldecode\Cart\Facades\CartFacade as Cart;


class PaymobService
{

    private $secret_key;
    private $public_key;
    private $integration_ids;
    private $hmac;
    public function __construct()
    {
        $this->secret_key = config('paymob.secret_key');
        $this->public_key = config('paymob.public_key');
        $this->integration_ids = config('paymob.integration_id');
        $this->hmac = config('paymob.hmac');
        // $this->callback_url = config('paymob.callback_url');
    }

    public function process($billing, $order_id, $total, $currency)
    {
        try {
            $integrations = explode(',', $this->integration_ids);
            $integration_ids = [];
            foreach ($integrations as $id) {
                $id = (int) $id;
                if ($id > 0) {
                    array_push($integration_ids, $id);
                }
            }

            // Prepare order data
            $country = Paymob::getCountryCode($this->secret_key);
            $cents = $country == 'omn' ? 1000 : 100;
            $round = 2;
            $total = round((round($total, $round)) * $cents, $round);

            $data = [
                "amount" => $total,
                "currency" => $currency,
                "payment_methods" => $integration_ids,
                "billing_data" => $billing,
                "extras" => ["merchant_intention_id" => $order_id . '_' . time()],
                "special_reference" => $order_id . '_' . time()
            ];

            // Create Paymob intention
            $paymobReq = new Paymob('', '');

            $status = $paymobReq->createIntention($this->secret_key, $data, $order_id);

            // Process the response
            if (!$status['success']) {
                $response = ['IsSuccess' => 'false', 'Message' => $status['message']];
            } else {
                $countryCode = $paymobReq->getCountryCode($this->secret_key);
                $apiUrl = $paymobReq->getApiUrl($countryCode);
                $cs = $status['cs'];
                $to = $apiUrl . "unifiedcheckout/?publicKey=$this->public_key&clientSecret=$cs";
                // Redirect the user to Paymob checkout page
                return redirect($to);
            }
        } catch (\Exception $e) {
            $response = ['IsSuccess' => 'false', 'Message' => $e->getMessage()];
        }
        return response()->json($response);
    }


    public function callback()
    {
        try {
            // Verify HMAC
            if (!Paymob::verifyHmac($this->hmac, $_GET)) {
                Alert::error(__('Payment'), __('Ops, you are accessing wrong data'));
                return redirect()->route('customer.store');
            }
            // Extract intention ID from request parameters
            $orderId = Paymob::getIntentionId(Paymob::filterVar('merchant_order_id'));
            // Check if intention ID is valid
            if (empty($orderId)) {
                Alert::error(__('Payment'), __('Ops, you are accessing wrong data'));
                return redirect()->route('customer.store');
            }
            $order = Order::find($orderId);
            // Check payment status
            $success = Paymob::filterVar('success') === "true";
            $is_voided = Paymob::filterVar('is_voided') === "true";
            $is_refunded = Paymob::filterVar('is_refunded') === "true";

            // Prepare response
            if ($success && !$is_voided && !$is_refunded) {

                $order->update([
                    'status' => Order::PAYMENT_COMPLETED,
                    'ref_id' => Paymob::filterVar('id')
                ]);
                $order->transactions()->create([
                    'transaction' => OrderTransaction::PAYMENT_COMPLETED,
                    'transaction_number' => Paymob::filterVar('id'),
                    'payment_result' =>  'success',
                    'payment_method' =>  'card',
                ]);
                //increase used_times in coupon
                $sale_condition = Cart::session('cart')->getConditionsByType('sale');
                $coupon_code = count($sale_condition) > 0 ? $sale_condition->first()->getName() : null;
                $coupon = Coupon::where('code', $coupon_code)->first();
                if ($coupon) {
                    $coupon->increment('used_times');
                }
                Cart::session('cart')->clear();
                Alert::success(__('Payment'), __('Payment Approved!'));
            } else {
                $order->update([
                    'status' => Order::REJECTED,
                ]);
                //decrease order products quantity once again and return products to cart
                $order->products()->each(function ($product) {
                    $product->quantity += $product->pivot->quantity;
                });
                $order->transactions()->create([
                    'transaction' => OrderTransaction::REJECTED,
                    'payment_result' =>  'failed',
                ]);
                Alert::error(__('Payment'), __('Payment is not completed'));
            }
        } catch (\Exception $e) {
            Alert::error(__('Error'), $e->getMessage());
        }
        return redirect()->route('customer.store');
    }

    protected function returnProductToCart($order)
    {
        $order->products()->each(function ($product) {
            $product->quantity += $product->pivot->quantity;
            Cart::session('cart')->add([
                'id' => $product->id,
                'name' => $product->name_ar,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
                'associatedModel' => $product,
            ]);
        });
    }
    public function refund($order_id)
    {
        $order = Order::find($order_id);
        if (!$order) {
            Alert::toast(__('Order not found'), 'error');
            return redirect()->back();
        }
        $client = new Client();
        $headers = [
            'Authorization' => 'Token ' . $this->secret_key,
            'Content-Type' => 'application/json'
        ];
        $body = [
            "transaction_id" => $order->ref_id,
            "amount_cents" => $order->total * 100
        ];

        $request = new Request('POST', 'https://accept.paymob.com/api/acceptance/void_refund/refund', $headers, json_encode($body));
        $response = $client->sendAsync($request)->wait();
        $response = json_decode($response->getBody());

        if($response->success == true && $response->is_refund == true)
        {
            $order->update([
                'status' => Order::REFUNDED,
            ]);
            $order->transactions()->create([
                'transaction' => OrderTransaction::REFUNDED,
                'transaction_number' => $response->id,
                'payment_result' => 'success',
            ]);
            $order->products()->each(function ($product) {
                $product->update([
                    'quantity' => $product->quantity + $product->pivot->quantity,
                ]);
            });
            Alert::success(__('Refund successfully'), 'success');
            return redirect()->back();

        }else{
            return json_decode($response->getBody());
        }


    }

}
