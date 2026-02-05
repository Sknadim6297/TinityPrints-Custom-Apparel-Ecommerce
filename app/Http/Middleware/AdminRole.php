<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $admin = auth()->guard('admin')->user();

        if (!$admin) {
            abort(403, 'Unauthorized access');
        }

        // Super admin has access to everything
        if ($admin->isSuperAdmin()) {
            return $next($request);
        }

        // Check if admin has the required role
        foreach ($roles as $role) {
            if ($admin->role === $role) {
                return $next($request);
            }
        }

        abort(403, 'You do not have permission to access this resource');
    }
}
