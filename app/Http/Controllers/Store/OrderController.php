<?php

namespace App\Http\Controllers\Store;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function completeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), $this->addressRules());
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        $cart['total'] = Cart::session('cart')->getTotal();
        $cart['sub_total'] = Cart::session('cart')->getSubTotal();
        $cart['sale'] = Cart::session('cart')->getConditionsByType('sale')->sum('parsedRawValue');
        $cart['shipping'] = Cart::session('cart')->getConditionsByType('shipping')->sum('parsedRawValue');
        return response()->json($request->all());
    }
    public function addressRules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits_between:6,50',
            'email' => 'required|email',
            'user_id' => 'nullable',
            'address' => 'required|string|max:255',
            'zip_code' => 'required|numeric|digits_between:1,10',
            'governorate_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'payment' => 'required|string'
            ];

    }
}
