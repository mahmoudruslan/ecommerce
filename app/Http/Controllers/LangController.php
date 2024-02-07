<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LangController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function switch($lang)
    {
        if (! in_array($lang, ['en', 'ar'])) {
            abort(400);
        }

        App::setLocale($lang);
        return redirect()->back();

    }
}
