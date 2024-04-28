<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\GovernorateDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\GovernorateRequest;
use App\Models\Governorate;
use App\Traits\Helper;
use Illuminate\Support\Facades\Crypt;

class GovernorateController extends Controller
{
    use Helper;
    public function index(GovernorateDataTable $dataTable)
    {
        $this->checkAbility(['governorates','store-governorates', 'update-governorates', 'show-governorates','delete-governorates']);
        return $dataTable->render('dashboard.governorates.index');
    }

    public function create()
    {
        $this->checkAbility(['store-governorates']);
        return view('dashboard.governorates.create');
    }

    public function store(GovernorateRequest $request)
    {
        // return $request;
        try {
            $this->checkAbility(['store-governorates']);
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
            $this->checkAbility(['show-governorates']);
            $governorate = Governorate::findOrFail(Crypt::decrypt($id));
            return view('dashboard.governorates.show', compact('governorate'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function edit( $id)
    {
        try {
            $this->checkAbility(['update-governorates']);
            $governorate = Governorate::findOrFail(Crypt::decrypt($id));
            return view('dashboard.governorates.edit', compact('governorate'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(GovernorateRequest $request, $id)
    {
        try {
            $this->checkAbility(['update-governorates']);
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
            $this->checkAbility(['delete-governorates']);
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
