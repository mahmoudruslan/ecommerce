<?php

namespace App\Http\Controllers;

use App\DataTables\VariantDataTable;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Http\Requests\Variants\RemoveImageRequest;
use App\Http\Requests\Variants\StoreVariantRequest;
use App\Http\Requests\Variants\UpdateVariantRequest;
use App\Models\Attribute;
use App\Models\Media;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantAttribute;
use App\Traits\Files;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VariantController extends Controller
{
    use Files;
    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        $attributes = Attribute::with('values')->get();
        return view('dashboard.products.variants.create', compact('product', 'attributes'));
    }

    /**
     * Store a newly created Variant and its related attributes and media.
     *
     * @param  \App\Http\Requests\StoreVariantRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVariantRequest $request, Product $product): RedirectResponse
    {
        try{
            DB::transaction(function () use ($request, $product) {
                // Create Variant
                $variant = $product->variants()->create($request->only('quantity', 'price', 'sku'));
                // Create Variant Attributes
                foreach ($request['attributes'] as $attribute => $value) {

                    VariantAttribute::create([
                        'variant_id' => $variant->id,
                        'attribute_id' => $attribute,
                        'attribute_value_id' => $value,
                    ]);
                }
                // Upload Variant Images
                $this->createProductMedia($request->images, $variant, 'image', 'images/variants/');
                // Update Product status
                $product->update(['has_variants' => true]);
            });
            return redirect()->route('admin.products.show', $product)->with([
                'product' => $product,
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success'
            ]);
        } catch (\Throwable $e) {
            return redirect()->back()->with([
                'message' => __('Something went wrong. Please try again.'),
                'alert-type' => 'danger'
            ]);
        }

    }



    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @param \App\Models\Variant $variant
     */
    public function show(Product $product, Variant $variant)
    {
        try {
            userAbility(['show-variants']);
            return view('dashboard.products.variants.show', compact('product',  'variant'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Variant  $variant
     */
    public function edit(Product $product, Variant $variant)
    {
        try {
            userAbility(['show-variants']);
            $attributes = Attribute::with('values')->get();
            $selectedValues = $variant->attributeValues
                ->mapWithKeys(fn ($item) => [$item->attribute_id => $item->attribute_value_id])
                ->toArray();
            return view('dashboard.products.variants.edit', compact('product',  'variant',  'attributes', 'selectedValues'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\UpdateProductRequest $request
     * @param \App\Models\Produc $product
     * @param  \App\Models\Variant  $variant
     */
    public function update(UpdateVariantRequest $request, Product $product, Variant $variant)
    {
        try {
            DB::transaction(function () use ($request, $product, $variant) {
                $variant->update($request->only('quantity', 'price'));
                // Create Variant Attributes
                foreach ($request['attributes'] as $attribute => $value) {
                    VariantAttribute::create([
                        'variant_id' => $variant->id,
                        'attribute_id' => $attribute,
                        'attribute_value_id' => $value
                    ]);
                }
                // Upload Variant Images
                $this->createProductMedia($request->images, $variant, 'image', 'images/variants/');
                // Update Product status
            });

            return redirect()->route('admin.products.variants.show', [$product, $variant])->with([
                'message' => __('Product Updated successfully.'),
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product, Variant $variant)
    {
        userAbility(['delete-variants']);
        $variant->delete();
        return redirect()->route('admin.products.show', $product)->with([
            'message' => __('Product Updated successfully.'),
            'alert-type' => 'success'
        ]);

    }

    public function removeMedia(Variant $variant, Media $media)
    {
        $mediaCount = $variant->media()->count();
        if ($mediaCount <= 1) {
            throw ValidationException::withMessages([
                'media' => ['Cannot delete the last image of this product.']
            ]);
        }
        $this->deleteFiles($media->file_name);
        $media->delete();
        return response()->json([
            'status' => 'success',
            'message' => __('image removed successfully.'),
            'code' => Response::HTTP_OK
        ]);
    }
}
