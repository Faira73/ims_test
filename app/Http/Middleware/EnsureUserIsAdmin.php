<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $employee = Auth::user();
            
            // If user is not an admin, redirect them away
            if (!$employee->is_admin) {
                return redirect()
                ->route('dashboard')
                ->with('error', 'Unauthorized access. Admin privileges required.');
            }
        }
        
        return $next($request);
    }
}