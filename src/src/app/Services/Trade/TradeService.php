<?php

namespace App\Services\Trade;

use App\Models\TradeLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TradeService
{
    /**
     * Get comprehensive trade report for a user
     */
    public function getTradeReport(int $userId): object
    {
        $trades = TradeLog::where('user_id', $userId);

        $totalTrades = $trades->count();
        $activeTrades = $trades->where('status', 'active')->count();
        $wonTrades = $trades->where('status', 'won')->count();
        $lostTrades = $trades->where('status', 'lost')->count();
        $drawTrades = $trades->where('status', 'draw')->count();

        $totalProfit = $trades->where('status', 'won')->sum('profit_loss');
        $totalLoss = abs($trades->where('status', 'lost')->sum('profit_loss'));
        $netProfitLoss = $totalProfit - $totalLoss;

        $totalInvested = $trades->sum('amount');

        $completedTrades = $wonTrades + $lostTrades + $drawTrades;
        $winRate = $completedTrades > 0 ? ($wonTrades / $completedTrades) * 100 : 0;

        return (object) [
            'total' => $totalTrades,
            'active' => $activeTrades,
            'won' => $wonTrades,
            'lost' => $lostTrades,
            'draw' => $drawTrades,
            'total_profit' => $totalProfit,
            'total_loss' => $totalLoss,
            'net_profit_loss' => $netProfitLoss,
            'total_invested' => $totalInvested,
            'win_rate' => round($winRate, 2),
            'profit_percentage' => $totalInvested > 0 ? round(($netProfitLoss / $totalInvested) * 100, 2) : 0
        ];
    }

    public function monthlyTradeReport(int $userId): array
    {
        $months = [];
        $profitData = [];
        $lossData = [];
        $tradeCountData = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M Y');

            $monthlyTrades = TradeLog::where('user_id', $userId)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->get();

            $monthlyProfit = $monthlyTrades->where('status', 'won')->sum('profit_loss');
            $monthlyLoss = abs($monthlyTrades->where('status', 'lost')->sum('profit_loss'));
            $monthlyCount = $monthlyTrades->count();

            $profitData[] = (float) $monthlyProfit;
            $lossData[] = (float) $monthlyLoss;
            $tradeCountData[] = $monthlyCount;
        }

        return [$months, $profitData, $lossData, $tradeCountData];
    }

    /**
     * Get recent trade activities for dashboard
     */
    public function getRecentTrades(int $userId, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return TradeLog::where('user_id', $userId)
            ->with('setting')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }


    /**
     * Get recent trade activities for dashboard
     */
    public function getLatestTrades(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return TradeLog::with('setting')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get trade statistics by symbol
     */
    public function getTradesBySymbol(int $userId): array
    {
        return TradeLog::where('user_id', $userId)
            ->select('symbol',
                DB::raw('COUNT(*) as total_trades'),
                DB::raw('SUM(CASE WHEN status = "won" THEN 1 ELSE 0 END) as won_trades'),
                DB::raw('SUM(CASE WHEN status = "lost" THEN 1 ELSE 0 END) as lost_trades'),
                DB::raw('SUM(profit_loss) as net_profit')
            )
            ->groupBy('symbol')
            ->orderBy('total_trades', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get today's trade summary
     */
    public function getTodayTradeSummary(int $userId): object
    {
        $today = Carbon::today();

        $todayTrades = TradeLog::where('user_id', $userId)
            ->whereDate('created_at', $today);

        $totalTrades = $todayTrades->count();
        $wonTrades = $todayTrades->where('status', 'won')->count();
        $lostTrades = $todayTrades->where('status', 'lost')->count();
        $todayProfit = $todayTrades->sum('profit_loss');

        return (object) [
            'total_trades' => $totalTrades,
            'won_trades' => $wonTrades,
            'lost_trades' => $lostTrades,
            'today_profit' => $todayProfit,
            'win_rate' => $totalTrades > 0 ? round(($wonTrades / $totalTrades) * 100, 2) : 0
        ];
    }

    /**
     * Get performance metrics for different time periods
     */
    public function getPerformanceMetrics(int $userId): array
    {
        $periods = [
            'today' => Carbon::today(),
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear()
        ];

        $metrics = [];

        foreach ($periods as $period => $startDate) {
            $trades = TradeLog::where('user_id', $userId)
                ->where('created_at', '>=', $startDate);

            $total = $trades->count();
            $won = $trades->where('status', 'won')->count();
            $profit = $trades->sum('profit_loss');

            $metrics[$period] = [
                'total_trades' => $total,
                'won_trades' => $won,
                'win_rate' => $total > 0 ? round(($won / $total) * 100, 2) : 0,
                'profit' => $profit
            ];
        }

        return $metrics;
    }
}
