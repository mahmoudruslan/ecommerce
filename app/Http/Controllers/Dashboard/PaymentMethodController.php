<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\PaymentMethodDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;
use App\Traits\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PaymentMethodController extends Controller
{
    use Files;

    public function index(PaymentMethodDataTable $dataTable)
    {
        //userAbility() method => App/Helpers/Helper.php
        $permissions = userAbility(['payment-methods', 'store-payment-methods', 'update-payment-methods', 'show-payment-methods', 'delete-payment-methods']); //pass to dataTable class
        return $dataTable->with('permissions', $permissions)->render('dashboard.payment_methods.index');
    }

    public function create()
    {
        userAbility(['store-payment-methods']);
        return view('dashboard.payment_methods.create');
    }

    public function store(PaymentMethodRequest $request)
    {
        userAbility(['store-payment-methods']);
        try {
            PaymentMethod::create($request->validated());
            return redirect()->route('admin.payment-methods.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            userAbility(['update-payment-methods']);
            $payment_method = PaymentMethod::findOrFail($id);
            return view('dashboard.payment_methods.edit', compact('payment_method'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(PaymentMethodRequest $request, $id)
    {
        try {
            userAbility(['update-payment-methods']);
            $payment_method = PaymentMethod::findOrFail($id);
            $payment_method->update($request->validated());

            return redirect()->route('admin.payment-methods.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            userAbility(['delete-payment-methods']);
            $payment_method = PaymentMethod::findOrFail($id);

            $payment_method->delete();
            return redirect()->route('admin.payment-methods.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success',

            ]);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

}
