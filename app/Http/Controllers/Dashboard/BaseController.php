<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.index');
    }

    public function blank()
    {
        return view('dashboard.blank');
    }

    public function buttons()
    {
        return view('dashboard.buttons');
    }

    public function cards()
    {
        return view('dashboard.cards');
    }

    public function charts()
    {
        return view('dashboard.charts');
    }

    public function tables()
    {
        return view('dashboard.tables');
    }

}
