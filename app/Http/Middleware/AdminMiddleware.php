<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->hasAnyRole(['super_admin', 'manager', 'receptionist', 'housekeeping'])) {
            // Regular guests cannot access admin panel
            return redirect()->route('welcome')
                ->with('error', 'You do not have permission to access the admin panel.');
        }

        return $next($request);
    }
}