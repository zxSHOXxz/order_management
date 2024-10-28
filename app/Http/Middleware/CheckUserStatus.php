<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status !== 'فعال') {
            // Check if the current route is 'login' or 'register'
            $currentRoute = $request->route()->getName();
            if (in_array($currentRoute, ['login', 'register'])) {
                return response()->json([
                    'redirect' => route('user.inactive')
                ]);
            }

            return redirect()->route('user.inactive');
        }

        return $next($request);
    }
}
