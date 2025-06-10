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
            PaymentMethodSeeder::class,
        ]);
        $cities = City::select('id', 'governorate_id')->get();

        $rand_city = $cities->random();
        \App\Models\Product::factory(500)->create();
        \App\Models\User::factory(20)->create()->each(function($user) use ($cities, $rand_city){
            $user->assignRole('customer');
            $user->addresses()->create([
                'user_id' => $user->id,
                'default_address' => rand(0, 1),
                'address_title' => fake()->sentence(4),
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
            'email' => $user->email,
            'mobile' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'address2' => fake()->address(),
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
            'image' => 'images/users/avatar.png',
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
            'image' => 'images/users/avatar.png',
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
            'image' => 'images/users/avatar.png',
            'status' => 1,
        ]);
        $employee->assignRole('employee');

        $customer = User::factory()->create([
            'first_name' => 'ahmed',
            'last_name' => 'hossam',
            'username' => 'ahmedhossam',
            'email' => 'ahmedhossam@gmail.com',
            'password' => Hash::make('00000000'),
            'mobile' => '010979788989',
            'image' => 'images/users/avatar.png',
            'status' => 1,
        ]);
        $customer->assignRole('customer');
        $customer->addresses()->create([
            'default_address' => rand(0, 1),
            'address_title' => fake()->sentence(4),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => $customer->email,
            'mobile' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'address2' => fake()->address(),
            'governorate_id' => 1,
            'city_id' => City::where('governorate_id', 1)->first()->id,
            'zip_code' => rand(111, 999),
            'po_box' => rand(111111, 999999),
            ]);
        $this->call([
            ProductTagsSeeder::class,
            ProductMediaSeeder::class,
            SizeSeeder::class,
            ProductSizesSeeder::class,
            AttributeSeeder::class,
            CategoryTagsSeeder::class,
            ReviewSeeder::class,
            ShippingCompanySeeder::class,
            OrderSeeder::class

        ]);
    }
}
