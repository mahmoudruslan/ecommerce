<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
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
            $users = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => true,
                'image' => 'product-1',
                'password' => Hash::make('password'),
            ]);
            return redirect()->route('admin.users.index')->with(['success' => __('Item Created successfully.')]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($slug, $id)
    {
        dd('show user');

        try {
            $users = User::findOrFail(Crypt::decrypt($id));
            return view('dashboard.users.show', compact('user'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

    public function edit( $slug, $id)
    {
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
            $user = User::findOrFail(Crypt::decrypt($id));
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'status' => true,
                'image' => 'product-1',
                'password' => Hash::make('password'),
            ]);
            return redirect()->route('admin.users.index')->with('success', __('Item Updated successfully.'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }
}

    public function destroy( $id)
    {
        try {
            $user = User::findOrFail(Crypt::decrypt($id));
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', __('Item Deleted successfully.'));
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }
}
