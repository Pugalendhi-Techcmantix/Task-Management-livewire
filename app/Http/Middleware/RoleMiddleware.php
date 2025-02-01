<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    //     public function handle(Request $request, Closure $next): Response
    //     {
    //         // return $next($request);
    //         // if (Auth::check() && Auth::user()->role_id == $role) {
    //         //     return $next($request);
    //         // }
    // // dd(Auth::user());
    //         if(Auth::user()->role_id == 1)
    //         {
    //             return $next($request);
    //         }else{
    //             return redirect()->route('dashboard');
    //         }

    //         // Redirect or abort if the role does not match
    //         // return abort(403, 'Unauthorized action.');
    //     }

    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (Auth::check()) {
            $userRole = Auth::user()->role_id;

            // If user is an admin (role_id == 1), block access to user routes
            if ($userRole == 1) {
                // If trying to access user-specific routes, redirect to dashboard
                if ($this->isUserRoute($request)) {
                    return redirect()->route('dashboard');
                }
            }
            // If user is not an admin (role_id != 1), block access to admin routes
            elseif ($userRole != 1) {
                // If trying to access admin-specific routes, redirect to dashboard
                if ($this->isAdminRoute($request)) {
                    return redirect()->route('dashboard');
                }
            }
        }

        return $next($request);
    }

    /**
     * Check if the route is a user route.
     */
    private function isUserRoute(Request $request): bool
    {
        // Define routes that are user-specific (can be extended)
        $userRoutes = [
            'pending',
            'progress',
            'hold',
            'completed',
            'sample',
            'support-page'
        ];

        return in_array($request->route()->getName(), $userRoutes);
    }

    /**
     * Check if the route is an admin route.
     */
    private function isAdminRoute(Request $request): bool
    {
        // Define routes that are admin-specific (can be extended)
        $adminRoutes = [
            'employee-list',
            'role-list',
            'task-list',
            'support-list'
        ];

        return in_array($request->route()->getName(), $adminRoutes);
    }
}
