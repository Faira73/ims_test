<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {  
        if (Auth::check()){

            
            $employee = Auth::user();
            if($employee->status === "PENDING" && !$request->routeIs('requestPending')){
                return redirect()->route('requestPending');
            }
            if (!$employee->status === "PENDING" && $request->routeIs('requestPending')) {
                return redirect()->route('dashboard');
            }
        }
        return $next($request);
    }
}
