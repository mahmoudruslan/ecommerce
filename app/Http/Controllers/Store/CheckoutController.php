<?php

namespace App\Http\Controllers\Store;

use App\Models\Coupon;
use App\Models\Governorate;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Darryldecode\Cart\CartCondition;
use Illuminate\Support\Facades\Validator;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart_items = Cart::session('cart')->getContent();
        if (count($cart_items)  == 0) {
            return redirect()->back()->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success'
            ]);;
        }
        if (Auth::check()) {
            $user = Auth::user();
            $default_address = UserAddress::where('user_id', $user->id)->where('default_address', 1)->first();
            if ($default_address) {
                $condition = new \Darryldecode\Cart\CartCondition(array(
                    'name' => 'Shipping',
                    'type' => 'shipping',
                    'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                    'value' => '+' . $default_address->governorate->cost,
                    'order' => 2
                ));
                Cart::session('cart')->condition($condition);
            }
            // else {
            //     Cart::session('cart')->clearCartConditions();
            // }
        }
        $cart = Cart::session('cart')->getContent();
        $total = Cart::session('cart')->getTotal();
        $sub_total = Cart::session('cart')->getSubTotal();
        $governorates = Governorate::all();

        // return $cart;
        return view('store.checkout', compact('cart', 'total', 'sub_total', 'governorates'));
    }

    public function applyCoupon(Request $request)
    {
        // return response()->json(Cart::session('cart')->getConditionsByType('sale'));
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
            if ($coupon->checkUsedTimes() && $coupon->checkDate() && $coupon->checkGreaterThan($total)) {
                // return response()->json(['message' => 'true']);

                Cart::session('cart')->removeConditionsByType('sale');
                $condition = new CartCondition(array(
                    'name' => $coupon->code,
                    'type' => 'sale',
                    'target' => 'total',
                    'value' => '-' . $coupon->couponValue($total),
                    'order' => 1

                ));
                Cart::session('cart')->condition($condition);
                $cart = [];
                $cart['count'] = Cart::session('cart')->getContent()->count();
                $cart['total'] = Cart::session('cart')->getTotal();
                $cart['subTotal'] = Cart::session('cart')->getSubTotal();
                $cart['sale'] = $condition->getCalculatedValue($cart['subTotal']);
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

    public function removeCoupon()
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
    public function addShippingCost($id)
    {
        $governorate = Governorate::find($id);
        $condition = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'Shipping',
            'type' => 'shipping',
            'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
            'value' => '+' . $governorate->cost,
            'order' => 2
        ));
        Cart::session('cart')->condition($condition);
        $cart = [];
        $cart['total'] = Cart::session('cart')->getTotal();
        $cart['subTotal'] = Cart::session('cart')->getSubTotal();
        return response()->json([
            'cost' => $governorate->cost,
            'cart' => $cart
        ]);
    }

    public function addAddress(Request $request)
    {
        $validator = Validator::make($request->all(), $this->addressRules());
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        $address = UserAddress::create($validator->validated());
        $addresses = UserAddress::where('user_id', auth()->id())->get();
        return response()->json([
            'message' => __('data created successfully.'),
            'type' => 'success',
            'title' => __('Success'),
            'status' => true,
            'addresses' => $addresses,
            'governorate_id' => $address->governorate_id
        ]);
    }
    public function addressRules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits_between:6,50',
            'user_id' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'required|string|max:255',
            'zip_code' => 'required|numeric|digits_between:1,10',
            'governorate_id' => 'required|numeric',
            'city_id' => 'required|numeric',
        ];
    }
}
