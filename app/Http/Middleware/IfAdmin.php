<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IfAdmin
{

     // in case the admin tries login from customer form

    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->hasRole('customer')) {
            return redirect('/admin');
        }
        return $next($request);
    }
}
