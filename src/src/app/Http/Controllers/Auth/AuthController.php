<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\User\Status;
use App\Http\Controllers\Controller;
use App\Models\EmailSmsTemplate;
use App\Models\Setting;
use App\Models\User;
use App\Services\EmailSmsTemplateService;
use App\Services\EmailVerificationService;
use App\Services\LoginHistoryService;
use App\Services\Payment\WalletService;
use App\Services\ReferralService;
use App\Services\SettingService;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AuthController extends Controller
{
    public function __construct(
        protected readonly LoginHistoryService $loginHistoryService,
        protected readonly ReferralService $referralService,
        protected readonly WalletService $walletService,
    ){

    }

    /**
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function showLogin(): View
    {
        $setTitle = 'Login';
        return view('auth.login', [
            'referralCode' => request()->get('ref'),
            'setTitle' => $setTitle,
        ]);
    }

    /**
     * Show registration form
     * @return View|RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function showRegister(): View | RedirectResponse
    {
        $setTitle = 'Register';
        if (!SettingService::isRegistrationEnabled()) {
            return redirect()->route('login')
                ->with('notify', [['error', 'Registration is currently disabled.']]);
        }

        return view('auth.register', [
            'referralCode' => request()->get('ref'),
            'setTitle' => $setTitle,
        ]);
    }

    /**
     * Show forgot password form
     * @return View
     */
    public function showForgotPassword(): View
    {
        $setTitle = 'Forgot Password';
        return view('auth.forgot-password', compact('setTitle'));
    }

    /**
     * Show reset password form
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function showResetPassword(Request $request): View|RedirectResponse
    {
        $setTitle = 'Reset Password';
        $token = $request->get('token');
        $email = $request->get('email');

        if (!$token || !$email) {
            return redirect()->route('login')
                ->with('notify', [['error', 'Invalid password reset link.']]);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
            'setTitle' => $setTitle,
        ]);
    }

    /**
     * Handle login authentication with enhanced security
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function login(Request $request): RedirectResponse
    {
        $request->merge(array_map(function($value) {
            return is_string($value) ? strip_tags(trim($value)) : $value;
        }, $request->all()));

        $this->ensureIsNotRateLimited($request);
        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|max:255',
            'remember' => 'boolean'
        ]);

        $credentials['email'] = strtolower(trim($credentials['email']));

        try {
            $user = User::where('email', $credentials['email'])->first();
            $genericError = 'The provided credentials are incorrect.';

            if (!$user) {
                RateLimiter::hit($this->throttleKey($request));
                $this->loginHistoryService->logAttempt($credentials['email'], false, $request);
                Log::warning('Login attempt with non-existent email', [
                    'email' => $credentials['email'],
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);

                return back()->with('notify', [['error', $genericError]]);
            }

            if ($user->status != Status::ACTIVE->value) {
                Log::warning('Login attempt on inactive account', [
                    'user_id' => $user->id,
                    'email' => $credentials['email'],
                    'ip' => $request->ip()
                ]);

                $this->loginHistoryService->logAttempt($credentials['email'], false, $request);
                return back()->with('notify', [['error', 'Your account has been deactivated. Please contact support']]);
            }

            if (!Hash::check($credentials['password'], $user->password)) {
                RateLimiter::hit($this->throttleKey($request));
                Log::warning('Failed password attempt', [
                    'user_id' => $user->id,
                    'email' => $credentials['email'],
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);

                $this->loginHistoryService->logAttempt($credentials['email'], false, $request);
                return back()->with('notify', [['error', $genericError]]);
            }


            if ($this->isAccountLocked($user)) {
                Log::warning('Login attempt on locked account', [
                    'user_id' => $user->id,
                    'email' => $credentials['email'],
                    'ip' => $request->ip()
                ]);

                $this->loginHistoryService->logAttempt($credentials['email'], false, $request);
                return back()->with('notify', [['error', 'Account temporarily locked due to suspicious activity. Please try again later or contact support.']]);
            }

            $this->performSuccessfulLogin($user, $request, $credentials);
            return redirect('/users/dashboard');

        } catch (\Exception $e) {
            Log::error('Login error', [
                'email' => $credentials['email'],
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return back()->with('notify', [['error', 'An error occurred during login. Please try again.']]);
        }
    }

    /**
     * Handle user registration with enhanced validation
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function register(Request $request): RedirectResponse
    {
        $request->merge(array_map(function($value) {
            return is_string($value) ? strip_tags(trim($value)) : $value;
        }, $request->all()));

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                "min:8",
                'max:255',
                'confirmed',
            ],
        ]);

        try {
            DB::beginTransaction();
            $validated['email'] = strtolower(trim($validated['email']));
            $validated['name'] = trim($validated['name']);

            $referrerId = $this->referralService->handleRegistration($request->input('ref'));
            $user = User::create([
                'first_name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'status' => Status::PENDING->value,
                'email_verified_at' => EmailVerificationService::isVerificationRequired() ? null : now(),
                'referral_by' => $referrerId,
            ]);

            Log::info('User registered', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            $this->walletService->save($this->walletService->prepParams($user->id));

            if (EmailVerificationService::isVerificationRequired()) {
                EmailVerificationService::sendVerificationEmail($user);
                DB::commit();

                return redirect()->route('login')
                    ->with('notify', [['success', 'Registration successful! Please check your email and verify your account before logging in.']]);
            } else {
                $user->update([
                    'status' => Status::ACTIVE->value,
                    'email_verified_at' => now()
                ]);
            }

            DB::commit();
            Auth::login($user);
            return redirect('/users/dashboard');

        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration error', [
                'email' => $validated['email'] ?? 'unknown',
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return back()->with('notify', [['error', 'An error occurred during registration. Please try again.']]);
        }
    }

    /**
     * Handle forgot password with enhanced security
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function forgotPassword(Request $request): RedirectResponse
    {
        $key = 'password-reset:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('notify', [['error', 'Too many password reset attempts. Please try again in ' . ceil($seconds / 60) . ' minutes.']]);
        }

        $request->validate([
            'email' => 'required|email:rfc|max:255',
        ]);

        $email = strtolower(trim($request->email));
        try {
            $user = User::where('email', $email)->first();
            $successMessage = 'If an account with that email exists, we have sent a password reset link.';

            if (!$user) {
                RateLimiter::hit($key);

                Log::warning('Password reset attempt for non-existent email', [
                    'email' => $email,
                    'ip' => $request->ip()
                ]);

                return back()->with('notify', [['success', $successMessage]]);
            }

            if ($user->status === Status::BANNED->value) {
                RateLimiter::hit($key);

                Log::warning('Password reset attempt for inactive account', [
                    'user_id' => $user->id,
                    'email' => $email,
                    'ip' => $request->ip()
                ]);

                return back()->with('notify', [['success', $successMessage]]);
            }

            $existingToken = DB::table('password_resets')
                ->where('email', $email)
                ->where('created_at', '>', now()->subMinutes(5))
                ->first();

            if ($existingToken) {
                return back()->with('notify', [['success', $successMessage]]);
            }

            $token = Str::random(64);
            DB::table('password_resets')->updateOrInsert(
                ['email' => $email],
                [
                    'token' => Hash::make($token),
                    'created_at' => now()
                ]
            );

            $resetUrl = route('password.reset') . '?' . http_build_query([
                'token' => $token,
                'email' => $email
            ]);

            EmailSmsTemplateService::sendTemplateEmail(EmailSmsTemplateName::PASSWORD_RESET_CODE->value, $user, [
                'user_name' => e($user->fullname),
                'reset_link' => $resetUrl,
            ]);

            Log::info('Password reset requested', [
                'user_id' => $user->id,
                'email' => $email,
                'ip' => $request->ip()
            ]);

            RateLimiter::hit($key);
            return back()->with('notify', [['success', $successMessage]]);

        } catch (\Exception $e) {
            Log::error('Password reset error', [
                'email' => $email,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return back()->with('notify', [['success', $successMessage]]);
        }
    }

    /**
     * Handle password reset with enhanced security
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => [
                'required',
                'string',
                "min:6",
                'max:255',
                'confirmed',
            ],
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
        ]);

        $email = strtolower(trim($validated['email']));

        try {
            DB::beginTransaction();
            $passwordReset = DB::table('password_resets')
                ->where('email', $email)
                ->first();

            if (!$passwordReset || !Hash::check($validated['token'], $passwordReset->token)) {
                Log::warning('Invalid password reset token used', [
                    'email' => $email,
                    'ip' => $request->ip()
                ]);

                return back()->with('notify', [['error', 'Invalid or expired password reset token.']]);
            }

            if (Carbon::parse($passwordReset->created_at)->addHour()->isPast()) {
                DB::table('password_resets')->where('email', $email)->delete();

                return back()->with('notify', [['error', 'Password reset token has expired.']]);
            }

            $user = User::where('email', $email)->first();
            if (!$user) {
                return back()->with('notify', [['error', 'User not found.']]);
            }

            if (Hash::check($validated['password'], $user->password)) {
                return back()->with('notify', [['error', 'Please choose a different password.']]);
            }

            $user->update([
                'password' => Hash::make($validated['password']),
                'remember_token' => Str::random(60),
                'password_changed_at' => now(),
            ]);

            DB::table('password_resets')->where('email', $email)->delete();
            Log::info('Password reset completed', [
                'user_id' => $user->id,
                'email' => $email,
                'ip' => $request->ip()
            ]);

            DB::commit();
            return redirect()->route('login')
                ->with('notify', [['success', 'Your password has been reset successfully. Please log in with your new password.']]);

        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Password reset error', [
                'email' => $email,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return back()->with('notify', [['error', 'An error occurred while resetting your password. Please try again.']]);
        }
    }

    /**
     * Handle user logout with enhanced security
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            Log::info('User logged out', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip()
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget(['2fa_verified', 'login_attempts', 'last_activity']);

        return redirect()->route('login')
            ->with('notify', [['success', 'You have been logged out successfully.']]);
    }


    /**
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    protected function ensureIsNotRateLimited(Request $request): void
    {
        $key = $this->throttleKey($request);
        $maxAttempts = 5;

        if (!RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);
        $minutes = ceil($seconds / 60);

        Log::warning('Rate limit exceeded for login', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'attempts' => RateLimiter::attempts($key),
            'max_attempts' => $maxAttempts
        ]);

        throw ValidationException::withMessages([
            'email' => [
                "Too many login attempts. Please try again in {$minutes} minute" . ($minutes > 1 ? 's' : '') . '.'
            ],
        ]);
    }

    /**
     * Get the throttle key for rate limiting
     * @param Request $request
     * @return string
     */
    protected function throttleKey(Request $request): string
    {
        $email = strtolower($request->input('email', ''));
        return "login_attempts:{$email}:{$request->ip()}";
    }

    /**
     * Perform successful login operations
     *
     * @param User $user
     * @param Request $request
     * @param array $credentials
     */
    protected function performSuccessfulLogin(User $user, Request $request, array $credentials): void
    {
        Auth::login($user, $credentials['remember'] ?? false);
        $request->session()->regenerate();
        $request->session()->put('last_activity', time());
        $request->session()->put('user_ip', $request->ip());
        $request->session()->put('user_agent_hash', hash('sha256', $request->userAgent() ?? ''));

        $user->update([
            'last_login_at' => now(),
        ]);

        $this->loginHistoryService->logAttempt($credentials['email'], true, $request);
        RateLimiter::clear($this->throttleKey($request));

        Log::info('Successful login', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
    }

    /**
     * Check if account is locked due to suspicious activity
     * @param User $user
     * @return bool
     */
    protected function isAccountLocked(User $user): bool
    {
        $lockKey = "account_locked:{$user->id}";
        return Cache::has($lockKey);
    }
}
