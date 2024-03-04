<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
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
        \App\Models\User::factory(20)->create();
        \App\Models\Category::factory(20)->create()->each(function($category){
            $category->update([
                'parent_id' => Category::all()->random()->id
            ]);
        });
        \App\Models\Product::factory(100)->create();
        $this->call([
            RolePermissionSeeder::class,
        ]);

        $user = User::factory()->create([
            'first_name' => 'mahmoud',
            'last_name' => 'kora',
            'username' => 'mahmoudkora',
            'email' => 'mahmoud@gmail.com',
            'password' => Hash::make('00000000'),
            'mobile' => '01092199386',
            'image' => 'avatar.svg',
            'status' => 1,
        ]);
        $user->assignRole('super-admin');
        $user = User::factory()->create([
            'first_name' => 'rezk',
            'last_name' => 'kora',
            'username' => 'rezkkora',
            'email' => 'rezk@gmail.com',
            'password' => Hash::make('00000000'),
            'mobile' => '010545445446',
            'image' => 'avatar.svg',
            'status' => 1,
        ]);
        $user->assignRole('admin');
        $user = User::factory()->create([
            'first_name' => 'ebraheem',
            'last_name' => 'kora',
            'username' => 'ebraheemkora',
            'email' => 'ebraheem@gmail.com',
            'password' => Hash::make('00000000'),
            'mobile' => '01097978898986',
            'image' => 'avatar.svg',
            'status' => 1,
        ]);
        $user->assignRole('employee');
    }
}
