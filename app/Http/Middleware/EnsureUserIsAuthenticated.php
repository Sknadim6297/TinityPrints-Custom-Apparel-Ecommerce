<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // Store the intended URL in the session
            if (!$request->expectsJson()) {
                return redirect()->guest(route('login'))->with('redirect_back', true);
            }

            // For AJAX requests, return JSON response with redirect URL
            return response()->json([
                'error' => 'Unauthenticated',
                'redirect_url' => route('login'),
                'message' => 'Please login to continue.',
            ], 401);
        }

        return $next($request);
    }
}
