<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\User\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredRequest;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\EmailSmsTemplateService;
use App\Services\EmailVerificationService;
use App\Services\LoginHistoryService;
use App\Services\Payment\WalletService;
use App\Services\ReferralService;
use App\Services\SettingService;
use App\Services\UserService;
use App\Utilities\Api\ApiJsonResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticateController extends Controller
{
    public function __construct(
        protected WalletService $walletService,
        protected UserService $userService,
        protected LoginHistoryService $loginHistoryService,
        protected ReferralService $referralService,
    ) {
    }

    /**
     * Register a new user with enhanced validation and security
     *
     * @param RegisteredRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(RegisteredRequest $request): JsonResponse
    {
        if (!SettingService::isRegistrationEnabled()) {
            return ApiJsonResponse::error('Registration is currently disabled.', statusCode: 403);
        }

        $sanitizedInput = array_map(function($value) {
            return is_string($value) ? strip_tags(trim($value)) : $value;
        }, $request->all());

        try {
            DB::beginTransaction();

            $email = strtolower(trim($sanitizedInput['email']));
            $name = trim($sanitizedInput['name']);
            $referralId = $this->referralService->handleRegistration($request->input('referral_id'));

            $user = User::create([
                'uuid' => Str::uuid(),
                'first_name' => $name,
                'email' => $email,
                'referral_by' => $referralId,
                'password' => Hash::make($sanitizedInput['password']),
                'status' => Status::ACTIVE->value,
                'email_verified_at' => now(),
            ]);

            Log::info('API User registered', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            $this->walletService->save($this->walletService->prepParams((int) $user->id));
            DB::commit();
            $token = $user->createToken($user->first_name . $user->email . '-AuthToken')->plainTextToken;
            return ApiJsonResponse::success('Registration successful', [
                'access_token' => $token,
                'user' => [
                    'id' => $user->uuid,
                    'name' => $user->first_name,
                    'email' => $user->email,
                ]
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('API Registration error', [
                'email' => $email ?? 'unknown',
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return ApiJsonResponse::error('An error occurred during registration. Please try again.', statusCode: 500);
        }
    }

    /**
     * Authenticate user with enhanced security
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $request->merge(array_map(function($value) {
            return is_string($value) ? strip_tags(trim($value)) : $value;
        }, $request->all()));

        $this->ensureIsNotRateLimited($request);

        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        $email = strtolower(trim($request->input('email')));
        $password = $request->input('password');

        try {
            $user = User::where('email', $email)->first();
            $genericError = 'The provided credentials are incorrect.';

            if (!$user) {
                RateLimiter::hit($this->throttleKey($request));
                $this->loginHistoryService->logAttempt($email, false, $request);

                Log::warning('API Login attempt with non-existent email', [
                    'email' => $email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);

                return ApiJsonResponse::error($genericError, statusCode: 401);
            }

            if ($user->status != Status::ACTIVE->value) {
                Log::warning('API Login attempt on inactive account', [
                    'user_id' => $user->id,
                    'email' => $email,
                    'ip' => $request->ip()
                ]);

                $this->loginHistoryService->logAttempt($email, false, $request);
                return ApiJsonResponse::error('Your account has been deactivated. Please contact support.', statusCode: 403);
            }

            if (!Hash::check($password, $user->password)) {
                RateLimiter::hit($this->throttleKey($request));

                Log::warning('API Failed password attempt', [
                    'user_id' => $user->id,
                    'email' => $email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);

                $this->loginHistoryService->logAttempt($email, false, $request);
                return ApiJsonResponse::error($genericError, statusCode: 401);
            }

            if ($this->isAccountLocked($user)) {
                Log::warning('API Login attempt on locked account', [
                    'user_id' => $user->id,
                    'email' => $email,
                    'ip' => $request->ip()
                ]);

                $this->loginHistoryService->logAttempt($email, false, $request);
                return ApiJsonResponse::error('Account temporarily locked due to suspicious activity. Please try again later.', statusCode: 423);
            }

            if (EmailVerificationService::isVerificationRequired() && !$user->email_verified_at) {
                return ApiJsonResponse::error('Please verify your email address before logging in.', statusCode: 403);
            }

            $token = $user->createToken($user->first_name . $user->email . '-AuthToken')->plainTextToken;
            $this->performSuccessfulLogin($user, $request, $email);

            return ApiJsonResponse::success('Login successful', [
                'access_token' => $token,
                'user' => [
                    'id' => $user->uuid,
                    'name' => $user->first_name,
                    'email' => $user->email,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('API Login error', [
                'email' => $email,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return ApiJsonResponse::error('An error occurred during login. Please try again.', statusCode: 500);
        }
    }

    /**
     * Logout user and revoke tokens
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = auth()->user();

        if ($user) {
            Log::info('API User logged out', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip()
            ]);

            // Revoke all tokens
            $user->tokens()->delete();
        }

        return ApiJsonResponse::success('Logged out successfully');
    }

    /**
     * Handle forgot password with enhanced security
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        // Rate limiting
        $key = 'password-reset-api:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return ApiJsonResponse::error('Too many password reset attempts. Please try again in ' . ceil($seconds / 60) . ' minutes.', statusCode: 429);
        }

        $request->validate([
            'email' => 'required|email:rfc|max:255'
        ]);

        $email = strtolower(trim($request->input('email')));
        $successMessage = 'If an account with that email exists, we have sent a password reset code.';

        try {
            $user = User::where('email', $email)->first();

            if (!$user) {
                RateLimiter::hit($key);

                Log::warning('API Password reset attempt for non-existent email', [
                    'email' => $email,
                    'ip' => $request->ip()
                ]);

                return ApiJsonResponse::success($successMessage);
            }

            if ($user->status === Status::BANNED->value) {
                RateLimiter::hit($key);

                Log::warning('API Password reset attempt for banned account', [
                    'user_id' => $user->id,
                    'email' => $email,
                    'ip' => $request->ip()
                ]);

                return ApiJsonResponse::success($successMessage);
            }

            // Check for recent reset requests
            $existingReset = PasswordReset::where('email', $email)
                ->where('created_at', '>', now()->subMinutes(5))
                ->first();

            if ($existingReset) {
                return ApiJsonResponse::success($successMessage);
            }

            $token = sprintf('%06d', mt_rand(100000, 999999));
            PasswordReset::updateOrCreate(
                ['email' => $email],
                [
                    'token' => $token,
                    'created_at' => now()
                ]
            );

            EmailSmsTemplateService::sendTemplateEmail(EmailSmsTemplateName::PASSWORD_RESET_CODE_API->value, $user, [
                'user_name' => e($user->fullname),
                'token' => $token,
            ]);

            Log::info('API Password reset requested', [
                'user_id' => $user->id,
                'email' => $email,
                'ip' => $request->ip()
            ]);

            RateLimiter::hit($key);
            return ApiJsonResponse::success('Reset password request successful');

        } catch (\Exception $e) {
            Log::error('API Password reset error', [
                'email' => $email,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return ApiJsonResponse::success($successMessage);
        }
    }

    /**
     * Reset password with enhanced security
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|max:255|confirmed',
            'token' => 'required|string',
        ]);

        $email = strtolower(trim($request->input('email')));
        $token = $request->input('token');
        $password = $request->input('password');

        try {
            DB::beginTransaction();

            $passwordReset = PasswordReset::where('email', $email)->where('token', $token)->first();

            if (!$passwordReset) {
                Log::warning('API Invalid password reset token used', [
                    'email' => $email,
                    'ip' => $request->ip()
                ]);

                return ApiJsonResponse::error('Invalid or expired reset token.', statusCode: 400);
            }

            if (Carbon::parse($passwordReset->created_at)->addHour()->isPast()) {
                $passwordReset->delete();
                return ApiJsonResponse::error('Reset token has expired.', statusCode: 400);
            }

            $user = User::where('email', $email)->first();
            if (!$user) {
                return ApiJsonResponse::error('User not found.', statusCode: 404);
            }

            if (Hash::check($password, $user->password)) {
                return ApiJsonResponse::error('Please choose a different password.', statusCode: 400);
            }

            $user->update([
                'password' => Hash::make($password),
                'password_changed_at' => now(),
            ]);

            // Clean up
            $passwordReset->delete();

            Log::info('API Password reset completed', [
                'user_id' => $user->id,
                'email' => $email,
                'ip' => $request->ip()
            ]);

            DB::commit();
            return ApiJsonResponse::success('Password reset successfully. Please login with your new password.');

        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('API Password reset error', [
                'email' => $email,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return ApiJsonResponse::error('An error occurred while resetting password. Please try again.', statusCode: 500);
        }
    }

    /**
     * Ensure request is not rate limited
     *
     * @param Request $request
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

        Log::warning('API Rate limit exceeded for login', [
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
     * Get throttle key for rate limiting
     *
     * @param Request $request
     * @return string
     */
    protected function throttleKey(Request $request): string
    {
        $email = strtolower($request->input('email', ''));
        return "api_login_attempts:{$email}:{$request->ip()}";
    }

    /**
     * Perform successful login operations
     *
     * @param User $user
     * @param Request $request
     * @param string $email
     */
    protected function performSuccessfulLogin(User $user, Request $request, string $email): void
    {
        $user->update([
            'last_login_at' => now(),
        ]);


        $this->loginHistoryService->logAttempt($email, true, $request, $user->id);
        RateLimiter::clear($this->throttleKey($request));

        Log::info('API Successful login', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
    }

    /**
     * Check if account is locked
     *
     * @param User $user
     * @return bool
     */
    protected function isAccountLocked(User $user): bool
    {
        $lockKey = "account_locked:{$user->id}";
        return Cache::has($lockKey);
    }
}
