<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('00000000'),
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
            'password' => Hash::make('00000000'),
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
            'password' => Hash::make('11111111'),
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
                'password' => Hash::make('11111111'),
                'email_verified_at' => now(),
                'phone' => '010921' . rand(10000, 99999),
                'status' => '1',
                'user_image' => 'avatar.png',
                'remember_token' => Str::random(10),
            ]);
            $random_customer->attachRole($customerRole);
        }

        $manageMain = Permission::create(['name' => 'main','display_name' => 'main','description' => '','route' => 'index','module' => 'index','as' => 'index','icon' => 'fas fa-home','parent' => '0','parent_original' => '0','sidebar_link' => '1','appear' => '1','ordering' => '1',]);
        $manageMain->parent_show = $manageMain->id;
        $manageMain->save();

        $manageProductCategories = Permission::create(['name' => 'manageProductCategories','display_name' => 'Categories','description' => '','route' => 'product_categories','module' => 'product_categories','as' => 'product_categories.index','icon' => 'fas fa-file-archive','parent' => '0','parent_original' => '0','sidebar_link' => '1','appear' => '1','ordering' => '5',]);
        $manageProductCategories->parent_show = $manageProductCategories->id;
        $manageProductCategories->save();

        Permission::create(['name' => 'showProductCategories','display_name' => 'Categories','description' => '','route' => 'product_categories','module' => 'product_categories','as' => 'product_categories.index','icon' => 'fas fa-file-archive','parent' => $manageProductCategories->id,'parent_original' => $manageProductCategories->id,'sidebar_link' => '1','appear' => '1','parent_show' => $manageProductCategories->id]);
        
        Permission::create(['name' => 'createProductCategories','display_name' => 'Create Categories','route' => 'product_categories','module' => 'product_categories','as' => 'product_categories.create','icon' => null,'parent' => $manageProductCategories->id,'parent_original' => $manageProductCategories->id,'sidebar_link' => '1','appear' => '0','parent_show' => $manageProductCategories->id]);
        
        Permission::create(['name' => 'display ProductCategories','display_name' => 'Show Categories','route' => 'product_categories','module' => 'product_categories','as' => 'product_categories.show','icon' => null,'parent' => $manageProductCategories->id,'parent_original' => $manageProductCategories->id,'sidebar_link' => '1','appear' => '0','parent_show' => $manageProductCategories->id]);
        
        Permission::create(['name' => 'update ProductCategories','display_name' => 'Update Categories','route' => 'product_categories','module' => 'product_categories','as' => 'product_categories.edit','icon' => null,'parent' => $manageProductCategories->id,'parent_original' => $manageProductCategories->id,'sidebar_link' => '1','appear' => '0','parent_show' => $manageProductCategories->id]);
        
        Permission::create(['name' => 'delete ProductCategories','display_name' => 'Delete Categories','route' => 'product_categories','module' => 'product_categories','as' => 'product_categories.destroy','icon' => null,'parent' => $manageProductCategories->id,'parent_original' => $manageProductCategories->id,'sidebar_link' => '1','appear' => '0','parent_show' => $manageProductCategories->id]);



        $manageProducts = Permission::create(['name' => 'manageProducts','display_name' => 'Products','description' => '','route' => 'products','module' => 'products','as' => 'products.index','icon' => 'fas fa-file-archive','parent' => '0','parent_original' => '0','sidebar_link' => '1','appear' => '1','ordering' => '5',]);
        $manageProducts->parent_show = $manageProducts->id;
        $manageProducts->save();

        Permission::create(['name' => 'showProducts','display_name' => 'Products','description' => '','route' => 'products','module' => 'products','as' => 'products.index','icon' => 'fas fa-file-archive','parent' => $manageProducts->id,'parent_original' => $manageProducts->id,'sidebar_link' => '1','appear' => '1','parent_show' => $manageProducts->id]);
        
        Permission::create(['name' => 'createProducts','display_name' => 'Create Products','route' => 'products','module' => 'products','as' => 'products.create','icon' => null,'parent' => $manageProducts->id,'parent_original' => $manageProducts->id,'sidebar_link' => '1','appear' => '0','parent_show' => $manageProducts->id]);
        
        Permission::create(['name' => 'display Products','display_name' => 'Show Products','route' => 'products','module' => 'products','as' => 'products.show','icon' => null,'parent' => $manageProducts->id,'parent_original' => $manageProducts->id,'sidebar_link' => '1','appear' => '0','parent_show' => $manageProducts->id]);
        
        Permission::create(['name' => 'update Products','display_name' => 'Update Products','route' => 'products','module' => 'products','as' => 'products.edit','icon' => null,'parent' => $manageProducts->id,'parent_original' => $manageProducts->id,'sidebar_link' => '1','appear' => '0','parent_show' => $manageProducts->id]);
        
        Permission::create(['name' => 'delete Products','display_name' => 'Delete Products','route' => 'products','module' => 'products','as' => 'products.destroy','icon' => null,'parent' => $manageProducts->id,'parent_original' => $manageProducts->id,'sidebar_link' => '1','appear' => '0','parent_show' => $manageProducts->id]);



        $manageTags = Permission::create(['name' => 'manageTags','display_name' => 'Tags','description' => '','route' => 'tags','module' => 'tags','as' => 'tags.index','icon' => 'fas fa-tags','parent' => '0','parent_original' => '0','sidebar_link' => '1','appear' => '1','ordering' => '5',]);
        $manageTags->parent_show = $manageTags->id;
        $manageTags->save();

        Permission::create(['name' => 'showTags','display_name' => 'Tags','description' => '','route' => 'tags','module' => 'tags','as' => 'tags.index','icon' => 'fas fa-tags','parent' => $manageTags->id,'parent_original' => $manageTags->id,'sidebar_link' => '1','appear' => '1','parent_show' => $manageTags->id]);
        
        Permission::create(['name' => 'createTags','display_name' => 'Create Tags','route' => 'tags','module' => 'tags','as' => 'tags.create','icon' => null,'parent' => $manageTags->id,'parent_original' => $manageTags->id,'sidebar_link' => '1','appear' => '0','parent_show' => $manageTags->id]);
        
        Permission::create(['name' => 'display Tags','display_name' => 'Show Tags','route' => 'tags','module' => 'tags','as' => 'tags.show','icon' => null,'parent' => $manageTags->id,'parent_original' => $manageTags->id,'sidebar_link' => '1','appear' => '0','parent_show' => $manageTags->id]);
        
        Permission::create(['name' => 'update Tags','display_name' => 'Update Tags','route' => 'tags','module' => 'tags','as' => 'tags.edit','icon' => null,'parent' => $manageTags->id,'parent_original' => $manageTags->id,'sidebar_link' => '1','appear' => '0','parent_show' => $manageTags->id]);
        
        Permission::create(['name' => 'delete Tags','display_name' => 'Delete Tags','route' => 'tags','module' => 'tags','as' => 'tags.destroy','icon' => null,'parent' => $manageTags->id,'parent_original' => $manageTags->id,'sidebar_link' => '1','appear' => '0','parent_show' => $manageTags->id]);
    }
}
