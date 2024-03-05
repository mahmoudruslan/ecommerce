<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('dashboard.users.index');
    }

    public function create()
    {
        return view('dashboard.users.create');
    }
    public function store(UserRequest $request)
    {
        try {
            // return $request;
            $users = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => true,
                'password' => $request->password,
                'image' => 'product-1',
                'password' => Hash::make('password'),
            ]);
            return redirect()->route('admin.users.index')->with(['success' => __('User Created successfully')]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($slug, $id)
    {
        dd('edit');

        try {
            $users = User::findOrFail(Crypt::decrypt($id));
            return view('dashboard.users.show', compact('user'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

    public function edit( $slug, $id)
    {
        dd('edit');
        try {
            $user = User::findOrFail(Crypt::decrypt($id));
            return view('dashboard.users.edit', compact('user'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $users = User::findOrFail($id);
            $users->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'image' => 'avatar.png',
            ]);
            return redirect()->route('admin.users.index')->with('success','User updated successfully.');

        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        try {
            $users = User::findOrFail($id);
            $users->delete();
            return redirect()->route('admin.users.index')->with('success','User deleted successfully');
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }
}
