<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Role;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $routeName = Route::getFacadeRoot()->current()->uri();
        $route = explode('/', $routeName);
        $routeRole = Role::distinct()->whereNotNull('allowed_route')->pluck('allowed_route')->toArray();
        //distinct == يعني مثلا لو كلمة ادمن متكررة كتير هاتها مرة واحدة
        if(auth()->check())
        {
            $roleUser = auth()->user()->roles->first()->allowed_route;

            if(!in_array($route[0], $routeRole))
            {
                return $next($request);
            }else{
                if($route[0] != $roleUser)
                {
                    $path = $route[0] == $roleUser ? $route[0] . 'login' : 'index';
                    return redirect()->route($path);
                }else{
                    return $next($request);
                }
            }
        }else{
            $routeDestination = in_array($route[0], $routeRole) ? 'admin.login' : 'login';
            return redirect()->route($routeDestination);

        }
        
    }
}
