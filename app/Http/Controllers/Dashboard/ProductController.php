<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ProductDataTable;
use App\Models\Category;
use DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\ProductRequest;
use Hash;

use Illuminate\Support\Facades\Crypt;
class ProductController extends Controller
{
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('dashboard.products.index');
    }

    public function create()
    {
        return view('dashboard.products.create');
    }

    public function store(ProductRequest $request)
    {
        try {
            $category = Category::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'image' => 'avatar.png',
            ]);
            return redirect()->route('admin.products.index')->with(['success' => __('Category Created successfully')]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($slug, $id)
    {
        try {
            $category = Category::findOrFail(Crypt::decrypt($id));
            return view('dashboard.products.show', compact('category'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

    public function edit( $slug, $id)
    {
        try {
            $category = Category::findOrFail(Crypt::decrypt($id));
            return view('dashboard.products.edit', compact('category'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'image' => 'avatar.png',
            ]);
            return redirect()->route('admin.products.index')->with('success','category updated successfully.');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()->route('admin.products.index')->with('success','category deleted successfully');
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

}

