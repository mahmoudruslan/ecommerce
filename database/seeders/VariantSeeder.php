<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_product = Product::find(500);
        $first_variant = Variant::create([
            'product_id' => $first_product->id,
            'sku' => 'PRD-'. $first_product->id .'-' . Str::random(7),
            'quantity' => random_int(1, 10),
            'price' => rand(100, 1000),
        ]);

        VariantAttribute::create([
            'product_id' => $first_product->id,
            'variant_id' => $first_variant->id,
            'attribute_id' => 1,
            'attribute_value_id' => 1,
        ]);
        VariantAttribute::create([
            'product_id' => $first_product->id,
            'variant_id' => $first_variant->id,
            'attribute_id' => 2,
            'attribute_value_id' => 4,
        ]);

        //second variant
        $second_variant = Variant::create([
            'product_id' => $first_product->id,
            'sku' => 'PRD-'. $first_product->id .'-' . Str::random(7),
            'quantity' => random_int(1, 10),
            'price' => rand(100, 1000),
        ]);

        VariantAttribute::create([
            'product_id' => $first_product->id,
            'variant_id' => $second_variant->id,
            'attribute_id' => 1,
            'attribute_value_id' => 2,
        ]);
        VariantAttribute::create([
            'product_id' => $first_product->id,
            'variant_id' => $second_variant->id,
            'attribute_id' => 2,
            'attribute_value_id' => 5,
        ]);

        // third variant

        $third_variant = Variant::create([
            'product_id' => $first_product->id,
            'sku' => 'PRD-'. $first_product->id .'-' . Str::random(7),
            'quantity' => random_int(1, 10),
            'price' => rand(100, 1000),
        ]);

        VariantAttribute::create([
            'product_id' => $first_product->id,
            'variant_id' => $third_variant->id,
            'attribute_id' => 1,
            'attribute_value_id' => 3,
        ]);
        VariantAttribute::create([
            'product_id' => $first_product->id,
            'variant_id' => $third_variant->id,
            'attribute_id' => 2,
            'attribute_value_id' => 6,
        ]);
        $first_product->update([
            'has_variants' => true
        ]);
    }
}
