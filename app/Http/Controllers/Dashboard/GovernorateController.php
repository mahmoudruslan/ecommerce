<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\GovernorateDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\GovernorateRequest;
use App\Models\Governorate;
use Illuminate\Support\Facades\Crypt;

class GovernorateController extends Controller
{
    public function index(GovernorateDataTable $dataTable)
    {
        $permissions = userAbility(['governorates','store-governorates', 'update-governorates', 'show-governorates','delete-governorates']);
        return $dataTable->with('permissions' , $permissions)->render('dashboard.governorates.index');
    }

    public function create()
    {
        userAbility(['store-governorates']);
        return view('dashboard.governorates.create');
    }

    public function store(GovernorateRequest $request)
    {
        // return $request;
        try {
            userAbility(['store-governorates']);
            Governorate::create($request->validated());
            return redirect()->route('admin.governorates.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            userAbility(['show-governorates']);
            $governorate = Governorate::findOrFail(Crypt::decrypt($id));
            return view('dashboard.governorates.show', compact('governorate'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function edit( $id)
    {
        try {
            userAbility(['update-governorates']);
            $governorate = Governorate::findOrFail(Crypt::decrypt($id));
            return view('dashboard.governorates.edit', compact('governorate'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(GovernorateRequest $request, $id)
    {
        try {
            userAbility(['update-governorates']);
            $governorate = Governorate::findOrFail(Crypt::decrypt($id));
            $governorate->update($request->validated());
            return redirect()->route('admin.governorates.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        try {
            userAbility(['delete-governorates']);
            $governorate = Governorate::findOrFail(Crypt::decrypt($id));
            $governorate->delete();
            return redirect()->route('admin.governorates.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
