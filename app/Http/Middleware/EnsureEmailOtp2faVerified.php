<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailOtp2faVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        if ($user->two_factor_enabled) {

            // allow 2fa routes + logout
            if ($request->routeIs('2fa.*') || $request->routeIs('logout')) {
                return $next($request);
            }

            // ✅ Laravel 12: no session()->boolean()
            $passed = (bool) $request->session()->get('2fa_passed', false);

            if (!$passed) {
                return redirect()->route('2fa.challenge');
            }
        }

        return $next($request);
    }
}