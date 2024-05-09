<?php

namespace Database\Seeders;

use App\Models\Governorate;
use App\Models\ShippingCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aramex = ShippingCompany::create([
            'name_ar' => 'أرامكس',
            'name_en' => 'aramex',
            'code' => '2356448',
            'description_ar' => 'من 2 يوم إلى 6 أيام',
            'description_en' => '2 - 6 days',
            'fast' => false,
            'coast' => '60',
            'status' => true,
            ]);
        $governorate_ids = Governorate::inRandomOrder()->limit(15)->pluck('id');
        $aramex->governorates()->attach($governorate_ids);
        $fedex = ShippingCompany::create([
            'name_ar' => 'فسدكس',
            'name_en' => 'Fedex',
            'code' => '989565652',
            'description_ar' => 'من 1 يوم إلى 4 أيام',
            'description_en' => '1 - 4 days',
            'fast' => true,
            'coast' => '50',
            'status' => true,
            ]);
            
            $governorate_ids = Governorate::inRandomOrder()->limit(15)->pluck('id');
            $fedex->governorates()->attach($governorate_ids);
       

    }
}
