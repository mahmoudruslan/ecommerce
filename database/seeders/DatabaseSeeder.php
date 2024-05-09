<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            RolePermissionSeeder::class,
            TagSeeder::class,
            CategorySeeder::class,
            CouponSeeder::class,
            GovernorateCitiesSeeder::class,
        ]);
        $cities = City::select('id', 'governorate_id')->get();
        
        \App\Models\Product::factory(1000)->create();
        \App\Models\User::factory(20)->create()->each(function($user) use ($cities){
            $user->assignRole('customer');
            $rand_city = $cities->random();
            $user->addresses()->create([
            'user_id' => $user->id,
            'default_address' => rand(0, 1),
            'address_title_en' => fake()->sentence(4),
            'address_title_ar' => fake()->sentence(4),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'mobile' => fake()->phoneNumber(),
            'address_ar' => fake()->address(),
            'address_en' => fake()->address(),
            'address2_ar' => fake()->address(),
            'address2_en' => fake()->address(),
            'governorate_id' => $rand_city->governorate_id,
            'city_id' => $rand_city->id,
            'zip_code' => rand(111111, 999999),
            'po_box' => rand(111111, 999999),
            ]);
        });
        // \App\Models\UserAddress::factory(100)->create();
        $super_admin = User::factory()->create([
            'first_name' => 'mahmoud',
            'last_name' => 'kora',
            'username' => 'mahmoudkora',
            'email' => 'mahmoud@gmail.com',
            'password' => Hash::make('00000000'),
            'mobile' => '01092199386',
            'image' => 'images/users/avatar.svg',
            'status' => 1,

        ]);
        $super_admin->assignRole('super-admin');
        $admin = User::factory()->create([
            'first_name' => 'rezk',
            'last_name' => 'kora',
            'username' => 'rezkkora',
            'email' => 'rezk@gmail.com',
            'password' => Hash::make('00000000'),
            'mobile' => '010545445446',
            'image' => 'images/users/avatar.svg',
            'status' => 1,
        ]);
        $admin->assignRole('admin');
        $employee = User::factory()->create([
            'first_name' => 'ebraheem',
            'last_name' => 'kora',
            'username' => 'ebraheemkora',
            'email' => 'ebraheem@gmail.com',
            'password' => Hash::make('00000000'),
            'mobile' => '01097978898986',
            'image' => 'images/users/avatar.svg',
            'status' => 1,
        ]);
        $employee->assignRole('employee');

        $this->call([
            ProductTagsSeeder::class,
            ProductMediaSeeder::class,
            CategoryTagsSeeder::class,
            ReviewSeeder::class,
            ShippingCompanySeeder::class
            
        ]);
    }
}
