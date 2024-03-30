<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Crypt;
use App\Traits\Helper;
use App\Http\Requests\RolePermissionRequest;


class RolePermissionController extends Controller
{
    use Helper;

    public function index(RoleDataTable $dataTable)
    {
        $this->checkAbility(['roles','store-roles', 'update-roles', 'show-roles','delete-roles']);
        return $dataTable->render('dashboard.roles_permissions.index');
    }

    public function create()
    {
        $this->checkAbility(['store-roles']);
        $permissions = Permission::get();
        return view('dashboard.roles_permissions.create', compact('permissions'));
    }

    public function store(RolePermissionRequest $request)
    {
        try {
            $this->checkAbility(['store-roles']);
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
            $role->givePermissionTo($request->permissions);
            return redirect()->route('permission-role.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            $this->checkAbility(['update-roles']);
            $permissions = Permission::get();
            $role = Role::findOrFail(Crypt::decrypt($id));
            return view('dashboard.roles_permissions.edit', compact('permissions', 'role'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function update(RolePermissionRequest $request, $id)
    {
        try {
            $this->checkAbility(['update-roles']);
            $role = Role::findOrFail(Crypt::decrypt($id));
            $role->update(['name' => $request->name , 'guard_name'=> 'web' ]);
            $permissions = $request->permissions ?? [];
            $role->syncPermissions($permissions);
            return redirect()->route('admin.permission-roles.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy(Role $role, $id)
    {
        try {
            $this->checkAbility(['delete-roles']);
            $role = Role::findOrFail(Crypt::decrypt($id));
            $permissions = $role->permissions->pluck('name');
            $role->revokePermissionTo($permissions);
            $role->delete();
            return redirect()->route('admin.permission-roles.index')->with('success', __('Item Deleted successfully.'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }
}
