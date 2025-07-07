<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\VariantDataTable;
use App\Http\Controllers\Controller;
use App\DataTables\ProductDataTable;
use App\Http\Requests\Products\RemoveImageRequest;
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
use Illuminate\Http\Response;
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

    public function store(StoreProductRequest $request)
    {
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

    public function show(VariantDataTable $dataTable, Product $product)
    {
        $permissions = userAbility(['products', 'store-products', 'update-products', 'show-products', 'delete-products']); //pass to dataTable class
        return $dataTable->with(['permissions' => $permissions, 'product' => $product])->render('dashboard.products.show', compact('product'));
//        $product = $product->load('variants.attributeValues');
//        $map = $product->variants->map(function ($variant) use ($product) {
//            return ['product' => [
//                'id' => $product->name_en,
//                'name_en' => $product->name_en,
//                'variant' => [
//                    'id' => $variant->id,
//                    'price' => $variant->price,
//                    'quantity' => $variant->quantity,
//                    'sku' => $variant->sku,
//                    'image' => $variant->firstMedia?->file_name,
//                ],
//                'attributeValues' => $variant->attributeValues->map(function ($attributeValue) {
//                    return [
//                        'attribute' =>  $attributeValue->attribute->name_ar,
//                        'value' =>  $attributeValue->value->value_en,
//                    ];
//                }),
//            ]];
//        });
//        return $map;

        try {
            userAbility(['show-products']);
            return view('dashboard.products.show', compact('product'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit(Product $product)
    {
        try {
            userAbility(['update-products']);
            $categories = Category::select('id', 'name_ar', 'name_en', 'parent_id')->whereNotNull('parent_id')->with('parent:id,name_ar,name_en')->get();
            $tags = Tag::select('id', 'name_ar', 'name_en')->get();
            $sizes = Size::select('id', 'name')->get();
            return view('dashboard.products.edit', compact('product', 'categories', 'tags', 'sizes'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            userAbility(['update-products']);
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

    public function destroy(Product $product)
    {
        try {
            userAbility(['delete-products']);
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

    public function removeImage(RemoveImageRequest $request)
    {
        $media = $request->media;
        $this->deleteFiles($media->file_name);
        $media->delete();
        return response()->json([
            'data' => $media,
            'status' => 'success',
            'message' => __('image removed successfully.'),
            'code' => Response::HTTP_OK
        ]);
    }
}
