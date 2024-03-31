<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\DataTables\ProductDataTable;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function store(ProductRequest $request)
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
            foreach ($request->images as $image) {
                $path = 'images/products/';
                $extension = $image->getClientOriginalExtension();
                $image_name = time() . Str::random(6) . '.' . $extension;
                $image->storeAs($path, $image_name, 'public');
                $size = $image->getSize();
                $mimetype = $image->getClientMimeType();//Ge

            $product->media()->create([
                'file_name' => $path . $image_name,
                'file_size' => $size,
                'file_type' => $mimetype,
                'file_sort' => '0',
                'status' => true
            ]);
        }
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

    public function update(ProductRequest $request, $id)
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
            $product = Product::findOrFail(Crypt::decrypt($id));
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
        return response()->json([]);
    }

}

