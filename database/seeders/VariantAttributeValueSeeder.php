<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Variant;
use App\Models\variantAttributeValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariantAttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variants = Variant::select('id')->get();
        foreach ($variants as $variant) {
            variantAttributeValue::create([
                'variant_id' => $variant->id,
                'attribute_id' => $attribute_id = rand(1, 2),
                'attribute_value_id' => AttributeValue::where('attribute_id', $attribute_id)->inRandomOrder()->first()->id,
            ]);
        }
    }
}
