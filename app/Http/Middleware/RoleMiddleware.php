<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if the user is authenticated and has one of the specified roles
        // If not, return a 403 Forbidden response
        Log::info('User role: ' . Auth::user()->role);
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            abort(403);
        }
        return $next($request);
    }
}
