<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IfCustomer
{

    // in case the customer tries login from admin form

    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->hasRole('customer')) {
            return redirect('/');
        }

        return $next($request);
    }
}
