<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ProductDataTable;
use App\Models\Product;
use App\Models\Category;
use App\Traits\Helper;


use Illuminate\Support\Facades\Crypt;
class ProductController extends Controller
{
    use Helper;

    public function index(ProductDataTable $dataTable)
    {
        $this->checkAbility(['products','store-products', 'update-products', 'show-products','delete-products']);
        return $dataTable->render('dashboard.products.index');
    }

    public function create()
    {
        $this->checkAbility(['store-products']);
        $categories = Category::select('id', 'name_ar', 'name_en', 'parent_id')->whereNotNull('parent_id')->with('parent:id,name_ar,name_en')->get();
        // return $categories;
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->checkAbility(['store-products']);
        try {
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
            //create media
                // $product->media()->create(Arr::random($images));

            return redirect()->route('admin.products.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($slug, $id)
    {
        try {
            $this->checkAbility(['show-products']);
            $product = Product::findOrFail(Crypt::decrypt($id));
            return view('dashboard.products.show', compact('product'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function edit( $slug, $id)
    {
        try {
            $this->checkAbility(['update-products']);
            $categories = Category::select('id', 'name_ar', 'name_en', 'parent_id')->whereNotNull('parent_id')->with('parent:id,name_ar,name_en')->get();
            // $categories = Category::whereNotNull('parent_id')->select('id', 'parent_id', 'name_ar', 'name_en')->get();
            $product = Product::findOrFail(Crypt::decrypt($id));
            return view('dashboard.products.edit', compact('product', 'categories'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->checkAbility(['update-products']);
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
            return redirect()->route('admin.products.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        try {
            $this->checkAbility(['delete-products']);
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', __('Item Deleted successfully.'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

    public function removeImage($product_id)
    {
        $this->checkAbility(['delete-products']);
        $product = Product::findOrFail($product_id);
        $this->deleteFiles($product->image);
        // $product->image = null;
        // $product->save();
        return response()->json([]);
    }

}

