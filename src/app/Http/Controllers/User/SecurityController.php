<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Services\TwoFactorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SecurityController extends Controller
{
    protected $twoFactorService;

    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Display login history page
     */
    public function loginHistory()
    {
        $setTitle = 'Login History';
        $user = Auth::user();

        // Get login history with pagination
        $loginHistory = LoginAttempt::where('email', $user->email)
            ->orderBy('attempted_at', 'desc')
            ->paginate(15);

        // Calculate stats
        $stats = [
            'total_attempts' => LoginAttempt::where('email', $user->email)->count(),
            'successful_logins' => LoginAttempt::where('email', $user->email)->where('successful', 1)->count(),
            'failed_attempts' => LoginAttempt::where('email', $user->email)->where('successful', 0)->count(),
            'unique_ips' => LoginAttempt::where('email', $user->email)->distinct('ip_address')->count(),
            'last_login' => LoginAttempt::where('email', $user->email)
                ->where('successful', true)
                ->latest('attempted_at')
                ->value('attempted_at'),
        ];

        return view('user.security.login_history', compact('setTitle', 'loginHistory', 'stats'));
    }

    /**
     * Display two factor authentication page
     */
    public function twoFactor()
    {
        $setTitle = 'Two Factor Authentication';
        $user = Auth::user();

        $secret = null;
        $qrCode = null;
        $recoveryCodes = null;

        if (!$user->two_factor_secret) {
            if (session()->has('temp_2fa_secret')) {
                $secret = session('temp_2fa_secret');
            } else {
                $secret = $this->twoFactorService->generateSecretKey();
                session(['temp_2fa_secret' => $secret]);
            }

            $qrCode = $this->twoFactorService->generateQRCodeUrl(config('app.name'), $user->email, $secret);
            \Log::info('QR Code generated', [
                'secret' => $secret,
                'qr_url' => $qrCode
            ]);
        } else {
            if ($user->two_factor_recovery_codes) {
                $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
            }
        }

        return view('user.security.two_factor', compact('setTitle', 'secret', 'qrCode', 'recoveryCodes'));
    }

    /**
     * Enable Two Factor Authentication
     */
    public function enableTwoFactor(Request $request)
    {
        $request->validate([
            'secret' => 'required|string',
            'code' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        if ($user->two_factor_secret) {
            return back()->with('notify', [['error', 'Two-factor authentication is already enabled.']]);
        }

        \Log::info('2FA Enable attempt', [
            'secret' => $request->secret,
            'code' => $request->code,
            'user_id' => $user->id
        ]);

        try {
            $isValid = $this->twoFactorService->verifyCode($request->secret, $request->code);
            \Log::info('2FA verification result', ['is_valid' => $isValid]);

            if (!$isValid) {
                return back()->with('notify', [['error', 'Invalid verification code. Please check your authenticator app and try again.']]);
            }
        } catch (\Exception $e) {
            \Log::error('2FA verification error: ' . $e->getMessage());
            return back()->with('notify', [['error', 'Error verifying code: ' . $e->getMessage()]]);
        }

        $recoveryCodes = $this->twoFactorService->generateRecoveryCodes();

        $user->update([
            'two_factor_secret' => encrypt($request->secret),
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
            'two_factor_confirmed_at' => now(),
        ]);

        session()->forget('temp_2fa_secret');
        \Log::info('2FA enabled successfully for user: ' . $user->id);

        return back()->with('notify', [['success', 'Two-factor authentication enabled successfully! Please save your recovery codes.']]);
    }

    /**
     * Disable Two Factor Authentication
     */
    public function disableTwoFactor(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('notify', [['error', 'Invalid password.']]);
        }

        $user->update([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);

        return back()->with('notify', [['success', 'Two-factor authentication disabled successfully!']]);
    }

    /**
     * Display change password page
     */
    public function changePassword()
    {
        $setTitle = 'Change Password';
        return view('user.security.change_password', compact('setTitle'));
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('notify', [['error', 'Current password is incorrect.']]);
        }

        if (Hash::check($request->password, $user->password)) {
            return back()->with('notify', [['warning', 'New password must be different from current password.']]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('notify', [['success', 'Password updated successfully!']]);
    }

    /**
     * Generate secret key for 2FA
     */
    private function generateSecret()
    {
        return strtoupper(str_replace('=', '', base32_encode(random_bytes(20))));
    }

    /**
     * Generate QR code URL
     */
    private function generateQRCode($email, $secret)
    {
        $appName = config('app.name');
        $qrUrl = "otpauth://totp/{$appName}:{$email}?secret={$secret}&issuer={$appName}";
        return "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qrUrl);
    }

    /**
     * Verify 2FA code
     */
    private function verifyCode($secret, $code)
    {
        $timeSlice = floor(time() / 30);

        for ($i = -1; $i <= 1; $i++) {
            $calculatedCode = $this->generateCode($secret, $timeSlice + $i);
            if ($calculatedCode === $code) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate TOTP code
     */
    private function generateCode($secret, $timeSlice)
    {
        $key = base32_decode($secret);
        $time = pack('N*', 0) . pack('N*', $timeSlice);
        $hash = hash_hmac('sha1', $time, $key, true);
        $offset = ord($hash[19]) & 0xf;
        $code = (
                ((ord($hash[$offset + 0]) & 0x7f) << 24) |
                ((ord($hash[$offset + 1]) & 0xff) << 16) |
                ((ord($hash[$offset + 2]) & 0xff) << 8) |
                (ord($hash[$offset + 3]) & 0xff)
            ) % 1000000;

        return str_pad($code, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Generate recovery codes
     */
    private function generateRecoveryCodes()
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8));
        }
        return $codes;
    }
}
