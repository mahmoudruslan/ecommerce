<?php

namespace Database\Seeders;

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
            'value' => 'S',
        ]);
        AttributeValue::create([
            'attribute_id' => 1,
            'value' => 'M',
        ]);
        AttributeValue::create([
            'attribute_id' => 1,
            'value' => 'L',
        ]);

        AttributeValue::create([
            'attribute_id' => 2,
            'value' => 'red',
        ]);
        AttributeValue::create([
            'attribute_id' => 2,
            'value' => 'green',
        ]);
        AttributeValue::create([
            'attribute_id' => 2,
            'value' => 'blue',
        ]);

    }
}
