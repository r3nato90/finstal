<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailSmsTemplateService;
use App\Services\EmailVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class EmailVerificationController extends Controller
{

    public function verify(Request $request)
    {
        $user = User::findOrFail($request->route('id'));
        if (!hash_equals(sha1($user->email), $request->route('hash'))) {
            abort(403, 'Invalid verification link.');
        }

        if ($user->email_verified_at) {
            return redirect()->route('login')
                ->with('notify', [['success', 'Email already verified.']]);
        }

        EmailVerificationService::markEmailAsVerified($user);
        EmailSmsTemplateService::sendTemplateEmail('welcome', $user, [
            'user_name' => e($user->name),
        ]);

        return redirect()->route('login')
            ->with('notify', [['success', 'Email verified successfully! You can now log in.']]);
    }

    public function resend(Request $request): \Illuminate\Http\RedirectResponse
    {
        $key = 'email-verification:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('notify', [['error', "Too many attempts. Please try again in {$seconds} seconds."]]);
        }

        $request->validate([
            'email' => 'required|email|max:255'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            RateLimiter::hit($key, 300);
            return back()->with('notify', [['success', 'If the email exists, a verification link has been sent.']]);
        }

        if ($user->email_verified_at) {
            RateLimiter::hit($key, 300);
            return back()->with('notify', [['success', 'If the email exists, a verification link has been sent.']]);
        }

        EmailVerificationService::sendVerificationEmail($user);
        RateLimiter::hit($key, 300);

        return back()->with('notify', [['success', 'If the email exists, a verification link has been sent.']]);
    }
}
