<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all_permissions = [
            'main',
            'users','show-users','delete-users','update-users','store-users',
            'roles','show-roles','delete-roles','update-roles','store-roles',
            'categories','show-categories','delete-categories','update-categories','store-categories',
            'products','show-products','delete-products','update-products','store-products',
            'tags','show-tags','delete-tags','update-tags','store-tags',
            'coupons','show-coupons','delete-coupons','update-coupons','store-coupons',
        ];

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $permissions = collect($all_permissions)->map(function($permission){
            return [
                'name' => $permission ,
                'guard_name'=> 'web'
            ];
        });
        // dd($permissions->toArray());
        Permission::insert($permissions->toArray());

        Role::create(['name' => 'super-admin']);
        $admin_role = Role::create(['name' => 'admin']);
        $employee_role = Role::create(['name' => 'employee']);
        $customer = Role::create(['name' => 'customer']);
        $admin_role->givePermissionTo([ 'users', 'roles', 'main', 'update-roles']);
        $employee_role->givePermissionTo(['products', 'categories', 'tags']);
    }
}
