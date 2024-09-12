<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        // chk if the user is authenticated and has the required permission
        if (Auth::check() && Auth::user()->hasPermission($permission)) {
            return $next($request);
        }
         return redirect('/')->with('error', 'Access denied. You do not have the required permission.');
    }
    
}
