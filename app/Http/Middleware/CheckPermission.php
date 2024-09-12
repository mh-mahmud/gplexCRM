<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

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
    public function handle_rokib($request, Closure $next, $permission)
    {
        // chk if the user is authenticated and has the required permission
        if (Auth::check() && Auth::user()->hasPermission($permission)) {
            return $next($request);
        }
         return redirect('/')->with('error', 'Access denied. You do not have the required permission.');
    }
    
    
    public function handle(Request $request, Closure $next): Response
    {
        // Assuming you have a user model with a 'hasPermission' method
        $user = Auth::user();
        if($user) {

            if($user->user_type=='admin' && $user->status==1) {
                return $next($request);
            }

            // Check if the user is authenticated and has the required permission
            $permission = request()->route()->getName();
            if (!$user || !$user->hasPermission($permission)) {
                // Optionally redirect or abort with a 403 Forbidden response
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        return $next($request);
    }
}
