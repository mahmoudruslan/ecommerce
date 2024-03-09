<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ProductDataTable;
use App\Models\Product;
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
        // return Product::with(['category:id,name_ar,name_en,parent_id' => ['parent:id,name_ar,name_en']])->get();
        // return Product::with(['category:id,name_ar,name_en,parent_id' => ['parent:id,name_ar,name_en']])->get();
        return $dataTable->render('dashboard.products.index');
    }

    public function create()
    {
        $categories = Category::select('id', 'name_ar', 'name_en', 'parent_id')->whereNotNull('parent_id')->with('parent:id,name_ar,name_en')->get();
        // return $categories;
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        try {
            // return $request;
            $product = Product::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'price' => $request->price,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'quantity' => $request->quantity,
                'category_id' => $request->category_id,
                'featured' => $request->featured,
                'status' => $request->status
            ]);
            return redirect()->route('admin.products.index')->with(['success' => __('Item Created successfully.')]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($slug, $id)
    {
        try {
            $product = Product::findOrFail(Crypt::decrypt($id));
            return view('dashboard.products.show', compact('product'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function edit( $slug, $id)
    {
        try {
            $categories = Category::select('id', 'name_ar', 'name_en', 'parent_id')->whereNotNull('parent_id')->with('parent:id,name_ar,name_en')->get();
            // $categories = Category::whereNotNull('parent_id')->select('id', 'parent_id', 'name_ar', 'name_en')->get();
            $product = Product::findOrFail(Crypt::decrypt($id));
            return view('dashboard.products.edit', compact('product', 'categories'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail(Crypt::decrypt($id));
            $product->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'price' => $request->price,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'quantity' => $request->quantity,
                'category_id' => $request->category_id,
                'featured' => $request->featured ?? 0,
                'status' => $request->status ?? 0
            ]);
            return redirect()->route('admin.products.index')->with('success', __('Item Updated successfully.'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', __('Item Deleted successfully.'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

}

