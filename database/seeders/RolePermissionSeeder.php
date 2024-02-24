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
            'create-user',          'view-users',           'update-user',              'delete-user',
            'create-role',          'view-roles',           'update-role',              'delete-role',
            'create-product',       'view-products',        'update-product',           'delete-product',
            'create-order',         'view-orders',          'update-order',             'delete-order',
            'create-setting',       'view-settings',        'update-setting',           'delete-setting',
            'create-report',        'view-reports',         'update-report',            'delete-report',
            'create-category',      'view-categories',      'update-category',          'delete-category',
            'create-subcategory',   'view-subcategories',   'update-subcategory',       'delete-subcategory',
            'create-payment-method','view-payment-methods', 'update-payment-method',    'delete-payment-method',
            'create-role-permission',       'view-role-permissions',        'update-role-permission',           'delete-role-permission',
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
        
        $admin_role = Role::create(['name' => 'admin']);
        $super_admin = Role::create(['name' => 'super-admin']);
        $admin_role->givePermissionTo(['create-user',          
        'create-role',          
        'create-product',       
        'create-order',         
        'delete-setting',       
        'create-report',        
        'create-category',      
        'create-subcategory',   
        'create-payment-method',
        'create-role-permission',       ]);


    }
}
