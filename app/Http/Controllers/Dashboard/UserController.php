<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\UserDataTable;
use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Traits\Files;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    use Files;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
    {
        $permissions = userAbility(['users','store-users', 'update-users', 'show-users','delete-users']);
        return $dataTable->with('permissions' , $permissions)->render('dashboard.users.index');
    }

    public function create()
    {
        userAbility(['store-users']);
        return view('dashboard.users.create');
    }
    public function store(UserRequest $request)
    {
        try {
            userAbility(['store-users']);
                $image = $request->file('image');
                $path = 'images/users/';
                $file_name = $this->saveImag($path, [$request->image]);
                $this->resizeImage(400, null, $path, $file_name, $image);
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => true,
                'image' => $path . $file_name,
                'type' => UserTypeEnum::CUSTOMER->value,
                'password' => Hash::make('password'),
            ]);
            $user->markEmailAsVerified();
            $user->assignRole('customer');
            return redirect()->route('admin.users.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show(User $user)
    {
        try {
            userAbility(['show-users']);
            return view('dashboard.users.show', compact('user'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit( User $user)
    {
        try {
            userAbility(['update-users']);
            return view('dashboard.users.edit', compact('user'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            userAbility(['update-users']);
            $file_name = $user->image;
            $path = '';
            if ($image = $request->file('image')) {
                $this->deleteFiles($file_name);
                $path = 'images/users/';
                $file_name = $this->saveImag($path, [$request->image]);
                $this->resizeImage(300, null, $path, $file_name, $image);
            }
            //no forget make password update optional
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => $request->status ?? 0,
                'image' => $path . $file_name,
                'password' => Hash::make('password'),
            ]);
            return redirect()->route('admin.users.index')->with([
                'message' => __('Item Updated successfully.'),
                'alert-type' => 'success']);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy(User $user)
    {
        try {
            //make soft delete
            userAbility(['delete-users']);
            $this->deleteFiles($user->image);
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', __('Item Deleted successfully.'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

    public function removeImage($user_id)
    {
        $user = User::findOrFail($user_id);
        $this->deleteFiles($user->image);
        $user->image = null;
        $user->update();

        return response()->json([]);
    }
}
