<?php

namespace App\Http\Controllers\Api\User;

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
use App\Utilities\Api\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
    public function index(Request $request): JsonResponse
    {
        try {
            $userId = Auth::id();
            $activeTokens = $this->tokenService->getActiveTokens()->map(function ($token) {
                return [
                    'id' => $token->id,
                    'name' => $token->name,
                    'symbol' => $token->symbol,
                    'price' => (float) $token->price,
                    'current_price' => (float) ($token->current_price ?? $token->price),
                    'total_supply' => (float) $token->total_supply,
                    'tokens_sold' => (float) $token->tokens_sold,
                    'tokens_remaining' => (float) ($token->total_supply - $token->tokens_sold),
                    'sale_start' => $token->sale_start,
                    'sale_end' => $token->sale_end,
                    'is_active' => $token->is_active,
                    'description' => $token->description,
                    'image_url' => $token->image_url,
                ];
            });

            $perPage = min($request->get('per_page', 10), 50);
            $purchases = IcoPurchase::with('icoToken')
                ->where('user_id', $userId)
                ->latest()
                ->paginate($perPage);

            $purchases->getCollection()->transform(function ($purchase) {
                return [
                    'id' => $purchase->id,
                    'purchase_id' => $purchase->purchase_id,
                    'amount_usd' => (float) $purchase->amount_usd,
                    'tokens_purchased' => (float) $purchase->tokens_purchased,
                    'token_price' => (float) $purchase->token_price,
                    'status' => $purchase->status,
                    'purchased_at' => $purchase->purchased_at ? $purchase->purchased_at->toISOString() : null,
                    'created_at' => $purchase->created_at->toISOString(),
                    'token' => $purchase->icoToken ? [
                        'id' => $purchase->icoToken->id,
                        'name' => $purchase->icoToken->name,
                        'symbol' => $purchase->icoToken->symbol,
                        'current_price' => (float) ($purchase->icoToken->current_price ?? $purchase->icoToken->price),
                    ] : null,
                ];
            });

            $statistics = [
                'total_invested' => (float) IcoPurchase::where('user_id', $userId)
                    ->where('status', PurchaseStatus::COMPLETED->value)
                    ->sum('amount_usd'),
                'total_tokens_purchased' => (float) IcoPurchase::where('user_id', $userId)
                    ->where('status', PurchaseStatus::COMPLETED->value)
                    ->sum('tokens_purchased'),
                'successful_purchases' => IcoPurchase::where('user_id', $userId)
                    ->where('status', PurchaseStatus::COMPLETED->value)
                    ->count(),
                'pending_purchases' => IcoPurchase::where('user_id', $userId)
                    ->where('status', PurchaseStatus::PENDING->value)
                    ->count(),
            ];

            return ApiJsonResponse::success('ICO data fetched successfully', [
                'active_tokens' => $activeTokens,
                'purchases' => $purchases->items(),
                'purchases_meta' => [
                    'current_page' => $purchases->currentPage(),
                    'last_page' => $purchases->lastPage(),
                    'per_page' => $purchases->perPage(),
                    'total' => $purchases->total(),
                    'from' => $purchases->firstItem(),
                    'to' => $purchases->lastItem(),
                ],
                'statistics' => $statistics,
            ]);

        } catch (\Exception $e) {
            Log::error('API ICO Index Error: ' . $e->getMessage(), [
                'user_id' => Auth::id()
            ]);

            return ApiJsonResponse::error('Unable to load ICO data. Please try again.');
        }
    }

    /**
     * Process ICO token purchase
     */
    public function purchase(Request $request): JsonResponse
    {
        $request->validate([
            'ico_token_id' => 'required|exists:tokens,id',
            'amount_usd' => 'required|numeric|min:0.01|max:999999',
        ]);

        $userId = Auth::id();
        $user = $this->userService->findById($userId);
        if (!$user) {
            return ApiJsonResponse::error('User not found.', [], 404);
        }

        try {
            DB::beginTransaction();
            $icoToken = $this->tokenService->findById($request->input('ico_token_id'));
            if (!$icoToken) {
                return ApiJsonResponse::error('ICO token not found.');
            }

            if (!$this->tokenService->isTokenSaleActive($icoToken)) {
                return ApiJsonResponse::error('This ICO token sale is not currently active.');
            }

            $amountUsd = getAmount($request->input('amount_usd'));
            $tokenPrice = getAmount($icoToken->current_price);

            if ($tokenPrice <= 0) {
                return ApiJsonResponse::error('Invalid token price.');
            }

            $tokensToPurchase = floor($amountUsd / $tokenPrice);
            if ($tokensToPurchase <= 0) {
                return ApiJsonResponse::error('Amount too small to purchase any tokens.');
            }

            $tokensRemaining = $this->tokenService->calculateRemainingTokens($icoToken);
            if ($tokensToPurchase > $tokensRemaining) {
                return ApiJsonResponse::error('Not enough tokens remaining in this ICO.');
            }

            $wallet = $user->wallet;
            $account = $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet);
            $actualAmountUsd = getAmount($tokensToPurchase * $tokenPrice);

            if ($actualAmountUsd > Arr::get($account, 'balance')) {
                return ApiJsonResponse::error('Your primary account balance is insufficient for this investment.');
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

            $icoToken->increment('tokens_sold', $tokensToPurchase);

            // Process referral commission
            InvestmentHandler::processReferralCommission(
                $user,
                $purchase->amount_usd,
                ReferralCommissionType::ICO_TOKEN,
                $purchase->purchase_id
            );

            DB::commit();

            return ApiJsonResponse::success(
                'Successfully purchased ' . shortAmount($tokensToPurchase) . ' ' . $icoToken->symbol . ' tokens for ' . getCurrencySymbol() . shortAmount($actualAmountUsd),
                [
                    'purchase' => [
                        'id' => $purchase->id,
                        'purchase_id' => $purchase->purchase_id,
                        'amount_usd' => (float) $purchase->amount_usd,
                        'tokens_purchased' => (float) $purchase->tokens_purchased,
                        'token_price' => (float) $purchase->token_price,
                        'status' => $purchase->status,
                        'purchased_at' => $purchase->purchased_at->toISOString(),
                    ],
                    'token' => [
                        'id' => $icoToken->id,
                        'name' => $icoToken->name,
                        'symbol' => $icoToken->symbol,
                        'current_price' => (float) $icoToken->current_price,
                    ]
                ]
            );

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('API ICO Purchase Error: ' . $e->getMessage(), [
                'user_id' => $userId,
                'request_data' => $request->only(['ico_token_id', 'amount_usd'])
            ]);

            return ApiJsonResponse::error('An error occurred while processing your purchase.');
        }
    }

    /**
     * Display purchase history
     */
    public function history(Request $request): JsonResponse
    {
        try {
            $userId = Auth::id();

            $request->validate([
                'search' => 'nullable|string|max:100',
                'token' => 'nullable|integer|exists:ico_tokens,id',
                'status' => 'nullable|in:pending,completed,failed,cancelled',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'per_page' => 'nullable|integer|min:1|max:100'
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

            $perPage = min($request->get('per_page', 15), 100);
            $purchases = $query->paginate($perPage);

            $purchases->getCollection()->transform(function ($purchase) {
                return [
                    'id' => $purchase->id,
                    'purchase_id' => $purchase->purchase_id,
                    'amount_usd' => (float) $purchase->amount_usd,
                    'tokens_purchased' => (float) $purchase->tokens_purchased,
                    'token_price' => (float) $purchase->token_price,
                    'status' => $purchase->status,
                    'purchased_at' => $purchase->purchased_at ? $purchase->purchased_at->toISOString() : null,
                    'created_at' => $purchase->created_at->toISOString(),
                    'token' => $purchase->icoToken ? [
                        'id' => $purchase->icoToken->id,
                        'name' => $purchase->icoToken->name,
                        'symbol' => $purchase->icoToken->symbol,
                        'current_price' => (float) ($purchase->icoToken->current_price ?? $purchase->icoToken->price),
                    ] : null,
                ];
            });

            // Get available tokens for filter
            $tokens = $this->tokenService->getToken()
                ->filter(function ($token) use ($userId) {
                    return IcoPurchase::where('user_id', $userId)
                        ->where('ico_token_id', $token->id)
                        ->exists();
                })
                ->map(function ($token) {
                    return [
                        'id' => $token->id,
                        'name' => $token->name,
                        'symbol' => $token->symbol,
                    ];
                })
                ->values();

            $stats = [
                'total_purchases' => IcoPurchase::where('user_id', $userId)->count(),
                'total_invested' => (float) IcoPurchase::where('user_id', $userId)
                    ->where('status', PurchaseStatus::COMPLETED->value)
                    ->sum('amount_usd'),
                'total_tokens' => (float) IcoPurchase::where('user_id', $userId)
                    ->where('status', PurchaseStatus::COMPLETED->value)
                    ->sum('tokens_purchased'),
                'unique_tokens' => IcoPurchase::where('user_id', $userId)
                    ->distinct('ico_token_id')
                    ->count('ico_token_id'),
            ];

            return ApiJsonResponse::success('Purchase history fetched successfully', [
                'purchases' => $purchases->items(),
                'purchases_meta' => [
                    'current_page' => $purchases->currentPage(),
                    'last_page' => $purchases->lastPage(),
                    'per_page' => $purchases->perPage(),
                    'total' => $purchases->total(),
                    'from' => $purchases->firstItem(),
                    'to' => $purchases->lastItem(),
                ],
                'filters' => $request->only(['search', 'token', 'status', 'start_date', 'end_date']),
                'tokens' => $tokens,
                'statuses' => ['pending', 'completed', 'failed', 'cancelled'],
                'stats' => $stats,
            ]);

        } catch (\Exception $e) {
            Log::error('API ICO History Error: ' . $e->getMessage(), [
                'user_id' => Auth::id()
            ]);

            return ApiJsonResponse::error('Unable to load purchase history.');
        }
    }
}

