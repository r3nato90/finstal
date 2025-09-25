<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorAdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin || !$admin->hasTwoFactorEnabled()) {
            return $next($request);
        }

        if (!session('two_factor_verified')) {
            return redirect()->route('admin.two-factor.verify');
        }

        return $next($request);
    }
}
