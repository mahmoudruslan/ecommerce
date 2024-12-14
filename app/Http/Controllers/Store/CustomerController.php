<?php

namespace App\Http\Controllers\Store;

use App\Models\User;
use App\Models\Order;
use App\Traits\Files;
use App\Models\Product;
use App\Models\Governorate;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Models\OrderTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\UserAddressRequest;
use App\Http\Requests\Customer\ProfileRequest;
use App\Models\Review;

class CustomerController extends Controller
{
    use Files;
    public function editProfile()
    {
        try {
            $customer = auth()->user();
            $governorates = Governorate::get();
            return view('.store.profile', compact('customer', 'governorates'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function updateProfile(ProfileRequest $request)
    {
        try {
            $customer = User::findOrFail(auth()->id());
            $file_name = $customer->image;
            $path = '';
            if ($image = $request->file('image')) {
                $this->deleteFiles($file_name);
                $path = 'images/users/';
                $file_name = $this->saveImag($path, [$request->image]);
                $this->resizeImage(300, null, $path, $file_name, $image);
            }
            //no forget make password update optional
            $customer->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                // 'email' => $request->email,
                'mobile' => $request->mobile,
                'image' => $path . $file_name,
                'password' => $request->password ? Hash::make($request->password) : $customer->password,
            ]);
            Alert::toast(__('Data updated successfully.'), 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function storeAddress(UserAddressRequest $request)
    {
        try {
            UserAddress::create($request->validated());
            Alert::toast(__('Address created successfully.'), 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function removeImage()
    {
        try {
            $customer = User::findOrFail(auth()->id());
            $this->deleteFiles($customer->image);
            $customer->update([
                'image' => 'images/users/avatar.png',
            ]);
            Alert::toast(__('Image deleted successfully.'), 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function addresses()
    {
        try {
            // $customer = User::findOrFail(auth()->id());
            $addresses = UserAddress::with(['governorate', 'city'])->where('user_id', auth()->id())->get();
            $governorates = Governorate::get();
            return view('store.addresses', compact('addresses', 'governorates'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function removeAddress($id)
    {
        try {
            $address = UserAddress::findOrFail(Crypt::decrypt($id));
            $address->delete();
            Alert::toast(__('Address deleted successfully.'), 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function UpdateAddress(Request $request, $id)
    {
        try {
            $address = UserAddress::findOrFail(Crypt::decrypt($id));
            $address->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'zip_code' => $request->zip_code ?? null,
                'address' => $request->address,
                'address2' => $request->address2 ?? null,
                'mobile' => $request->mobile,
                'governorate_id' => $request->governorate_id,
                'city_id' => $request->city_id,
                'default_address' => $request->default_address ?? 0,
            ]);
            if ($request->default_address == 1) {
                UserAddress::where('user_id', $address->user_id)->where('id', '!=', $address->id)->update([
                    'default_address' => 0,
                ]);
            }
            Alert::toast(__('Address updated successfully.'), 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function orders()
    {
        try {
            $orders = Order::with(['products', 'transactions'])
            ->where('user_id', auth()->user()->id)
            ->orWhereHas('orderAddress', function($query){
                $query->where('email', auth()->user()->email);
            })
            ->get();

            // $orders = Order::with(['products', 'transactions'])->whereHas('orderAddress', function($query){
            //     $query->where('email', auth()->user()->email);
            // })->get();
            return view('store.orders', compact('orders'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function orderDetails($order_id)
    {
        try {
            $order = Order::with(['products', 'transactions'])->findOrFail($order_id);
            return view('store.order_details', compact('order'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function refundRequest($id)
    {
        try {
            $order = Order::find($id);
            $order->update([
                'status' => Order::REFUND_REQUEST,
            ]);
            $transaction = OrderTransaction::where('order_id', $order->id)->where('transaction', OrderTransaction::PAYMENT_COMPLETED)->first();
            // return $transaction;
            $order->transactions()->create([
                'transaction' => OrderTransaction::REFUND_REQUEST,
                'payment_method' => $transaction->payment_method,
                'transaction_number' => $transaction->transaction_number,
                'payment_result' => $transaction->payment_result,
            ]);
            Alert::toast(__('Refund request sent successfully'), 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function productReview($slug, Request $request)
    {
        $product = Product::whereSlug($slug)->first();
        Review::create([
            'product_id' => $product->id,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'body' => $request->body,
            'rating' => $request->rating,

        ]);

        return response()->json([
            'message' => __('Thank you for interacting with us'),
            'type' => 'success',
            'title' => __('Success'),
            'status' => true,
        ]);
    }
}
