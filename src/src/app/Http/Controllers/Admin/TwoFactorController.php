<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TwoFactorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TwoFactorController extends Controller
{
    protected TwoFactorService $twoFactorService;

    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Display two-factor authentication page
     */
    public function index()
    {
        $setTitle = 'Two Factor Authentication';
        $admin = Auth::guard('admin')->user();

        $secret = null;
        $qrCode = null;
        $recoveryCodes = null;

        if (!$admin->two_factor_secret) {
            if (session()->has('temp_2fa_secret')) {
                $secret = session('temp_2fa_secret');
            } else {
                $secret = $this->twoFactorService->generateSecretKey();
                session(['temp_2fa_secret' => $secret]);
            }

            $qrCode = $this->twoFactorService->generateQRCodeUrl(config('app.name'), $admin->email, $secret);
        } else {
            if ($admin->two_factor_recovery_codes) {
                $recoveryCodes = json_decode(decrypt($admin->two_factor_recovery_codes), true);
            }
        }

        return view('admin.two_factor', compact('setTitle', 'secret', 'qrCode', 'recoveryCodes'));
    }

    /**
     * Display two factor verification page
     */
    public function showVerify()
    {
        $setTitle = 'Two Factor Verification';
        return view('admin.two_factor_verify', compact('setTitle'));
    }


    public function verify(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $admin = Auth::guard('admin')->user();

        if (!$admin->hasTwoFactorEnabled()) {
            return redirect()->route('admin.dashboard');
        }

        $secret = decrypt($admin->two_factor_secret);
        $isValid = $this->twoFactorService->verifyCode($secret, $request->code);

        if (!$isValid) {
            return back()->with('notify', [['error', 'Invalid verification code. Please try again.']]);
        }

        // Mark 2FA as verified for this session
        session(['two_factor_verified' => true]);

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Verify recovery code
     */
    public function recovery(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'recovery_code' => 'required|string',
        ]);

        $admin = Auth::guard('admin')->user();

        if (!$admin->hasTwoFactorEnabled() || !$admin->two_factor_recovery_codes) {
            return redirect()->route('admin.dashboard');
        }

        $recoveryCodes = json_decode(decrypt($admin->two_factor_recovery_codes), true);
        $recoveryCode = strtoupper(str_replace('-', '', $request->recovery_code));

        // Check if recovery code exists
        $codeIndex = array_search($recoveryCode, array_map(function($code) {
            return strtoupper(str_replace('-', '', $code));
        }, $recoveryCodes));

        if ($codeIndex === false) {
            return back()->with('notify', [['error', 'Invalid recovery code.']]);
        }

        // Remove used recovery code
        unset($recoveryCodes[$codeIndex]);
        $recoveryCodes = array_values($recoveryCodes);
        $admin->update([
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes))
        ]);

        session(['two_factor_verified' => true]);
        return redirect()->intended(route('admin.dashboard'))
            ->with('notify', [['warning', 'Recovery code used. You have ' . count($recoveryCodes) . ' recovery codes remaining.']]);
    }

    /**
     * Enable Two-Factor Authentication
     */
    public function enable(Request $request)
    {
        $request->validate([
            'secret' => 'required|string',
            'code' => 'required|string|size:6',
        ]);

        $admin = Auth::guard('admin')->user();

        if ($admin->two_factor_secret) {
            return back()->with('notify', [['error', 'Two-factor authentication is already enabled.']]);
        }

        $isValid = $this->twoFactorService->verifyCode($request->secret, $request->code);

        if (!$isValid) {
            return back()->with('notify', [['error', 'Invalid verification code. Please try again.']]);
        }

        $recoveryCodes = $this->twoFactorService->generateRecoveryCodes();

        $admin->update([
            'two_factor_secret' => encrypt($request->secret),
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
            'two_factor_confirmed_at' => now(),
        ]);

        session()->forget('temp_2fa_secret');

        return back()->with('notify', [['success', 'Two-factor authentication enabled successfully!']]);
    }


    public function disable(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->password, $admin->password)) {
            return back()->with('notify', [['error', 'Invalid password.']]);
        }

        $admin->update([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);

        session()->forget('two_factor_verified');
        return back()->with('notify', [['success', 'Two-factor authentication disabled successfully!']]);
    }
}
