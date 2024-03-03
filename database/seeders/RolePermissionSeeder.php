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
            'roles',
            'main',
            'categories',
            'products',
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

        $super_admin = Role::create(['name' => 'super-admin']);
        $admin_role = Role::create(['name' => 'admin']);
        $super_admin = Role::create(['name' => 'employee']);
        $customer = Role::create(['name' => 'customer']);
        $admin_role->givePermissionTo([ 'users']);


    }
}
