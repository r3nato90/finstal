<?php

namespace App\Http\Controllers\User;

use App\Actions\InvestmentHandler;
use App\Enums\Ico\PurchaseStatus;
use App\Enums\Referral\ReferralCommissionType;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Models\IcoPurchase;
use App\Services\Ico\TokenService;
use App\Services\UserService;
use App\Services\Payment\WalletService;
use App\Services\Payment\TransactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class IcoController extends Controller
{
    public function __construct(
        protected TokenService $tokenService,
        protected WalletService $walletService,
        protected TransactionService $transactionService,
        protected UserService $userService,
    ) {}

    /**
     * Display ICO dashboard with active token and purchase history
     */
    public function index(): View | RedirectResponse
    {
        try {
            $userId = Auth::id();
            $activeTokens = $this->tokenService->getActiveTokens();
            $purchases = IcoPurchase::with('icoToken')
                ->where('user_id', $userId)
                ->latest()
                ->paginate(getPaginate(10));

            $statistics = [
                'total_invested' => getAmount(IcoPurchase::where('user_id', $userId)
                    ->where('status', PurchaseStatus::COMPLETED->value)
                    ->sum('amount_usd')),
                'total_tokens_purchased' => shortAmount(IcoPurchase::where('user_id', $userId)
                    ->where('status', PurchaseStatus::COMPLETED->value)
                    ->sum('tokens_purchased')),
                'successful_purchases' => IcoPurchase::where('user_id', $userId)
                    ->where('status', PurchaseStatus::COMPLETED->value)
                    ->count(),
                'pending_purchases' => IcoPurchase::where('user_id', $userId)
                    ->where('status', PurchaseStatus::PENDING->value)
                    ->count(),
            ];

            $setTitle = 'Ico Tokens';
            return view('user.ico.index', compact(
                'activeTokens',
                'purchases',
                'statistics',
                'setTitle'
            ));

        } catch (\Exception $e) {
            Log::error('ICO Index Error: ' . $e->getMessage(), [
                'user_id' => Auth::id()
            ]);

            return back()('notify', [['error', 'Unable to load ICO data. Please try again.']]);
        }
    }

    /**
     * Process ICO token purchase
     */
    public function purchase(Request $request): RedirectResponse
    {
        $request->validate([
            'ico_token_id' => 'required|exists:tokens,id',
            'amount_usd' => 'required|numeric|min:0.01|max:999999',
        ]);

        $userId = Auth::id();
        $user = $this->userService->findById($userId);
        if (!$user) {
            abort(404);
        }

        try {
            DB::beginTransaction();
            $icoToken = $this->tokenService->findById($request->input('ico_token_id'));
            if (!$icoToken) {
                return back()->with('notify', [['error', 'ICO token not found.']]);
            }

            if (!$this->tokenService->isTokenSaleActive($icoToken)) {
                return back()->with('notify', [['error', 'This ICO token sale is not currently active.']]);
            }

            $amountUsd = getAmount($request->input('amount_usd'));
            $tokenPrice = getAmount($icoToken->current_price);

            if ($tokenPrice <= 0) {
                return back()->with('notify', [['error', 'Invalid token price.']]);
            }

            $tokensToPurchase = floor($amountUsd / $tokenPrice);
            if ($tokensToPurchase <= 0) {
                return back()->with('notify', [['error', 'Amount too small to purchase any tokens.']]);
            }

            $tokensRemaining = $this->tokenService->calculateRemainingTokens($icoToken);
            if ($tokensToPurchase > $tokensRemaining) {
                return back()->with('notify', [['error', 'Not enough tokens remaining in this ICO.']]);
            }

            $wallet = $user->wallet;
            $account = $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet);
            $actualAmountUsd = getAmount($tokensToPurchase * $tokenPrice);

            if ($actualAmountUsd > Arr::get($account, 'balance')) {
                return back()->with('notify', [['warning', 'Your primary account balance is insufficient for this investment.']]);
            }

            $this->tokenService->updateTokensSold($icoToken, $tokensToPurchase);
            $wallet->primary_balance -= $actualAmountUsd;
            $wallet->save();

            $this->transactionService->save($this->transactionService->prepParams([
                'user_id' => $userId,
                'amount' => $actualAmountUsd,
                'type' => Type::MINUS,
                'trx' => getTrx(),
                'details' => 'ICO token purchase: ' . $icoToken->name . ' (' . $icoToken->symbol . ')',
                'wallet' => $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
                'source' => Source::ICO->value
            ]));

            $purchase = IcoPurchase::create([
                'user_id' => $userId,
                'ico_token_id' => $icoToken->id,
                'purchase_id' => 'ICO-' . date('Ymd') . '-' . strtoupper(getTrx(8)),
                'amount_usd' => $actualAmountUsd,
                'tokens_purchased' => $tokensToPurchase,
                'token_price' => $tokenPrice,
                'status' => PurchaseStatus::COMPLETED->value,
                'purchased_at' => now(),
                'metadata' => json_encode([
                    'user_ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ])
            ]);

            // Process referral commission
            InvestmentHandler::processReferralCommission(
                $user,
                $purchase->amount_usd,
                ReferralCommissionType::ICO_TOKEN,
                $purchase->purchase_id
            );

            DB::commit();
            return back()->with('notify', [['success',
                'Successfully purchased ' . shortAmount($tokensToPurchase) . ' ' . $icoToken->symbol . ' tokens for ' . getCurrencySymbol() . shortAmount($actualAmountUsd)
            ]]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('ICO Purchase Error: ' . $e->getMessage(), [
                'user_id' => $userId,
                'request_data' => $request->only(['ico_token_id', 'amount_usd'])
            ]);

            return back()->with('notify', [['error', 'An error occurred while processing your purchase.']]);
        }
    }

    /**
     * Display purchase history
     */
    public function history(Request $request): View
    {
        try {
            $userId = Auth::id();

            // Validate filters
            $request->validate([
                'search' => 'nullable|string|max:100',
                'token' => 'nullable|integer|exists:ico_tokens,id',
                'status' => 'nullable|in:pending,completed,failed,cancelled',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);

            $query = IcoPurchase::with('icoToken')
                ->where('user_id', $userId)
                ->latest();

            // Apply filters
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('purchase_id', 'like', '%' . $search . '%')
                        ->orWhereHas('icoToken', function ($tokenQuery) use ($search) {
                            $tokenQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('symbol', 'like', '%' . $search . '%');
                        });
                });
            }

            if ($request->filled('token')) {
                $query->where('ico_token_id', $request->token);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('start_date')) {
                $query->whereDate('created_at', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->whereDate('created_at', '<=', $request->end_date);
            }

            $purchases = $query->paginate(getPaginate(15));

            // Get available tokens for filter using service
            $tokens = $this->tokenService->getToken()
                ->filter(function ($token) use ($userId) {
                    return IcoPurchase::where('user_id', $userId)
                        ->where('ico_token_id', $token->id)
                        ->exists();
                });

            // Statistics using helper functions
            $stats = [
                'total_purchases' => IcoPurchase::where('user_id', $userId)->count(),
                'total_invested' => getAmount(IcoPurchase::where('user_id', $userId)
                    ->where('status', PurchaseStatus::COMPLETED->value)
                    ->sum('amount_usd')),
                'total_tokens' => shortAmount(IcoPurchase::where('user_id', $userId)
                    ->where('status', PurchaseStatus::COMPLETED->value)
                    ->sum('tokens_purchased')),
                'unique_tokens' => IcoPurchase::where('user_id', $userId)
                    ->distinct('ico_token_id')
                    ->count('ico_token_id'),
            ];

            $setTitle = 'Ico Purchase History';

            return view('user.ico.history', compact(
                'purchases',
                'tokens',
                'stats',
                'setTitle'
            ));

        } catch (\Exception $e) {
            Log::error('ICO History Error: ' . $e->getMessage(), [
                'user_id' => Auth::id()
            ]);

            return view('user.ico.history', [
                'purchases' => collect(),
                'tokens' => collect(),
                'stats' => [
                    'total_purchases' => 0,
                    'total_invested' => 0,
                    'total_tokens' => 0,
                    'unique_tokens' => 0,
                ]
            ])->with('notify', [['error', 'Unable to load purchase history.']]);
        }
    }
}
