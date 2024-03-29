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

            'users',
            'show-users',
            'delete-users',
            'update-users',

            'roles',
            'show-roles',
            'delete-roles',
            'update-roles',

            'main',
            'show-main',
            'delete-main',
            'update-main',

            'categories',
            'show-categories',
            'delete-categories',
            'update-categories',

            'products',
            'show-products',
            'delete-products',
            'update-products',

            'tags',
            'show-tags',
            'delete-tags',
            'update-tags',
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
        $admin_role->givePermissionTo([ 'users', 'roles', 'main']);
        $employee_role->givePermissionTo(['products', 'categories', 'tags']);


    }
}
