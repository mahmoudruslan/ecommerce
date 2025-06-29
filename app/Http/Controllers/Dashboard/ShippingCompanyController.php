<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ShippingCompanyDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingCompanyRequest;
use App\Models\Governorate;
use App\Models\ShippingCompany;
use Illuminate\Support\Facades\Crypt;

class ShippingCompanyController extends Controller
{

    public function index(ShippingCompanyDataTable $dataTable)
    {
        $permissions = userAbility(['shipping-companies','store-shipping-companies', 'update-shipping-companies', 'show-shipping-companies','delete-shipping-companies']);
        return $dataTable->with('permissions' , $permissions)->render('dashboard.shipping_companies.index');
    }

    public function create()
    {
        userAbility(['store-shipping_companies']);

        $governorates = Governorate::get();
        return view('dashboard.shipping_companies.create', compact('governorates'));
    }

    public function store(ShippingCompanyRequest $request)
    {
        try {
            userAbility(['store-shipping_companies']);
            $shipping_company = ShippingCompany::create($request->validated());
            $shipping_company->governorates()->attach($request->governorates);
            return redirect()->route('admin.shipping-companies.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show(ShippingCompany $shipping_company)
    {
        try {
            userAbility(['show-shipping_companies']);
            return view('dashboard.shipping_companies.show', compact('shipping_company'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit(ShippingCompany $shipping_company)
    {
        try {
            userAbility(['update-shipping_companies']);
            $governorates = Governorate::get();
            return view('dashboard.shipping_companies.edit', compact('shipping_company', 'governorates'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(ShippingCompanyRequest $request, ShippingCompany $shipping_company)
    {
        try {
            userAbility(['update-shipping_companies']);
            $shipping_company->update($request->validated());
            $shipping_company->governorates()->sync($request->governorates);
            return redirect()->route('admin.shipping-companies.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy(ShippingCompany $shipping_company)
    {
        try {
            userAbility(['delete-shipping_companies']);
            $shipping_company->governorates()->detach();
            $shipping_company->delete();
            return redirect()->route('admin.shipping-companies.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }
}
