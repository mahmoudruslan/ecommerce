<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\SupervisorDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupervisorRequest;
use App\Models\User;
use App\Traits\Files;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SupervisorController extends Controller
{
    use Files;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SupervisorDataTable $dataTable)
    {
        $permissions = userAbility(['supervisors', 'store-supervisors', 'update-supervisors', 'show-supervisors', 'delete-supervisors']);
        return $dataTable->with('permissions' , $permissions)->render('dashboard.supervisors.index');
    }

    public function create()
    {
        $roles = Role::get(['id', 'name']);
        userAbility(['store-supervisors']);
        return view('dashboard.supervisors.create', compact('roles'));
    }
    public function store(SupervisorRequest $request)
    {
        try {
            userAbility(['store-supervisors']);
            $image = $request->file('image');
            $path = 'images/supervisors/';
            $file_name = $this->saveImag($path, [$request->image]);
            $this->resizeImage(400, null, $path, $file_name, $image);
            $supervisor = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => true,
                'image' => $path . $file_name,
                'password' => Hash::make('00000000'),
            ]);
            $supervisor->markEmailAsVerified();
            $supervisor->assignRole($request->role);
            return redirect()->route('admin.supervisors.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        dd('show user');

        try {
            userAbility(['show-supervisors']);
            $supervisors = User::findOrFail(Crypt::decrypt($id));
            return view('dashboard.supervisors.show', compact('supervisor'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            userAbility(['update-supervisors']);
            $roles = Role::get('id', 'name');
            $supervisor = User::findOrFail(Crypt::decrypt($id));
            return view('dashboard.supervisors.edit', compact('supervisor', 'roles'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(SupervisorRequest $request, $id)
    {
        try {
            userAbility(['update-supervisors']);
            $supervisor = User::findOrFail(Crypt::decrypt($id));
            $file_name = $supervisor->image;
            $path = '';
            if ($image = $request->file('image')) {
                $this->deleteFiles($file_name);
                $path = 'images/supervisors/';
                $file_name = $this->saveImag($path, [$request->image]);
                $this->resizeImage(300, null, $path, $file_name, $image);
            }
            //no forget make password update optional
            $supervisor->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => $request->status ?? 0,
                'image' => $path . $file_name,
                'password' => Hash::make('00000000'),
            ]);
            if($supervisor->id == Auth::id())
            {
                return redirect()->route('admin.dashboard')->with([
                    'message' => __('Item Updated successfully.'),
                    'alert-type' => 'success'
                ]);
            }
            return redirect()->route('admin.supervisors.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            //make soft delete
            userAbility(['delete-supervisors']);
            $supervisor = User::findOrFail(Crypt::decrypt($id));
            $this->deleteFiles($supervisor->image);
            $supervisor->delete();
            return redirect()->route('admin.supervisors.index')->with('success', __('Item Deleted successfully.'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function removeImage($supervisor_id)
    {
        $supervisor = User::findOrFail($supervisor_id);
        $this->deleteFiles($supervisor->image);
        $supervisor->image = null;
        $supervisor->update();

        return response()->json([]);
    }
}
