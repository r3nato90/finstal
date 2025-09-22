<?php

namespace App\Http\Controllers\Admin\Trade;

use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Models\TradeLog;
use App\Models\User;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TradeLogController extends Controller
{
    /**
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View
    {
        $setTitle = 'Trade Logs';

        $search = request()->get('search');
        $symbol = request()->get('symbol');
        $direction = request()->get('direction');
        $status = request()->get('status');
        $sortField = request()->get('sort_field', 'created_at');
        $sortDirection = request()->get('sort_direction', 'desc');

        $query = TradeLog::with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('trade_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($symbol) {
            $query->where('symbol', $symbol);
        }

        if ($direction) {
            $query->where('direction', $direction);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $allowedSortFields = ['trade_id', 'symbol', 'amount', 'status', 'created_at', 'open_time', 'close_time'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'desc' ? 'desc' : 'asc');
        } else {
            $query->latest();
        }

        $perPage = (int) request()->get('per_page', 20);
        $tradeLogs = $query->paginate($perPage)->appends(request()->all());

        $symbols = TradeLog::select('symbol')->distinct()->pluck('symbol')->sort()->values();
        $stats = $this->getTradeStats();

        $filters = [
            'search' => $search,
            'symbol' => $symbol,
            'direction' => $direction,
            'status' => $status,
            'sort_field' => $sortField,
            'sort_direction' => $sortDirection,
        ];

        return view('admin.trade.index', compact(
            'tradeLogs',
            'symbols',
            'stats',
            'filters',
            'setTitle'
        ));
    }

    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $setTitle = 'Trade Log Details';
        $tradeLog = TradeLog::with('user')->findOrFail($id);

        return view('admin.trade.show', compact(
            'tradeLog',
            'setTitle'
        ));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function settle(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'close_price' => 'required|numeric|min:0'
        ]);

        $tradeLog = TradeLog::findOrFail($id);

        if (!in_array($tradeLog->status, ['active', 'expired'])) {
            return back()->withErrors(['error' => 'Trade cannot be settled. Only active or expired trades can be settled.']);
        }

        try {
            $tradeLog->settleTrade($request->close_price);
            $tradeLog->refresh();

            if (in_array($tradeLog->status, ['won', 'draw'])) {
                $this->updateUserBalance($tradeLog);
            }

            return back()->with('notify', [['success', 'Trade settled successfully.']]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to settle trade: ' . $e->getMessage()]);
        }
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function cancel(int $id): RedirectResponse
    {
        $tradeLog = TradeLog::findOrFail($id);

        if (!in_array($tradeLog->status, ['active', 'expired'])) {
            return back()->withErrors(['error' => 'Trade cannot be cancelled. Only active or expired trades can be cancelled.']);
        }

        try {
            $tradeLog->cancelTrade();
            $tradeLog->refresh();

            if ($tradeLog->status === 'cancelled') {
                $this->updateUserBalance($tradeLog);
            }

            return back()->with('notify', [['success', 'Trade cancelled successfully.']]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to cancel trade: ' . $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->merge([
            'trade_ids' => json_decode($request->trade_ids, true)
        ]);

        $request->validate([
            'action' => 'required|in:settle,cancel',
            'trade_ids' => 'required|array',
            'trade_ids.*' => 'exists:trade_logs,id',
            'close_price' => 'required_if:action,settle|numeric|min:0'
        ]);

        $tradeLogs = TradeLog::whereIn('id', $request->trade_ids)
            ->whereIn('status', ['active', 'expired'])
            ->get();

        if ($tradeLogs->isEmpty()) {
            return back()->withErrors(['error' => 'No actionable trades found. Only active or expired trades can be processed.']);
        }

        $successCount = 0;
        $errorCount = 0;

        foreach ($tradeLogs as $tradeLog) {
            try {
                switch ($request->action) {
                    case 'settle':
                        $tradeLog->settleTrade($request->close_price);
                        $successCount++;
                        break;

                    case 'cancel':
                        $tradeLog->cancelTrade();
                        $successCount++;
                        break;
                }

                $tradeLog->refresh();
                if (in_array($tradeLog->status, ['won', 'draw', 'cancelled'])) {
                    $this->updateUserBalance($tradeLog);
                }

            } catch (Exception $e) {
                dd($e->getMessage());
                $errorCount++;
                Log::error("Failed to {$request->action} trade {$tradeLog->trade_id}: " . $e->getMessage());
                continue;
            }
        }

        $message = "{$successCount} trades {$request->action}d successfully";
        if ($errorCount > 0) {
            $message .= ". {$errorCount} trades failed to process.";
        }

        return back()->with('notify', [['success', $message]]);
    }

    /**
     * @return array
     */
    private function getTradeStats(): array
    {
        $totalTrades = TradeLog::count();
        $activeTrades = TradeLog::where('status', 'active')->count();
        $wonTrades = TradeLog::where('status', 'won')->count();
        $lostTrades = TradeLog::where('status', 'lost')->count();
        $totalVolume = TradeLog::sum('amount');
        $totalProfitLoss = TradeLog::where('status', 'lost')->sum('amount') -
            TradeLog::where('status', 'won')->sum('profit_loss');

        return [
            'totalTrades' => $totalTrades,
            'activeTrades' => $activeTrades,
            'wonTrades' => $wonTrades,
            'lostTrades' => $lostTrades,
            'totalVolume' => $totalVolume,
            'totalProfitLoss' => round($totalProfitLoss, 2),
        ];
    }

    /**
     * @param TradeLog $tradeLog
     * @return void
     * @throws Exception
     */
    private function updateUserBalance(TradeLog $tradeLog): void
    {
        $userId = $tradeLog->user_id;
        $user = User::find($userId);

        if (!$user) {
            throw new Exception("User with ID {$userId} not found");
        }

        $wallet = $user->wallet;
        if (!$wallet) {
            throw new Exception("Trade wallet not found for user {$userId}");
        }

        $previousBalance = $wallet->trade_balance;
        $tradeResult = $tradeLog->status;

        switch ($tradeResult) {
            case 'won':
                $totalAmount = $tradeLog->amount + $tradeLog->profit_loss;
                $wallet->increment('trade_balance', $totalAmount);
                $postBalance = $previousBalance + $totalAmount;

                $details = "Trade won for {$tradeLog->symbol} ({$tradeLog->direction}) - Investment return: " .
                    number_format($tradeLog->amount, 2) . " + Profit: " .
                    number_format($tradeLog->profit_loss, 2) . " = Total: " .
                    number_format($totalAmount, 2);

                Transaction::create([
                    'user_id' => $user->id,
                    'type' => Type::PLUS->value,
                    'wallet_type' => WalletType::TRADE->value,
                    'amount' => $totalAmount,
                    'trx' => Str::random(16),
                    'post_balance' => $postBalance,
                    'source' => Source::TRADE->value,
                    'details' => $details,
                ]);
                break;

            case 'draw':
            case 'cancelled':
                $refundAmount = $tradeLog->amount;
                $wallet->increment('trade_balance', $refundAmount);
                $postBalance = $previousBalance + $refundAmount;

                $actionText = $tradeResult === 'draw' ? 'draw' : 'cancelled';
                $details = "Trade {$actionText} for {$tradeLog->symbol} ({$tradeLog->direction}) - Investment refund: " .
                    number_format($refundAmount, 2);

                Transaction::create([
                    'user_id' => $user->id,
                    'type' => Type::PLUS->value,
                    'wallet_type' => WalletType::TRADE->value,
                    'amount' => $refundAmount,
                    'trx' => Str::random(16),
                    'post_balance' => $postBalance,
                    'source' => Source::TRADE->value,
                    'details' => $details,
                ]);
                break;

            default:
                throw new Exception("Unsupported trade status: {$tradeResult}. Only 'won', 'draw', and 'cancelled' are supported.");
        }
    }
}
