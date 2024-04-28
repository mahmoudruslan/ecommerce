<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\CityDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\Governorate;
use App\Traits\Helper;
use Illuminate\Support\Facades\Crypt;

class CityController extends Controller
{
    use Helper;
    public function index(CityDataTable $dataTable)
    {
        $this->checkAbility(['cities','store-cities', 'update-cities', 'show-cities','delete-cities']);
        return $dataTable->render('dashboard.cities.index');
    }

    public function create()
    {
        $this->checkAbility(['store-cities']);
        $governorates = Governorate::get();
        return view('dashboard.cities.create', compact('governorates'));
    }

    public function store(CityRequest $request)
    {
        // return $request;
        try {
            $this->checkAbility(['store-cities']);
            City::create($request->validated());
            return redirect()->route('admin.cities.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $this->checkAbility(['show-cities']);
            $city = City::findOrFail(Crypt::decrypt($id));
            return view('dashboard.cities.show', compact('city'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit( $id)
    {
        try {
            $this->checkAbility(['update-cities']);
            $governorates = Governorate::get();
            $city = City::findOrFail(Crypt::decrypt($id));
            return view('dashboard.cities.edit', compact('city', 'governorates'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(CityRequest $request, $id)
    {
        try {
            $this->checkAbility(['update-cities']);
            $city = City::findOrFail(Crypt::decrypt($id));
            $city->update($request->validated());
            return redirect()->route('admin.cities.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy( $id)
    {
        try {
            $this->checkAbility(['delete-cities']);
            $city = City::findOrFail(Crypt::decrypt($id));
            $city->delete();
            return redirect()->route('admin.cities.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
