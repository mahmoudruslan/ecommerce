<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    public function shop()
    {
        return view('user.shop');
    }
    public function detail()
    {
        return view('user.detail');
    }
    public function cart()
    {
        return view('user.cart');
    }
    public function checkout()
    {
        return view('user.checkout');
    }
}
