<?php

namespace Database\Seeders;


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
            MediaSeeder::class,
            CategorySeeder::class,
        ]);
        \App\Models\Product::factory(1000)->create();
        $this->call([
            ProductTagsSeeder::class,
            ProductMediaSeeder::class,
        ]);
        \App\Models\User::factory(20)->create()->each(function($user){
            $user->assignRole('customer');
        });
        $super_admin = User::factory()->create([
            'first_name' => 'mahmoud',
            'last_name' => 'kora',
            'username' => 'mahmoudkora',
            'email' => 'mahmoud@gmail.com',
            'password' => Hash::make('00000000'),
            'mobile' => '01092199386',
            'image' => 'storage/images/users/avatar.svg',
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
            'image' => 'storage/images/users/avatar.svg',
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
            'image' => 'storage/images/users/avatar.svg',
            'status' => 1,
        ]);
        $employee->assignRole('employee');





                // \App\Models\Category::factory(20)->create()->each(function($category){
        //     $category->update([
        //         'parent_id' => Category::all()->random()->id
        //     ]);
        // });
    }
}
