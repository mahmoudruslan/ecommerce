<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ProductDataTable;
use App\Models\product;
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
            $product = Product::create([
                // name_ar
                // name_en
                // price
                // description_ar
                // description_en
                // quantity
                // category_id
                // featured
                // status
            ]);
            return redirect()->route('admin.products.index')->with(['success' => __('Product Created successfully')]);
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
            $product = Product::findOrFail(Crypt::decrypt($id));
            return view('dashboard.products.edit', compact('product'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'image' => 'avatar.png',
            ]);
            return redirect()->route('admin.products.index')->with('success','Product updated successfully.');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect()->route('admin.products.index')->with('success','Product deleted successfully');
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

}

