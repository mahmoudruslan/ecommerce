<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Traits\Files;
use App\Models\User;
use App\Traits\Helper;


class UserController extends Controller
{
    use Files, Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
    {
        $this->checkAbility(['users','store-users', 'update-users', 'show-users','delete-users']);
        return $dataTable->render('dashboard.users.index');
    }

    public function create()
    {
        $this->checkAbility(['store-users']);
        return view('dashboard.users.create');
    }
    public function store(UserRequest $request)
    {
        try {
            $this->checkAbility(['store-users']);
                $image = $request->file('image');
                $path = 'images/users/';
                $file_name = $this->saveImag($path, [$request->image]);
                $this->resizeImage(400, null, $path, $file_name, $image);
            $users = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => true,
                'image' => $path . $file_name,
                'password' => Hash::make('password'),
            ]);
            return redirect()->route('admin.users.index')->with([
                'message' => __('Item Created successfully.'),
                'alert-type' => 'success']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($slug, $id)
    {
        dd('show user');

        try {
            $this->checkAbility(['show-users']);
            $users = User::findOrFail(Crypt::decrypt($id));
            return view('dashboard.users.show', compact('user'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    public function edit( $slug, $id)
    {
        try {
            $this->checkAbility(['update-users']);
            $user = User::findOrFail(Crypt::decrypt($id));
            return view('dashboard.users.edit', compact('user'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $this->checkAbility(['update-users']);
            $user = User::findOrFail(Crypt::decrypt($id));
            $file_name = $user->image;
            $path = '';
            if ($image = $request->file('image')) {
                $this->deleteFiles($file_name);
                $path = 'images/users/';
                $file_name = $this->saveImag($path, [$request->image]);
                $this->resizeImage(300, null, $path, $file_name, $image);
            }
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => true,
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

    public function destroy( $id)
    {
        try {
            $this->checkAbility(['delete-users']);
            $user = User::findOrFail(Crypt::decrypt($id));
            $this->deleteFiles($user->image);
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', __('Item Deleted successfully.'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

    public function removeImage($user_id)
    {
        $this->checkAbility(['delete-users']);
        $user = User::findOrFail($user_id);

        $this->deleteFiles($user->image);
        $user->image = null;
        $user->save();
        return response()->json([]);
    }
}
