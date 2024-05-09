<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ShippingCompanyDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingCompanyRequest;
use App\Models\Governorate;
use App\Models\ShippingCompany;
use App\Traits\Helper;
use Illuminate\Support\Facades\Crypt;

class ShippingCompanyController extends Controller
{
    use Helper;

    public function index(ShippingCompanyDataTable $dataTable)
    {
        $this->checkAbility(['shipping-companies','store-shipping-companies', 'update-shipping-companies', 'show-shipping-companies','delete-shipping-companies']);
        return $dataTable->render('dashboard.shipping_companies.index');
    }

    public function create()
    {
        $this->checkAbility(['store-shipping_companies']);

        $governorates = Governorate::get();
        return view('dashboard.shipping_companies.create', compact('governorates'));
    }

    public function store(ShippingCompanyRequest $request)
    {
        try {
            $this->checkAbility(['store-shipping_companies']);
            $shipping_company = ShippingCompany::create($request->validated());
            $shipping_company->governorates()->attach($request->governorates);
            return redirect()->route('admin.shipping-companies.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $this->checkAbility(['show-shipping_companies']);
            $shipping_company = ShippingCompany::findOrFail(Crypt::decrypt($id));
            return view('dashboard.shipping_companies.show', compact('shipping_company'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit( $id)
    {
        try {
            $this->checkAbility(['update-shipping_companies']);
            $shipping_company = ShippingCompany::findOrFail(Crypt::decrypt($id));
            $governorates = Governorate::get();
            return view('dashboard.shipping_companies.edit', compact('shipping_company', 'governorates'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(ShippingCompanyRequest $request, $id)
    {
        try {
            $this->checkAbility(['update-shipping_companies']);
            $shipping_company = ShippingCompany::findOrFail(Crypt::decrypt($id));
            $shipping_company->update($request->validated());
            $shipping_company->governorates()->sync($request->governorates);
            return redirect()->route('admin.shipping-companies.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        try {
            $this->checkAbility(['delete-shipping_companies']);
            $shipping_company = ShippingCompany::findOrFail(Crypt::decrypt($id));
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
