<?php

namespace App\Http\Controllers\Store;

use App\Models\Coupon;
use App\Models\Governorate;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Darryldecode\Cart\CartCondition;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        \Cart::session(auth()->id() ?? 'cart')->clearCartConditions();
        $cart_items = \Cart::session(auth()->id() ?? 'cart')->getContent();
        if (count($cart_items)  == 0) {
            Alert::toast(__('No products available in your cart.'), 'error');
            return redirect()->route('customer.store');
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
                \Cart::session(auth()->id() ?? 'cart')->condition($condition);
            }
        }
        $cart_data = cartData();
        $cart = $cart_data['items'];
        $total = $cart_data['total'];
        $sub_total = $cart_data['subTotal'];
        $governorates = Governorate::all();

        // return $cart;
        return view('store.checkout', compact('cart', 'total', 'sub_total', 'governorates'));
    }

    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::active()->where('code', $request->coupon_code)->first();
        $total = \Cart::session(auth()->id() ?? 'cart')->getTotal();
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

                \Cart::session(auth()->id() ?? 'cart')->removeConditionsByType('sale');
                $condition = new CartCondition(array(
                    'name' => $coupon->code,
                    'type' => 'sale',
                    'target' => 'total',
                    'value' => '-' . $coupon->couponValue($total),
                    'order' => 1

                ));
                \Cart::session(auth()->id() ?? 'cart')->condition($condition);
                $cart = cartData();
                // $cart['count'] = \Cart::session(auth()->id() ?? 'cart')->getContent()->count();
                // $cart['total'] = \Cart::session(auth()->id() ?? 'cart')->getTotal();
                // $cart['subTotal'] = \Cart::session(auth()->id() ?? 'cart')->getSubTotal();
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
        \Cart::session(auth()->id() ?? 'cart')->removeConditionsByType('sale');
        return response()->json([
            'message' => __('Coupon removed successfully.'),
            'type' => 'success',
            'title' => __('Success'),
            'status' => true,
            'cart' => cartData()

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
        \Cart::session(auth()->id() ?? 'cart')->condition($condition);
        return response()->json([
            'cost' => $governorate->cost,
            'cart' => cartData()
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
            'email' => 'nullable|email',
            'address' => 'required|string|max:255',
            'zip_code' => 'nullable|numeric|digits_between:1,10',
            'governorate_id' => 'required|numeric',
            'city_id' => 'required|numeric',
        ];
    }
}
