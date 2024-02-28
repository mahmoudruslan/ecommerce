<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function store()
    {
        return view('store.index');
    }

    public function cart()
    {
        return view('store.cart');
    }

    public function checkout()
    {
        return view('store.checkout');
    }

    public function detail()
    {
        return view('store.detail');
    }

    public function shop()
    {
        return view('store.shop');
    }



}
