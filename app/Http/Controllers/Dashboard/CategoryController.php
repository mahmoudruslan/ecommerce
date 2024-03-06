<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\CategoryDataTable;
use App\Models\Category;
use DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\CategoryRequest;
use Hash;
use Illuminate\Support\Facades\Crypt;

class CategoryController extends Controller
{
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('dashboard.categories.index');
    }

    public function create()
    {
        // $permissions = Permission::get();
        return view('dashboard.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            $category = Category::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'image' => 'avatar.png',
            ]);
            return redirect()->route('admin.categories.index')->with(['success' => __('Category Created successfully')]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($slug, $id)
    {
        dd('categories show');
        try {
            $category = Category::findOrFail(Crypt::decrypt($id));
            return view('dashboard.categories.show', compact('category'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

    public function edit( $slug, $id)
    {
        try {
            $category = Category::findOrFail(Crypt::decrypt($id));
            return view('dashboard.categories.edit', compact('category'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail(Crypt::decrypt($id));
            $category->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'image' => 'avatar.png',
            ]);
            return redirect()->route('admin.categories.index')->with('success','category updated successfully.');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        try {
            $category = Category::findOrFail(Crypt::decrypt($id));
            $category->delete();
            return redirect()->route('admin.categories.index')->with('success','category deleted successfully');
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

}
