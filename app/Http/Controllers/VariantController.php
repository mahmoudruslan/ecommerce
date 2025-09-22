<?php

namespace App\Http\Controllers;

use App\Http\Requests\Variants\StoreVariantRequest;
use App\Http\Requests\Variants\UpdateVariantRequest;
use App\Models\Attribute;
use App\Models\Media;
use App\Models\Product;
use App\Models\Variant;
use App\Traits\Files;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        // return $attributes;
        return view('dashboard.products.variants.create', compact('product', 'attributes'));
    }

    /**
     * Store a newly created Variant and its related attributes and media.
     *
     * @param  \App\Http\Requests\StoreVariantRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Httsp\RedirectResponse
     */
    public function store(StoreVariantRequest $request, Product $product)
    {
        try{
            DB::transaction(function () use ($request, $product) {
                // Create Variant
                $variant = $product->variants()->create($request->except('product_id', 'has_variants', 'images', '_token'));
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
                'message' => $e->getMessage(),
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

            return view('dashboard.products.variants.edit', compact('product',  'variant'));
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
                $variant->update($request->except('primary_attribute_id', 'secondary_attribute_id', 'product_id', 'has_variants', 'images', '_token'));

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
        // TODO: Check if the product has other variants, if not update the product's has_variants to false
        // TODO: Check if the variant is associated with any orders, if so prevent deletion
        //TODO: Check if the variant is associated with any cart
        // Delete associated media files
        $variant->delete();
        return redirect()->route('admin.products.show', $product)->with([
            'message' => __('Product Updated successfully.'),
            'alert-type' => 'success'
        ]);

    }

    public function forceDelete(Product $product, Variant $variant)
    {
        userAbility(['delete-variants']);
        // TODO: Check if the product has other variants, if not update the product's has_variants to false
        // TODO: Check if the variant is associated with any orders, if so prevent deletion
        //TODO: Check if the variant is associated with any cart
        // Delete associated media files
        $this->deleteProductMedia($variant, 'image');
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
    /**
     * Check available variants based on selected attribute value.
     *
     * @param int $product_id
     * @param int $attribute_id
     * @param int $attribute_value_id
     * @return \Illuminate\Http\JsonResponse
     */
    // public function checkVariants($product_id, $attribute_id, $attribute_value_id)
    // {
    //     $available_colors = Variant::whereHas('attributeValues', function ($query) use ($product_id, $attribute_id, $attribute_value_id) {
    //         return $query->where('product_id', $product_id)
    //             ->where('attribute_id', $attribute_id)
    //             ->where('attribute_value_id', $attribute_value_id);
    //                 })
    //             ->with(['attributeValues', 'attributeValues.attributeValue:id,value_en'])
    //             ->get()
    //             ->flatMap->attributeValues
    //             ->where('attribute_id', '!=',  $attribute_id)
    //             ->values()
    //             ->pluck('attributeValue');

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $available_colors
    //     ]);
    // }

    public function availableAttributeValues(Request $request, $product_id, $primary_attribute_id, $primary_attribute_value_id)
    {
        $available_values = Variant::with('secondaryAttributeValue')
            ->where('product_id', $product_id)
            ->where('primary_attribute_id', $primary_attribute_id)
            ->where('primary_attribute_value_id', $primary_attribute_value_id)
            ->whereNotNull('secondary_attribute_id')
            ->get()
            // ->pluck('secondaryAttributeValue')
            ;

        return response()->json([
            'status' => 'success',
            'data' => $available_values
        ]);
    }
}
