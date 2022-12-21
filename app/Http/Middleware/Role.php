<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ... $roles)
    {
        if(Auth::user()->admin == 2)
            return $next($request);

        foreach($roles as $role) {
            if(Auth::user()->admin == $role)
                return $next($request);
        }

        return redirect('/');
    }
}
