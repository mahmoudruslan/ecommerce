<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function cards(){
        return view('admin.cards');
    }

    public function charts(){
        return view('admin.charts');
    }

    public function blanks(){
        return view('admin.blank');
    }


}
