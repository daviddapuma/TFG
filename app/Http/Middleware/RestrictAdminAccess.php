<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use User;

class RestrictAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //if is an admin and is loged in we let the access to the panel
        if(Auth::check() && Auth::user()->isAdmin()){
            return $next($request);
        }
        //is not an admin or is not logged in
        return redirect("/login");
    }
}
