<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.guest')->except('logout');
    }
    /**
     * @return View
     */
    public function login(): View
    {
        $setTitle = "Admin Login";
        return view('admin.auth.login', compact('setTitle'));
    }


    /**
     * Handle admin login attempt
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $key = 'admin-login.' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');
        $admin = \App\Models\Admin::where('email', $credentials['email'])->first();

        if (!$admin) {
            RateLimiter::hit($key, 60);
            return $this->failedLoginResponse();
        }

        // Verify password
        if (!Hash::check($credentials['password'], $admin->password)) {
            RateLimiter::hit($key, 60);
            return $this->failedLoginResponse();
        }


        Auth::guard('admin')->login($admin, $remember);
        RateLimiter::clear($key);

        $request->session()->regenerate();
        if ($admin->hasTwoFactorEnabled()) {
            session()->forget('two_factor_verified');
            return redirect()->route('admin.two-factor.verify');
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();
        Auth::guard('admin')->logout();
        session()->forget(['two_factor_verified', 'temp_2fa_secret']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($admin) {
            $this->logLogout($request, $admin);
        }

        return redirect()->route('admin.login');
    }


    /**
     * Log admin logout
     */
    private function logLogout(Request $request, $admin): void
    {
        Log::info('Admin logout', [
            'admin_id' => $admin->id,
            'email' => $admin->email,
            'ip' => $request->ip(),
        ]);
    }

    /**
     * Return failed login response
     */
    private function failedLoginResponse(): RedirectResponse
    {
        return back()
            ->withInput()
            ->with('notify', [['error', 'These credentials do not match our records.']]);
    }
}
