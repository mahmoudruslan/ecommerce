<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\DataTables\ProductDataTable;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\Tag;
use App\Models\Variant;
use App\Models\VariantAttribute;
use App\Traits\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    use Files;

    public function index(ProductDataTable $dataTable)
    {
        $permissions = userAbility(['products', 'store-products', 'update-products', 'show-products', 'delete-products']); //pass to dataTable class
        return $dataTable->with('permissions', $permissions)->render('dashboard.products.index');
    }

    public function create()
    {
        userAbility(['store-products']);
        $categories = Category::select('id', 'name_ar', 'name_en', 'parent_id')->whereNotNull('parent_id')->with('parent:id,name_ar,name_en')->get();
        $tags = Tag::select('id', 'name_ar', 'name_en')->get();
        $sizes = Size::select('id', 'name')->get();
        $attributes = Attribute::with('values')->get();
        return view('dashboard.products.create', compact('categories', 'tags', 'sizes', 'attributes'));
    }

    public function store(Request $request)
    {
        return $request->all();
        if ($request->has_variants)
        {
                $product = Product::find(1);
            foreach ($request->variants as $variation)
            {
                $variant = Variant::create([
                    'product_id' => $product->id,
                    'quantity' => $variation['quantity'],
                    'price' => $variation['price'],
                    'sku' => 'df-fg-fg-hg-h-gfh-fh-fh' . rand(100, 999),
                ]);
                foreach ($variation['attributes'] as $attribute => $value)
                {
                    VariantAttribute::create([
                        'variant_id' => $variant->id,
                        'attribute_id' => $attribute,
                        'attribute_value_id' => $value,
                    ]);
                }

            }
        }
        dd(true);
        try {
            $product = Product::create($request->only([
                'name_ar',
                'name_en',
                'price',
                'description_ar',
                'description_en',
                'video_link',
                'iframe',
                'category_id',
                'featured',
                'status',
            ]));

            //create media
            $this->createProductMedia($request->images, $product);
            //upload size guide image
            $this->createProductMedia([$request->size_guide], $product, 'size_guide');

            //create tags
            $product->tags()->attach($request->tags);
            //create sizes
            $sizesData = [];
            foreach ($request->input('sizes', []) as $sizeId => $data) {
                if (!empty($data['selected'])) {
                    $sizesData[$sizeId] = [
                        'quantity' => $data['quantity'] ?? 0
                    ];
                }
            }
            $product->sizes()->sync($sizesData);
            return redirect()->route('admin.products.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success'
            ]);
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

    public function edit($id)
    {
        try {
            userAbility(['update-products']);
            $categories = Category::select('id', 'name_ar', 'name_en', 'parent_id')->whereNotNull('parent_id')->with('parent:id,name_ar,name_en')->get();
            $product = Product::findOrFail(Crypt::decrypt($id));
            $tags = Tag::select('id', 'name_ar', 'name_en')->get();
            $sizes = Size::select('id', 'name')->get();
            return view('dashboard.products.edit', compact('product', 'categories', 'tags', 'sizes'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            userAbility(['update-products']);
            $product = Product::findOrFail(Crypt::decrypt($id));
            //update size guide image
            $file_name = $product->size_guide;
            $path = '';
            if ($size_guide_image = $request->file('size_guide')) {
                $this->deleteFiles($file_name);
                $path = 'images/products/size_guide/';
                $file_name = $path . $this->saveImag($path, [$request->size_guide]);
                $this->resizeImage(300, null, $path, $file_name, $size_guide_image);
            }
            $input['name_ar'] = $request->name_ar;
            $input['name_en'] = $request->name_en;
            $input['price'] = $request->price;
            $input['description_ar'] = $request->description_ar;
            $input['description_en'] = $request->description_en;
            $input['video_link'] = $request->video_link ?? null;
            $input['iframe'] = $request->iframe ?? null;
            $input['category_id'] = $request->category_id;
            $input['featured'] = $request->featured ?? 0;
            $input['status'] = $request->status ?? 0;
            $input['size_guide'] = $file_name;
            $product->update($input);
            //update media
            if (isset($request->images)) {
                $this->createProductMedia($request->images, $product);
            }
            //update tags
            $product->tags()->sync($request->tags);


            //update sizes
            $sizeData = [];
            foreach ($request->sizes as $sizeId => $size) {
                if (!empty($size['selected'])) {
                    $sizeData[$sizeId] = [
                        'quantity' => $size['quantity'] ?? 0,
                    ];
                }
            }
            $product->sizes()->sync($sizeData);
            return redirect()->route('admin.products.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success'
            ]);
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
