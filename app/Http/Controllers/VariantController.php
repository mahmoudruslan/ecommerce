<?php

namespace App\Http\Controllers;

use App\Http\Requests\Variants\StoreVariantRequest;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantAttribute;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {

        $attributes = Attribute::with('values')->get();
        return view('dashboard.products.variants.create', compact('product', 'attributes'));
//        return view('dashboard.products.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVariantRequest $request, Product $product)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function show(Variant $variant)
    {
        dd($variant);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function edit(Variant $variant)
    {
        dd($variant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variant $variant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variant $variant)
    {
        //
    }
}
