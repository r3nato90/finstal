<?php

namespace App\Http\Controllers\User;

use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Models\TradeLog;
use App\Models\TradeSetting;
use App\Models\CryptoCurrency;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TradeController extends Controller
{

    public function market(Request $request)
    {
        $currencies = CryptoCurrency::orderBy('name')
            ->paginate(10)
            ->through(function ($currency) {
                return [
                    'id' => $currency->id,
                    'symbol' => $currency->symbol,
                    'name' => $currency->name,
                    'type' => $currency->type,
                    'current_price' => (float) $currency->current_price,
                    'previous_price' => (float) $currency->previous_price,
                    'change_percent' => $currency->change_percent ? (float) $currency->change_percent : null,
                    'image_url' => $currency->image_url,
                    'last_updated' => $currency->last_updated,
                ];
            });

        return view('user.trades.market', [
            'setTitle' => 'Market Data',
            'currencies' => $currencies
        ]);
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $wallet = $user->wallet;
        $userBalance = $wallet ? $wallet->trade_balance : 0;

        $availableSymbols = TradeSetting::with('currency')
            ->where('is_active', true)
            ->select(['id', 'currency_id', 'symbol', 'min_amount', 'max_amount', 'payout_rate', 'durations', 'trading_hours'])
            ->get()
            ->map(function ($setting) {
                $durations = is_string($setting->durations)
                    ? json_decode($setting->durations, true)
                    : $setting->durations;

                $tradingHours = is_string($setting->trading_hours)
                    ? json_decode($setting->trading_hours, true)
                    : $setting->trading_hours;

                return [
                    'id' => $setting->id,
                    'symbol' => $setting->symbol,
                    'min_amount' => (float) $setting->min_amount,
                    'max_amount' => (float) $setting->max_amount,
                    'payout_rate' => (float) $setting->payout_rate,
                    'durations' => $durations ?: [60, 120, 300, 600, 1800, 3600],
                    'currency' => $setting->currency ? [
                        'id' => $setting->currency->id,
                        'name' => $setting->currency->name,
                        'symbol' => $setting->currency->symbol,
                        'tradingview_symbol' => $setting->currency->tradingview_symbol,
                    ] : null,
                    'trading_hours' => $tradingHours ?: [
                        'monday' => ['start' => '09:00', 'end' => '17:00', 'enabled' => true],
                        'tuesday' => ['start' => '09:00', 'end' => '17:00', 'enabled' => true],
                        'wednesday' => ['start' => '09:00', 'end' => '17:00', 'enabled' => true],
                        'thursday' => ['start' => '09:00', 'end' => '17:00', 'enabled' => true],
                        'friday' => ['start' => '09:00', 'end' => '17:00', 'enabled' => true],
                        'saturday' => ['start' => '09:00', 'end' => '17:00', 'enabled' => false],
                        'sunday' => ['start' => '09:00', 'end' => '17:00', 'enabled' => false],
                    ]
                ];
            });

        $activeTrades = TradeLog::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->get()
            ->map(function ($trade) {
                return [
                    'id' => $trade->id,
                    'symbol' => e($trade->symbol),
                    'direction' => e($trade->direction),
                    'amount' => (float) $trade->amount,
                    'duration_seconds' => $trade->duration_seconds,
                    'open_price' => (float) $trade->open_price,
                    'open_time' => $trade->open_time->toISOString(),
                    'expiry_time' => $trade->expiry_time->toISOString(),
                    'status' => e($trade->status),
                    'payout_rate' => (float) $trade->payout_rate,
                    'duration_formatted' => $this->formatDuration($trade->duration_seconds),
                    'time_remaining' => $this->getTimeRemaining($trade),
                ];
            });

        $recentTrades = TradeLog::where('user_id', $user->id)
            ->whereIn('status', ['won', 'lost', 'draw', 'expired', 'cancelled'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($trade) {
                return [
                    'id' => $trade->id,
                    'symbol' => e($trade->symbol),
                    'direction' => e($trade->direction),
                    'amount' => (float) $trade->amount,
                    'open_time' => $trade->open_time->toISOString(),
                    'close_time' => $trade->close_time ? $trade->close_time->toISOString() : null,
                    'status' => e($trade->status),
                    'profit_loss' => (float) ($trade->profit_loss ?? 0),
                    'formatted_profit_loss' => $this->formatProfitLoss($trade->profit_loss ?? 0),
                    'win_status' => $this->getWinStatus($trade->status),
                ];
            });

        $statistics = $this->getUserTradeStats($user->id);

        // Return Blade view
        return view('user.trades.index', [
            'setTitle' => 'Trading',
            'availableSymbols' => $availableSymbols,
            'activeTrades' => $activeTrades,
            'recentTrades' => $recentTrades,
            'userBalance' => $userBalance,
            'statistics' => $statistics,
            'serverTimezone' => config('app.timezone'),
            'serverTime' => now()->toISOString(),
        ]);
    }


    public function history(Request $request)
    {
        $user = auth()->user();
        $wallet = $user->mainWallet;
        $userBalance = $wallet ? $wallet->balance : 0;

        $request->validate([
            'search' => 'nullable|string|max:255',
            'symbol' => 'nullable|string|max:20',
            'direction' => 'nullable|in:up,down',
            'status' => 'nullable|in:active,won,lost,cancelled,expired',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'per_page' => 'nullable|integer|min:1|max:100'
        ]);

        $query = TradeLog::where('user_id', $user->id)->latest();

        if ($request->filled('search')) {
            $search = strip_tags($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('trade_id', 'like', "%{$search}%")
                    ->orWhere('symbol', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if ($request->filled('symbol')) {
            $query->where('symbol', strip_tags($request->symbol));
        }

        if ($request->filled('direction')) {
            $query->where('direction', $request->direction);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('open_time', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('open_time', '<=', $request->end_date);
        }

        $perPage = min($request->get('per_page', 10), 100);
        $trades = $query->paginate($perPage);
        $trades->getCollection()->transform(function ($trade) {
            $trade->duration_formatted = $this->formatDuration($trade->duration_seconds);
            $trade->time_remaining = $this->getTimeRemaining($trade);
            $trade->formatted_profit_loss = $this->formatProfitLoss($trade->profit_loss);
            return $trade;
        });

        $symbols = TradeLog::where('user_id', $user->id)
            ->select('symbol')
            ->distinct()
            ->pluck('symbol')
            ->sort()
            ->values();

        $stats = $this->getUserTradeStats($user->id);

        // Return Blade view
        return view('user.trades.history', [
            'setTitle' => 'Trade History',
            'trades' => $trades,
            'filters' => $request->only(['search', 'symbol', 'direction', 'status', 'start_date', 'end_date']),
            'symbols' => $symbols,
            'directions' => ['up', 'down'],
            'statuses' => ['active', 'won', 'lost', 'cancelled', 'expired'],
            'stats' => $stats,
            'userBalance' => $userBalance
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $key = 'create-trade:' . $user->id;
        if (RateLimiter::tooManyAttempts($key, 10)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('notify', [['warning', "Too many trade attempts. Please try again in {$seconds} seconds."]]);
        }

        $request->validate([
            'symbol' => 'required|exists:crypto_currencies,symbol',
            'direction' => 'required|in:up,down',
            'amount' => 'required|numeric|min:0.01|max:999999.99',
            'duration' => 'required|integer|min:1|max:86400'
        ]);

        $currency = CryptoCurrency::where('symbol', strtoupper($request->input('symbol')))->first();
        if(!$currency) {
            return back()->with('notify', [['error', 'Currency not found.']]);
        }

        $setting = TradeSetting::where('currency_id', $currency->id)
            ->where('is_active', true)
            ->first();

        if (!$setting) {
            RateLimiter::hit($key, 60);
            return back()->with('notify', [['warning', 'Invalid symbol or symbol not active.']]);
        }

        if (!$this->isMarketOpenWithTimezone($setting->trading_hours)) {
            RateLimiter::hit($key, 60);
            return back()->with('notify', [['warning', 'Market is currently closed for this symbol.']]);
        }

        if ($request->amount < $setting->min_amount || $request->amount > $setting->max_amount) {
            RateLimiter::hit($key, 60);
            return back()->with('notify', [['warning', "The trade amount should be between " . getCurrencySymbol() . shortAmount($setting->min_amount) . " and " . getCurrencySymbol() . shortAmount($setting->max_amount) . "."]]);
        }

        $durations = is_string($setting->durations)
            ? json_decode($setting->durations, true)
            : $setting->durations;

        if (!in_array($request->duration, $durations)) {
            RateLimiter::hit($key, 60);
            return back()->with('notify', [['warning', 'Invalid duration for this symbol.']]);
        }

        $wallet = $user->wallet;
        if (!$wallet) {
            RateLimiter::hit($key, 60);
            return back()->with('notify', [['error', 'User wallet not found. Please contact support.']]);
        }

        $userBalance = $wallet->trade_balance;
        if ($userBalance <= 0) {
            RateLimiter::hit($key, 60);
            return back()->with('notify', [['warning', 'Your trade wallet balance is empty. Please add funds to continue trading.']]);
        }

        if ($request->amount > $userBalance) {
            RateLimiter::hit($key, 60);
            return back()->with('notify', [['warning', "Your trade wallet balance is insufficient for this investment. Current balance: " . getCurrencySymbol() . shortAmount($userBalance) . "."]]);
        }

        $activeTrades = TradeLog::where('user_id', $user->id)
            ->where('symbol', strtoupper($request->symbol))
            ->where('status', 'active')
            ->count();

        if ($activeTrades >= ($setting->max_trades_per_user ?? 10)) {
            RateLimiter::hit($key, 60);
            return back()->with('notify', [['warning', "Maximum " . ($setting->max_trades_per_user ?? 10) . " active trades allowed for this symbol."]]);
        }

        DB::beginTransaction();

        try {
            $wallet->refresh();
            if ($wallet->trade_balance < $request->amount) {
                DB::rollBack();
                RateLimiter::hit($key, 60);
                return back()->with('notify', [['warning', 'Insufficient balance. Please refresh and try again.']]);
            }

            $openTime = now();
            $expiryTime = $openTime->copy()->addSeconds($request->duration);

            $trade = TradeLog::create([
                'trade_setting_id' => $setting->id,
                'trade_id' => Str::random(16),
                'user_id' => $user->id,
                'symbol' => strtoupper($request->symbol),
                'direction' => $request->direction,
                'amount' => $request->amount,
                'open_price' => $currency->current_price,
                'duration_seconds' => $request->duration,
                'payout_rate' => $setting->payout_rate,
                'open_time' => $openTime,
                'expiry_time' => $expiryTime,
                'status' => 'active'
            ]);

            $previousBalance = $wallet->trade_balance;
            $wallet->decrement('trade_balance', $request->amount);
            $postBalance = $previousBalance - $request->amount;

            Transaction::create([
                'user_id' => $user->id,
                'type' => Type::MINUS->value,
                'wallet_type' => WalletType::TRADE->value,
                'amount' => $request->amount,
                'trx' => Str::random(16),
                'post_balance' => $postBalance,
                'source' => Source::TRADE->value,
                'details' => "Trade opened for {$trade->symbol} ({$trade->direction}) - Amount: {$request->amount}",
            ]);

            DB::commit();
            RateLimiter::clear($key);

            return back()->with('notify', [['success', 'Trade has been placed successfully!']]);

        } catch (\Exception $e) {
            DB::rollBack();
            RateLimiter::hit($key, 60);
            Log::error('Trade creation failed: ' . $e->getMessage());
            return back()->with('notify', [['error', 'Failed to create trade. Please try again.']]);
        }
    }


    public function cancel(TradeLog $trade): RedirectResponse
    {
        $user = auth()->user();
        if ($trade->user_id !== $user->id) {
            abort(403);
        }

        if ($trade->status !== 'active') {
            return back()->with('notify', [['warning', 'Trade is not active.']]);
        }

        $timeSinceOpen = now()->diffInSeconds($trade->open_time);
        if ($timeSinceOpen > 30) {
            return back()->with('notify', [['warning', 'Trade can only be cancelled within 30 seconds of opening.']]);
        }

        DB::beginTransaction();
        try {
            $trade->update([
                'status' => 'cancelled',
                'close_time' => now(),
                'profit_loss' => 0
            ]);

            $wallet = $user->wallet;
            $previousBalance = $wallet->trade_balance;
            $wallet->increment('trade_balance', $trade->amount);
            $postBalance = $previousBalance + $trade->amount;

            Transaction::create([
                'user_id' => $user->id,
                'type' => Type::PLUS->value,
                'wallet_type' => WalletType::TRADE->value,
                'amount' => $trade->amount,
                'trx' => Str::random(16),
                'post_balance' => $postBalance,
                'source' => Source::TRADE->value,
                'details' => "Trade cancelled for {$trade->symbol} ({$trade->direction}) - Refund: {$trade->amount}",
            ]);

            DB::commit();
            return redirect()->route('user.trades.index')->with('notify', [['success', 'Trade has been cancelled successfully.']]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('notify', [['error', 'Failed to cancel trade. Please try again.']]);
        }
    }


    /**
     * @param $tradingHours
     * @return bool
     */
    private function isMarketOpenWithTimezone($tradingHours): bool
    {
        if (!$tradingHours) {
            return false;
        }

        $tradingHours = is_string($tradingHours)
            ? json_decode($tradingHours, true)
            : $tradingHours;

        if (!$tradingHours) {
            return false;
        }

        $now = Carbon::now();
        $currentDay = strtolower($now->format('l'));
        $currentTime = $now->format('H:i');
        $daySchedule = $tradingHours[$currentDay] ?? null;
        Log::info("Market check with timezone UTC: Day={$currentDay}, Time={$currentTime}");
        if (!$daySchedule || !($daySchedule['enabled'] ?? false)) {
            return false;
        }

        $currentMinutes = $this->timeToMinutes($currentTime);
        $startMinutes = $this->timeToMinutes($daySchedule['start']);
        $endMinutes = $this->timeToMinutes($daySchedule['end']);

        if ($startMinutes <= $endMinutes) {
            return $currentMinutes >= $startMinutes && $currentMinutes <= $endMinutes;
        }

        return $currentMinutes >= $startMinutes || $currentMinutes <= $endMinutes;
    }

    /**
     * @param string $timeStr
     * @return int
     */
    private function timeToMinutes(string $timeStr): int
    {
        $parts = explode(':', $timeStr);
        return (int)$parts[0] * 60 + (int)$parts[1];
    }

    /**
     * @param $userId
     * @return array
     */
    private function getUserTradeStats($userId): array
    {
        $totalTrades = TradeLog::where('user_id', $userId)->count();
        $activeTrades = TradeLog::where('user_id', $userId)->where('status', 'active')->count();
        $wonTrades = TradeLog::where('user_id', $userId)->where('status', 'won')->count();
        $lostTrades = TradeLog::where('user_id', $userId)->where('status', 'lost')->count();
        $expiredTrades = TradeLog::where('user_id', $userId)->where('status', 'expired')->count();
        $cancelledTrades = TradeLog::where('user_id', $userId)->where('status', 'cancelled')->count();

        $totalVolume = TradeLog::where('user_id', $userId)->sum('amount');
        $totalProfit = TradeLog::where('user_id', $userId)->sum('profit_loss');

        $completedTrades = $wonTrades + $lostTrades + $expiredTrades;
        $winRate = $completedTrades > 0 ? round(($wonTrades / $completedTrades) * 100, 2) : 0;

        return [
            'total_trades' => $totalTrades,
            'active_trades' => $activeTrades,
            'won_trades' => $wonTrades,
            'lost_trades' => $lostTrades,
            'expired_trades' => $expiredTrades,
            'cancelled_trades' => $cancelledTrades,
            'win_rate' => $winRate,
            'total_volume' => round($totalVolume, 2),
            'total_profit' => round($totalProfit, 2),
            'avg_trade_amount' => $totalTrades > 0 ? round($totalVolume / $totalTrades, 2) : 0,
        ];
    }

    /**
     * @param $seconds
     * @return string
     */
    private function formatDuration($seconds): string
    {
        $seconds = (int) $seconds;

        if ($seconds < 60) {
            return $seconds . 's';
        } elseif ($seconds < 3600) {
            return floor($seconds / 60) . 'm';
        } else {
            return floor($seconds / 3600) . 'h';
        }
    }

    /**
     * @param $trade
     * @return string|null
     */
    private function getTimeRemaining($trade): ?string
    {
        if ($trade->status !== 'active') {
            return null;
        }

        $now = now();
        $expiry = Carbon::parse($trade->expiry_time);

        if ($now->gte($expiry)) {
            return 'Expired';
        }

        $diff = $now->diffInSeconds($expiry);

        if ($diff < 60) {
            return $diff . 's left';
        } elseif ($diff < 3600) {
            return floor($diff / 60) . 'm left';
        } else {
            return floor($diff / 3600) . 'h left';
        }
    }

    /**
     * @param $profitLoss
     * @return string
     */
    private function formatProfitLoss($profitLoss): string
    {
        $profitLoss = (float) $profitLoss;

        if ($profitLoss == 0) {
            return '0.00';
        }

        $sign = $profitLoss > 0 ? '+' : '';
        $currencySymbol = Setting::get('currency_symbol', '$');
        return $sign . $currencySymbol . number_format(abs($profitLoss), 2);
    }

    /**
     * @param $status
     * @return string
     */
    private function getWinStatus($status): string
    {
        $allowedStatuses = ['won', 'lost', 'expired', 'cancelled', 'active'];

        if (!in_array($status, $allowedStatuses)) {
            return 'Unknown';
        }

        return match ($status) {
            'won' => 'Won',
            'lost' => 'Lost',
            'expired' => 'Expired',
            'cancelled' => 'Cancelled',
            'active' => 'Active',
            default => ucfirst($status),
        };
    }
}
