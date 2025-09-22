<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        if ($user->hasTwoFactorEnabled() && !session('2fa_verified')) {
            if ($request->routeIs('auth.2fa*') || $request->routeIs('logout')) {
                return $next($request);
            }

            return redirect()->route('auth.2fa.verify');
        }

        return $next($request);
    }
}
