<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use Illuminate\Http\Request;
use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\OrderTransaction;
use App\Services\PaymobService;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;


class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable)
    {
        $permissions = userAbility(['orders', 'store-orders', 'update-orders', 'show-orders', 'delete-orders']);
        return $dataTable->with('permissions', $permissions)->render('dashboard.orders.index');
    }

    public function show($id)
    {
        try {
            userAbility(['show-orders']);
            $order = Order::with([
                'customer',
                'products',
                'transactions',
                'userAddress',
                'orderAddress'
            ])->findOrFail($id);
            $available_order_status = [];
            $order_status = [
                '0' => __('Pending'),
                '1' => __('Payment completed'),
                '2' => __('Processing'),
                '3' => __('Rejected'),
                '5' => __('Finished'),
                '7' => __('Returned order'),
                '8' => __('Refunded'),
            ];
            foreach ($order_status as $key => $value) {
                if ($key > $order->status) {
                    //no show payment complete in status
                    $paid_transaction =  $order->transactions()->where('transaction', OrderTransaction::PAYMENT_COMPLETED)->get();
                    if($order->payment_method === 'card' && $key == 1)
                    {
                        continue;
                    }
                    if($order->payment_method === 'cash-on-delivery' && $key == 8 || $key == 8 && count($paid_transaction) == 0)
                    {
                        continue;
                    }
                $available_order_status[$key] = $order_status[$key];
                }
            }

            return view('dashboard.orders.show', compact('order', 'available_order_status'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            userAbility(['update-orders']);
            $order = Order::findOrFail($id);
            if (isset($request->status)) {
                if ($order->status == $request->status) {
                    Alert::info(__('Order status is already updated'));
                    return redirect()->back();
                }
                if ($request->status === '8') {
                    $paymob = new PaymobService();
                    return $paymob->refund($id);
                }
                $order->update([
                    'status' => $request->status,
                ]);
                //create transaction

                $order->transactions()->create([
                    'transaction' => $request->status,
                ]);

                Alert::success(__('Order status changed successfully'));
                return redirect()->back();
            }
            Alert::toast(__('Choose status'), 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            userAbility(['delete-orders']);
            $order = Order::findOrFail(Crypt::decrypt($id));
            $order->delete();
            Alert::toast(__('Item Deleted successfully.'), 'success');
            return redirect()->back();
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
