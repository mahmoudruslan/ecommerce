<?php

namespace App\Http\Controllers\Store;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Darryldecode\Cart\CartCondition;

class CheckoutController extends Controller
{
    public function index()
    {

        $cart = Cart::session('cart')->getContent();
        $total = Cart::session('cart')->getTotal();
        $sub_total = Cart::session('cart')->getSubTotal();
        // return $cart;
        return view('store.checkout', compact('cart', 'total', 'sub_total'));
    }

    public function applyCoupon(Request $request)
    {

        $coupon = Coupon::active()->where('code', $request->coupon_code)->first();
        $total = Cart::session('cart')->getTotal();
        // return response()->json(['message' => $coupon->couponValue($total)]);
        // Cart::session('cart')->removeCartCondition($coupon->code);
        if (!$total > 0) {
            return response()->json([
                'message' => __('No products available in your cart.'),
                'type' => 'danger',
                'title' => __('Error'),
                'status' => false,
            ]);
        }
        if ($coupon) {
            if ($coupon->checkUsedTimes() && $coupon->checkDate() && $coupon->checkGreaterThan($request->total)) {
                // return response()->json(['message' => 'true']);

                Cart::session('cart')->removeConditionsByType('sale');
                $condition = new CartCondition(array(
                    'name' => $coupon->code,
                    'type' => 'sale',
                    'target' => 'total',
                    'value' => '-' . $coupon->couponValue($total),
                ));
                Cart::session('cart')->condition($condition);
                $cart = [];
                $cart['count'] = Cart::session('cart')->getContent()->count();
                $cart['total'] = Cart::session('cart')->getTotal();
                $cart['subTotal'] = Cart::session('cart')->getSubTotal();
                return response()->json([
                    'message' => __('Coupon applied successfully.'),
                    'type' => 'success',
                    'title' => __('Success'),
                    'status' => true,
                    'cart' => $cart
                ]);
            }
        }
        return response()->json([
            'message' => __('Coupon is Invalid.'),
            'type' => 'danger',
            'title' => __('Error'),
            'status' => false,
        ]);
    }

    public function removeCoupon(Request $request)
    {
        Cart::session('cart')->removeConditionsByType('sale');

        $cart = [];
        $cart['count'] = Cart::session('cart')->getContent()->count();
        $cart['total'] = Cart::session('cart')->getTotal();
        $cart['subTotal'] = Cart::session('cart')->getSubTotal();
        return response()->json([
            'message' => __('Coupon removed successfully.'),
            'type' => 'success',
            'title' => __('Success'),
            'status' => true,
            'cart' => $cart

        ]);
    }
}
