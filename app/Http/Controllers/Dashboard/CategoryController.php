<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\CategoryDataTable;
use App\Models\Category;
use App\Models\Product;
use DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\CategoryRequest;
use Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class CategoryController extends Controller
{
    public function index(CategoryDataTable $dataTable)
    {
        // return Category::withCount('products')->get();
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
            if($request->hasFile('image')) {
                $fileName = time().'_'.$request->image->getClientOriginalName();
                $filePath = $request->file('image')->storeAs('public/images/categories', $fileName);
            }
            $category = Category::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'image' => 'storage/categories/images/' . $fileName
            ]);
            return redirect()->route('admin.categories.index')->with(['success' => __('Item Created successfully.')]);
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
            return redirect()->route('admin.categories.index')->with('success', __('Item Updated successfully.'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        try {
            $category = Category::findOrFail(Crypt::decrypt($id));
            $category->delete();
            return redirect()->route('admin.categories.index')->with('success', __('Item Deleted successfully.'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

}
