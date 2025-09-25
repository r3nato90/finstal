<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Services\TwoFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;

class TwoFactorController extends Controller
{
    protected TwoFactorService $twoFactorService;

    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    public function show(): View|RedirectResponse
    {
        $user = Auth::user();

        if (!$user || !$user->hasTwoFactorEnabled()) {
            return redirect()->intended($this->getRedirectUrl($user));
        }

        $setTitle = 'Two Factor Authentication';
        return view('auth.two_factor_challenge', compact('setTitle'));
    }


    public function verify(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $key = '2fa-verify:' . $user->id . ':' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->logFailedAttempt($request, $user, 'Rate limit exceeded');
            return back()->with('notify', [['error', "Too many attempts. Please try again in {$seconds} seconds."]]);
        }

        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        if (!$user || !$user->hasTwoFactorEnabled()) {
            RateLimiter::hit($key, 300);
            $this->logFailedAttempt($request, $user, '2FA not enabled');
            return redirect()->intended($this->getRedirectUrl($user));
        }

        $code = preg_replace('/[^a-zA-Z0-9]/', '', $request->code);
        if (empty($code)) {
            RateLimiter::hit($key, 300);
            $this->logFailedAttempt($request, $user, 'Empty code');
            return back()->with('notify', [['error', 'The provided two-factor authentication code was invalid.']]);
        }

        if (strlen($code) > 6 && $this->verifyRecoveryCode($user, $code)) {
            session(['2fa_verified' => true]);
            RateLimiter::clear($key);
            $this->logSuccessfulAttempt($request, $user, 'recovery_code');


            return redirect()->intended($this->getRedirectUrl($user))
                ->with('notify', [['success', 'Logged in using recovery code.']]);
        }

        if ($this->verifyTotpCode($user, $code)) {
            session(['2fa_verified' => true]);
            RateLimiter::clear($key);
            $this->logSuccessfulAttempt($request, $user, 'totp_code');

            return redirect()->intended($this->getRedirectUrl($user))
                ->with('notify', [['success', 'Two-factor authentication verified.']]);
        }

        RateLimiter::hit($key, 300);
        $this->logFailedAttempt($request, $user, 'Invalid code');

        return back()->with('notify', [['error', 'The provided two-factor authentication code was invalid.']]);
    }


    private function getRedirectUrl($user): string
    {
        if (!$user) {
            return route('login');
        }

        if (method_exists($user, 'hasRole')) {
            if ($user->hasRole('admin')) {
                return route('admin.dashboard');
            }
        }

        if (isset($user->role) && $user->role === 'admin') {
            return route('admin.dashboard');
        }

        return route('user.dashboard');
    }


    private function verifyTotpCode($user, $code): bool
    {
        if (strlen($code) !== 6 || !ctype_digit($code)) {
            return false;
        }

        try {
            $secret = decrypt($user->two_factor_secret);
            return $this->twoFactorService->verifyCode($secret, $code);
        } catch (\Exception $e) {
            Log::error('Two-factor secret decryption failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }


    private function verifyRecoveryCode($user, $code): bool
    {
        if (!$user->two_factor_recovery_codes) {
            return false;
        }

        try {
            $recoveryCodes = is_string($user->two_factor_recovery_codes)
                ? json_decode(decrypt($user->two_factor_recovery_codes), true)
                : $user->two_factor_recovery_codes;

            if (!$recoveryCodes || !is_array($recoveryCodes)) {
                return false;
            }

            foreach ($recoveryCodes as $index => $recoveryCode) {
                if (strlen($recoveryCode) > 20 && Hash::check($code, $recoveryCode)) {
                    array_splice($recoveryCodes, $index, 1);
                    $user->update(['two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes))]);
                    return true;
                }

                $cleanRecoveryCode = str_replace('-', '', strtoupper($recoveryCode));
                $cleanInputCode = str_replace('-', '', strtoupper($code));

                if ($cleanRecoveryCode === $cleanInputCode) {
                    array_splice($recoveryCodes, $index, 1);
                    $user->update(['two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes))]);
                    return true;
                }
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Recovery code verification failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }


    private function logSuccessfulAttempt(Request $request, $user, string $method): void
    {
        $agent = new Agent();

        LoginAttempt::create([
            'email' => $user->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'successful' => true,
            'reason' => "2FA verified using {$method}",
            'location' => $this->getLocationFromIP($request->ip()),
            'device_type' => $agent->device(),
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'attempted_at' => now(),
            'user_id' => $user->id,
        ]);

        Log::info('2FA verification successful', [
            'user_id' => $user->id,
            'email' => $user->email,
            'method' => $method,
            'ip' => $request->ip(),
        ]);
    }


    private function logFailedAttempt(Request $request, $user, string $reason): void
    {
        $agent = new Agent();

        LoginAttempt::create([
            'email' => $user ? $user->email : 'unknown',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'successful' => false,
            'reason' => "2FA failed: {$reason}",
            'location' => $this->getLocationFromIP($request->ip()),
            'device_type' => $agent->device(),
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'attempted_at' => now(),
            'user_id' => $user ? $user->id : null,
        ]);

        Log::warning('2FA verification failed', [
            'user_id' => $user ? $user->id : null,
            'email' => $user ? $user->email : 'unknown',
            'reason' => $reason,
            'ip' => $request->ip(),
        ]);
    }


    private function getLocationFromIP(string $ip): ?string
    {
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return 'Localhost';
        }

        return null;
    }
}
