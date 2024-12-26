<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        // Loop through guards and check if the user is authenticated
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect authenticated users to the defined home route
                return redirect(RouteServiceProvider::HOME);
            }
        }

        // If the user is not authenticated, allow the request to continue
        return $next($request);
    }
}
