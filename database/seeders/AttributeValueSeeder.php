<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AttributeValue::create([
            'attribute_id' => 1,
            'value_ar' => 'S',
            'value_en' => 'S'
        ]);
        AttributeValue::create([
            'attribute_id' => 1,
            'value_ar' => 'M',
            'value_en' => 'M'
        ]);
        AttributeValue::create([
            'attribute_id' => 1,
            'value_ar' => 'L',
            'value_en' => 'L'
        ]);
        AttributeValue::create([
            'attribute_id' => 2,
            'value_ar' => 'أحمر',
            'value_en' => 'red'
        ]);
        AttributeValue::create([
            'attribute_id' => 2,
            'value_ar' => 'أزرق',
            'value_en' => 'blue'
        ]);
        AttributeValue::create([
            'attribute_id' => 2,
            'value_ar' => 'أسود',
            'value_en' => 'black'
        ]);
    }
}
