<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\UserAddressDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddressRequest;
use App\Models\City;
use App\Models\Governorate;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Crypt;

class UserAddressController extends Controller
{

    public function index(UserAddressDataTable $dataTable)
    {
        $permissions = userAbility(['user-addresses','store-user-addresses', 'update-user-addresses', 'show-user-addresses','delete-user-addresses']);
        return $dataTable->with('permissions' , $permissions)->render('dashboard.user_addresses.index');
    }


    public function createAddress($id)
    {
        userAbility(['store-user-addresses']);
        $user = User::findOrFail(Crypt::decrypt($id));
        $governorates = Governorate::get(['id', 'name_ar', 'name_en']);
        $cities = City::get(['id', 'name_ar', 'name_en']);
        return view('dashboard.user_addresses.create', compact('user', 'governorates', 'cities'));
    }

    public function store(UserAddressRequest $request)
    {
        // return $request;
        try {
            userAbility(['store-user-addresses']);
            UserAddress::create($request->validated());
            return redirect()->route('admin.user-addresses.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show(UserAddress $user_address)
    {
        try {
            userAbility(['show-user-addresses']);
            $user_address = UserAddress::findOrFail(Crypt::decrypt($id));
            return view('dashboard.user_addresses.show', compact('user_address'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function edit(UserAddress $user_address)
    {
        try {
            userAbility(['update-user-addresses']);
            $governorates = Governorate::get(['id', 'name_ar', 'name_en']);
        $cities = Governorate::get(['id', 'name_ar', 'name_en']);
            return view('dashboard.user_addresses.edit', compact('user_address', 'governorates', 'cities'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(UserAddressRequest $request, UserAddress $user_address)
    {
        try {
            userAbility(['update-user-addresses']);
            $user_address->update($request->validated());
            return redirect()->route('admin.user-addresses.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function destroy(UserAddress $user_address)
    {
        try {
            userAbility(['delete-user-addresses']);
            $user_address->delete();
            return redirect()->route('admin.user_addresses.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
