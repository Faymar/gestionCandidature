<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMidlleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role == 'admin') {
                return $next($request);
            } else {
                return response()->json("vous n'avez pas les autorisation pour cette action");
            }
        } else {
            return response()->json("vous n'etes pas connecte");
        }
        return $next($request);
    }
}
