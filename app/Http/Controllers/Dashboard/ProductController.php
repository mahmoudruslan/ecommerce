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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    use Files;

    public function index(ProductDataTable $dataTable)
    {
        //userAbility() method => App/Helpers/Helper.php
        $permissions = userAbility(['products','store-products', 'update-products', 'show-products','delete-products']);//pass to dataTable class
        return $dataTable->with('permissions' , $permissions)->render('dashboard.products.index');
    }

    public function create()
    {
        userAbility(['store-products']);
        $categories = Category::select('id', 'name_ar', 'name_en', 'parent_id')->whereNotNull('parent_id')->with('parent:id,name_ar,name_en')->get();
        $tags = Tag::select('id', 'name_ar', 'name_en')->get();
        return view('dashboard.products.create', compact('categories', 'tags'));
    }

    public function store(ProductRequest $request)
    {
        userAbility(['store-products']);
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
            //create tags
            $product->tags()->attach($request->tags);
            return redirect()->route('admin.products.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            userAbility(['show-products']);
            $product = Product::findOrFail(Crypt::decrypt($id));
            return view('dashboard.products.show', compact('product'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function edit( $id)
    {
        try {
            userAbility(['update-products']);
            $categories = Category::select('id', 'name_ar', 'name_en', 'parent_id')->whereNotNull('parent_id')->with('parent:id,name_ar,name_en')->get();
            $product = Product::findOrFail(Crypt::decrypt($id));
            $tags = Tag::select('id', 'name_ar', 'name_en')->get();
            return view('dashboard.products.edit', compact('product', 'categories', 'tags'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function update(ProductRequest $request, $id)
    {
        try {
            userAbility(['update-products']);
            $product = Product::findOrFail(Crypt::decrypt($id));
            $input['name_ar'] = $request->name_ar;
            $input['name_en'] = $request->name_en;
            $input['price'] = $request->price;
            $input['description_ar'] = $request->description_ar;
            $input['description_en'] = $request->description_en;
            $input['quantity'] = $request->quantity;
            $input['category_id'] = $request->category_id;
            $input['featured'] = $request->featured ?? 0;
            $input['status'] = $request->status ?? 0;
            $product->update($input);
            //update media
            if(isset($request->images)){
                $this->createProductMedia($request->images, $product);
            }
            //update tags
            $product->tags()->sync($request->tags);

            return redirect()->route('admin.products.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy($id)
    {
        try {
            userAbility(['delete-products']);
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

    public function removeImage(Request $request)
    {
        userAbility(['delete-products']);
        $product = Product::findOrFail($request->product_id);
        $media = $product->media()->whereId($request->media_id)->first();
        $this->deleteFiles($media->file_name);
        $media->delete();
        return response()->json([]);
    }

}

