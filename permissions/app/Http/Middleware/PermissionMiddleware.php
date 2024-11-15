<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Models\Permission;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {           
        $user = Auth::user();
        $route = Route::currentRouteName();
        $permission = Permission::where('route', $route)->first();
        if ($permission) {
            if (!$user->hasPermission($permission->id)) {
                return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
            }
        }
        return $next($request);
    }
}
