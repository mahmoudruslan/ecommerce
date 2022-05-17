<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        //create role 1
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administration',
            'description' => 'Administrator',
            'allowed_route' => 'admin',
        ]);
        //create role 2
        $supervisorRole = Role::create([
            'name' => 'supervisor',
            'display_name' => 'Supervisor',
            'description' => 'Supervisor',
            'allowed_route' => 'admin',
        ]);
        //create role 3
        $customerRole = Role::create([
            'name' => 'customer',
            'display_name' => 'Customer',
            'description' => 'Customer',
            'allowed_route' => null,
        ]);

        //create admin
        $admin = User::create([
            'first_name' => 'Mahmoud',
            'last_name' => 'Kora',
            'username' => 'mahmoudkora',
            'email' => 'mahmoud40@gmail.com',
            'password' => '00000000',
            'email_verified_at' => now(),
            'phone' => '0109219' . rand(1000, 9999),
            'status' => '1',
            'user_image' => 'avatar.png',
            'remember_token' => Str::random(10),
        ]);
        $admin->attachRole($adminRole);
        //create supervisor
        $supervisor = User::create([
            'first_name' => 'Ahmed',
            'last_name' => 'Khaled',
            'username' => 'ahmedkhaled',
            'email' => 'ahmed40@gmail.com',
            'password' => '00000000',
            'email_verified_at' => now(),
            'phone' => '0109219' . rand(1000, 9999),
            'status' => '1',
            'user_image' => 'avatar.png',
            'remember_token' => Str::random(10),
        ]);
        $supervisor->attachRole($supervisorRole);
        //create user
        $customer = User::create([
            'first_name' => 'ebraheem',
            'last_name' => 'Kora',
            'username' => 'ebraheemkora',
            'email' => 'ebraheem40@gmail.com',
            'password' => '11111111',
            'email_verified_at' => now(),
            'phone' => '0109219' . rand(1000, 9999),
            'status' => '1',
            'user_image' => 'avatar.png',
            'remember_token' => Str::random(10),
        ]);
        $customer->attachRole($customerRole);

        //create multi user
        for ($i = 0; $i <= 20; $i++) {
            $random_customer = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => $faker->userName(),
                'email' => $faker->unique()->safeEmail,
                'password' => '11111111',
                'email_verified_at' => now(),
                'phone' => '010921' . rand(10000, 99999),
                'status' => '1',
                'user_image' => 'avatar.png',
                'remember_token' => Str::random(10),
            ]);
            $random_customer->attachRole($customerRole);
        }
    }
}
