<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\RolePermissionRequest;


class RolePermissionController extends Controller
{

    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render('dashboard.roles_permissions.index');
    }

    public function create()
    {
        $permissions = Permission::get();
        return view('dashboard.roles_permissions.create', compact('permissions'));
    }

    public function store(RolePermissionRequest $request)
    {
        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
            $role->givePermissionTo($request->permissions);
            return redirect()->route('permission-role.index')->with(['success' => __('Role Created successfully')]);
          } catch (\Exception $e) {
              return $e->getMessage();
          }
    }

    public function edit($id)
    {
        try {

            $permissions = Permission::get();
            $role = Role::findOrFail($id);
            return view('dashboard.roles_permissions.edit', compact('permissions', 'role'));
          } catch (\Exception $e) {
          
              return $e->getMessage();
          }
    }

    public function update(RolePermissionRequest $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->update(['name' => $request->name , 'guard_name'=> 'web' ]);
            $permissions = $request->permissions ?? [];
            $role->syncPermissions($permissions);
            return redirect()->route('admin.permission-role.index')->with('success','Role updated successfully.');
          
          } catch (\Exception $e) {
              return $e->getMessage();
          }
    }

    public function destroy(Role $role, $id)
    {
        try {

            $role = Role::findOrFail($id);
            $permissions = $role->permissions->pluck('name');
            $role->revokePermissionTo($permissions);
            $role->delete();
            return redirect()->route('admin.permission-role.index')->with('message','Role deleted successfully');
          } catch (\Exception $e) {
          
              return $e->getMessage();
          }
       
    }
}
