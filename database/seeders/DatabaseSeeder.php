<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        // \App\Models\User::factory(10)->create();
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
            'image' => 'avatar.jpg',
            'status' => 1,
        ]);
        $user->assignRole('super-admin');
    }
}
