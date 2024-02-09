<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('dashboard.auth.login');
    }

    public function showForgetPasswordForm()
    {
        return view('dashboard.auth.passwords.email');
    }
}
