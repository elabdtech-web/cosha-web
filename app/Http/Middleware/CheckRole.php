<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->hasRole($role)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            // Return a JSON response for API requests
            return response()->json(['message' => 'Unauthenticated.'], 401);
        } else {
            // Redirect to index for web requests
            return redirect()->route('index');
        }
    }
}
