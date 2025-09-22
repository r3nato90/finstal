<?php

namespace App\Http\Controllers\Api\User;

use App\Concerns\UploadedFile;
use App\Enums\Investment\Status;
use App\Enums\Trade\TradeStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WalletResource;
use App\Models\Deposit;
use App\Models\InvestmentLog;
use App\Models\LoginAttempt;
use App\Models\StakingInvestment;
use App\Models\TradeLog;
use App\Models\WithdrawLog;
use App\Services\Investment\CommissionService;
use App\Services\Investment\InvestmentService;
use App\Services\Payment\DepositService;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WithdrawService;
use App\Utilities\Api\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class HomeController extends Controller
{
    use UploadedFile;

    public function __construct(
        protected TransactionService $transactionService,
        protected CommissionService $commissionService,
        protected DepositService $depositService,
        protected InvestmentService $investmentService,
        protected WithdrawService $withdrawService,
    )
    {

    }

    public function userInfo(): JsonResponse
    {
        return ApiJsonResponse::success('User data fetched successfully', [
            'users' => new UserResource(Auth::user()),
            'wallet' => new WalletResource(Auth::user()->wallet),
        ]);
    }


    public function index(): JsonResponse
    {
        $user = Auth::user();
        $userId = $user->id;
        $commissions = $this->commissionService->getCommissionsSum($userId);
        $statistics =  $this->investmentService->getInvestmentReport($userId);
        $deposit = $this->depositService->getReport($userId);
        $withdraw = $this->withdrawService->getApiReport($userId);

        return ApiJsonResponse::success('Dashboard API fetched successfully', [
            'user' => new UserResource($user),
            'finance' => [
                'total_invest' => InvestmentLog::where('user_id', $userId)
                    ->whereNotIn('status', [Status::CANCELLED])
                    ->sum('amount'),
                'total_matrix_commissions' => Arr::get($commissions, 'referral', 0) + Arr::get($commissions, 'level', 0),
                'total_trading' => TradeLog::where('user_id', $userId)
                    ->where('status', TradeStatus::COMPLETE)
                    ->sum('amount'),
                'total_deposit' => Deposit::where('user_id', $userId)->where('status', \App\Enums\Payment\Deposit\Status::SUCCESS)
                    ->sum('final_amount'),
                'total_withdraw' => WithdrawLog::where('user_id', $userId)->where('status', \App\Enums\Payment\Withdraw\Status::SUCCESS)
                    ->sum('final_amount'),
                'total_staking_investment' => StakingInvestment::sum('amount'),
            ],
            'capital_growth' => [
                'investment' => [
                    "total_invest" => shortAmount($statistics->total),
                    "total_profit" => shortAmount($statistics->profit),
                    "running_invest" => shortAmount($statistics->running),
                ],
                'trade' => [
                    "total_trade" => TradeLog::where('user_id', $userId)->count(),
                    "total_volume" => round(TradeLog::where('user_id', $userId)->sum('amount'), 2),
                    "total_profit" => round(TradeLog::where('user_id', $userId)->sum('profit_loss')),
                ],
                'commission' => $commissions,
                'wallet' => new WalletResource($user->wallet),
            ],
            'cash_flow_statistics' => [
                'deposit' => $deposit,
                'withdraw' => $withdraw,
            ],
            'monthly_statistics' => $this->depositService->monthlyReport($userId),
            'transactions' => TransactionResource::collection($this->transactionService->latestTransactions(userId: $userId)),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function transactions(): JsonResponse
    {
        $userId = Auth::id();
        $transactions = $this->transactionService->getTransactions(userId: $userId);

        return ApiJsonResponse::success('Transactions fetched', [
            'transactions' => TransactionResource::collection($transactions),
            'transactions_meta' => paginateMeta($transactions),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function profileUpdate(ProfileUpdateRequest $request): JsonResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $user = Auth::user();
        $user->image = $request->hasFile('image') ? $this->move($request->file('image'), getFilePath()) : $user->image;
        $user->save();

        return ApiJsonResponse::success("Profile has been updated");
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function passwordUpdate(Request $request): JsonResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return ApiJsonResponse::success("Password has been updated");
    }



    /**
     * Display login history API
     */
    public function loginHistory(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            $perPage = min($request->get('per_page', 15), 100);
            $loginHistory = LoginAttempt::where('email', $user->email)
                ->orderBy('attempted_at', 'desc')
                ->paginate($perPage);

            $loginHistory->getCollection()->transform(function ($attempt) {
                return [
                    'id' => $attempt->id,
                    'ip_address' => $attempt->ip_address,
                    'user_agent' => $attempt->user_agent,
                    'device' => $attempt->device ?? 'Unknown',
                    'location' => $attempt->location ?? 'Unknown',
                    'successful' => (bool) $attempt->successful,
                    'status' => $attempt->successful ? 'Successful' : 'Failed',
                    'attempted_at' => $attempt->attempted_at ?
                        \Carbon\Carbon::parse($attempt->attempted_at)->toISOString() : null,
                    'time_ago' => $attempt->attempted_at ?
                        \Carbon\Carbon::parse($attempt->attempted_at)->diffForHumans() : null,
                ];
            });

            // Calculate stats
            $stats = [
                'total_attempts' => LoginAttempt::where('email', $user->email)->count(),
                'successful_logins' => LoginAttempt::where('email', $user->email)->where('successful', 1)->count(),
                'failed_attempts' => LoginAttempt::where('email', $user->email)->where('successful', 0)->count(),
                'unique_ips' => LoginAttempt::where('email', $user->email)->distinct('ip_address')->count(),
                'last_login' => $this->getLastLogin($user->email),
            ];

            return ApiJsonResponse::success('Login history fetched successfully', [
                'login_history' => $loginHistory->items(),
                'login_history_meta' => paginateMeta($loginHistory),
                'stats' => $stats,
            ]);

        } catch (\Exception $e) {
            Log::error('API Login History Error: ' . $e->getMessage(), [
                'user_id' => Auth::id()
            ]);

            return ApiJsonResponse::error('Unable to load login history. Please try again.');
        }
    }

    /**
     * Get last successful login
     */
    private function getLastLogin($email): ?array
    {
        $lastLogin = LoginAttempt::where('email', $email)
            ->where('successful', 1)
            ->latest('attempted_at')
            ->first();

        if (!$lastLogin) {
            return null;
        }

        return [
            'attempted_at' => \Carbon\Carbon::parse($lastLogin->attempted_at)->toISOString(),
            'time_ago' => \Carbon\Carbon::parse($lastLogin->attempted_at)->diffForHumans(),
            'ip_address' => $lastLogin->ip_address,
            'location' => $lastLogin->location ?? 'Unknown',
        ];
    }
}


