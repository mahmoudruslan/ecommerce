<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
                Coupon::create([
                        'code' => 'ramadan200',
                        'type' => 'fixed',
                        'value' => 200,
                        'description_en' => 'Discount 200 pound on your sales on website',
                        'description_ar' => 'خصم 200 جنيه على مبيعاتك على الموقع',
                        'use_times' => 20,
                        'start_date' => Carbon::now(),
                        'expire_date' => Carbon::now()->addMonth(),
                        'greater_than' => 600,
                ]);
                Coupon::create([
                        'code' => '3edfetr200',
                        'type' => 'fixed',
                        'value' => 200,
                        'description_en' => 'Discount 200 pound on your sales on website',
                        'description_ar' => 'خصم 200 جنيه على مبيعاتك على الموقع',
                        'use_times' => 20,
                        'start_date' => Carbon::now(),
                        'expire_date' => Carbon::now()->addMonth(),
                        'greater_than' => 600,
                ]);
        }
}
