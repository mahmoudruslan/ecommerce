<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\CityDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\Governorate;
use Illuminate\Support\Facades\Crypt;

class CityController extends Controller
{
    public function index(CityDataTable $dataTable)
    {
        $permissions = userAbility(['cities','store-cities', 'update-cities', 'show-cities','delete-cities']);
        return $dataTable->with('permissions' , $permissions)->render('dashboard.cities.index');
    }

    public function create()
    {
        userAbility(['store-cities']);
        $governorates = Governorate::get();
        return view('dashboard.cities.create', compact('governorates'));
    }

    public function store(CityRequest $request)
    {
        // return $request;
        try {
            userAbility(['store-cities']);
            City::create($request->validated());
            return redirect()->route('admin.cities.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show(City $city)
    {
        try {
            userAbility(['show-cities']);
            $city = City::findOrFail(Crypt::decrypt($id));
            return view('dashboard.cities.show', compact('city'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit(City $city)
    {
        try {
            userAbility(['update-cities']);
            $governorates = Governorate::get();
            return view('dashboard.cities.edit', compact('city', 'governorates'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(CityRequest $request, City $city)
    {
        try {
            userAbility(['update-cities']);
            $city->update($request->validated());
            return redirect()->route('admin.cities.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy(City $city)
    {
        try {
            userAbility(['delete-cities']);
            $city->delete();
            return redirect()->route('admin.cities.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
