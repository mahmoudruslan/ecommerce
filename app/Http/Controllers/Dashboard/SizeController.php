<?php

namespace App\Http\Controllers\Dashboard;

use App\Traits\Files;
use App\Http\Controllers\Controller;
use App\DataTables\SizeDataTable;
use App\Models\Size;
use App\Http\Requests\SizeRequest;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Crypt;


class SizeController extends Controller
{
    use Files;
    public function index(SizeDataTable $dataTable)
    {
        $permissions = userAbility(['sizes', 'store-sizes', 'update-sizes', 'delete-sizes']);
        return $dataTable->with('permissions', $permissions)->render('dashboard.sizes.index');
    }

    public function create()
    {
        userAbility(['store-sizes']);
        $sizes = Size::get(['id', 'name', 'created_at']);
        return view('dashboard.sizes.create', compact('sizes'));
    }

    public function store(SizeRequest $request)
    {
        try {
            userAbility(['store-sizes']);

            Size::create([
                'name' => $request->name,
            ]);
            return redirect()->route('admin.sizes.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit(Size $size)
    {
        try {
            userAbility(['update-sizes']);
            return view('dashboard.sizes.edit', compact('size'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(SizeRequest $request, Size $size)
    {

        try {
            userAbility(['update-sizes']);
            $size->update([
                'name' => $request->name,
            ]);
            return redirect()->route('admin.sizes.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy(Size $size)
    {
        try {
            userAbility(['delete-sizes']);
            $size->delete();
            return redirect()->route('admin.sizes.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
