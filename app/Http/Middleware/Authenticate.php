<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $route_name = Route::getFacadeRoot()->current()->uri();
            $route = explode('/', $route_name);
            if ($route[0] == 'admin') {
                return route('admin.login');
            }
            return route('login');
        }
    }
}
