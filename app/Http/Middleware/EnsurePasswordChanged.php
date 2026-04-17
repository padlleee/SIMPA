<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordChanged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow password change routes to process without redirect
        if ($request->routeIs('password.change', 'password.update')) {
            return $next($request);
        }

        // Check if authenticated user has force_password_change flag set
        if (auth()->check() && auth()->user()->force_password_change) {
            return redirect()->route('password.change')
                ->with('warning', 'Anda harus mengubah password sebelum melanjutkan.');
        }

        return $next($request);
    }
}
