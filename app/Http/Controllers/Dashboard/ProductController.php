<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\DataTables\ProductDataTable;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Traits\Files;
use App\Traits\Helper;
use Illuminate\Support\Facades\Crypt;
class ProductController extends Controller
{
    use Files, Helper;

    public function index(ProductDataTable $dataTable)
    {
        $user_id = auth()->id();
        // $user = User::findOrFail($user_id)->roles->first()->permissions->pluck('name')->toArray();
        // return $user;
        // $permissions = User::findOrFail($user_id)->with(['roles']);
        // return $permissions;
        // $permissions = User::findOrFail($user_id)->roles->first()->permissions->pluck('name')->toArray();
        // return $permissions;
        // $product = Product::find(1)->user_permissions;
        // return $product;
        $this->checkAbility(['products','store-products', 'update-products', 'show-products','delete-products']);
        return $dataTable->with([
            'update' => true,
       ])->render('dashboard.products.index');
    }

    public function create()
    {
        $this->checkAbility(['store-products']);
        $categories = Category::select('id', 'name_ar', 'name_en', 'parent_id')->whereNotNull('parent_id')->with('parent:id,name_ar,name_en')->get();
        $tags = Tag::select('id', 'name_ar', 'name_en')->get();
        // return $categories;
        return view('dashboard.products.create', compact('categories', 'tags'));
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
                'featured' => $request->featured ?? 0,
                'status' => $request->status ?? 0
            ]);
           //create media
            $this->createProductMedia($request->images, $product);
            $product->tags()->attach($request->tags);
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
            dd(true);
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
            $this->deleteProductMedia($product);
            $product->tags()->detach();
            $product->delete();
            return redirect()->route('admin.products.index')->with([
                'message' => __('Item Deleted successfully.'),
                'alert-type' => 'success',

            ]);
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

