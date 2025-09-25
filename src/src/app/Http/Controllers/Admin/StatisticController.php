<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Trade\TradeType;
use App\Http\Controllers\Controller;
use App\Models\CryptoCurrency;
use App\Services\CurrencyService;
use App\Services\Investment\InvestmentPlanService;
use App\Services\Investment\InvestmentService;
use App\Services\Investment\MatrixInvestmentService;
use App\Services\Investment\MatrixService;
use App\Services\Payment\TransactionService;
use Illuminate\View\View;
use App\Services\Trade\TradeService;
use App\Models\TradeLog;

class StatisticController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService,
        protected InvestmentService $investmentService,
        protected InvestmentPlanService $investmentPlanService,
        protected MatrixService $matrixService,
        protected MatrixInvestmentService $matrixInvestmentService,
        protected TradeService $tradeService,
        protected CurrencyService $currencyService,
    )
    {

    }

    public function transactions(): View
    {
        $setTitle = __('admin.report.page_title.transaction');
        $transactions = $this->transactionService->getTransactions(with: ['user']);

        return view('admin.statistic.transaction', compact(
            'setTitle',
            'transactions'
        ));
    }


    public function investment(): View
    {
        $setTitle = __('admin.report.page_title.investment');

        [$months, $invest, $profit] = $this->investmentService->monthlyReport();
        [$days, $amount] = $this->investmentService->dayReport();
        $investment = $this->investmentService->getInvestmentReport();
        $investmentPlans = $this->investmentPlanService->getActivePlan(with: ['investmentLogs']);
        $investmentLogs = $this->investmentService->latestInvestments(['plan'], 10);

        return view('admin.statistic.investment', compact(
            'setTitle',
            'investment',
            'investmentPlans',
            'investmentLogs',
            'days',
            'amount',
            'months',
            'invest',
            'profit'
        ));
    }

    /**
     * @param int|string $uid
     * @return View
     */
    public function investmentLogsByPlan(int|string $uid): View
    {
        $investmentPlan = $this->investmentPlanService->findByUid($uid);

        if(!$investmentPlan){
            abort(404);
        }

        $setTitle = __('admin.binary.page_title.investment_plan', ['plan_name' => ucfirst($investmentPlan->name)]);
        $investmentLogs = $this->investmentService->getInvestmentLogsByPaginate(planId: $investmentPlan->id);

        return view('admin.binary.investment', compact(
            'setTitle',
            'investmentLogs',
        ));
    }

    public function trade(): View
    {
        $setTitle = __('admin.report.page_title.trade');
        $tradeStats = TradeLog::selectRaw('
        COUNT(*) as total_trades,
        COUNT(CASE WHEN status = "active" THEN 1 END) as active_trades,
        COUNT(CASE WHEN status = "won" THEN 1 END) as won_trades,
        COUNT(CASE WHEN status = "lost" THEN 1 END) as lost_trades,
        COUNT(CASE WHEN status = "draw" THEN 1 END) as draw_trades,
        SUM(CASE WHEN status = "won" THEN profit_loss ELSE 0 END) as total_profit,
        ABS(SUM(CASE WHEN status = "lost" THEN profit_loss ELSE 0 END)) as total_loss,
        SUM(profit_loss) as net_profit_loss,
        SUM(amount) as total_volume,
        MAX(amount) as highest_trade,
        MIN(amount) as lowest_trade,
        AVG(amount) as average_trade
    ')->first();

        $todayVolume = TradeLog::whereDate('created_at', today())->sum('amount');
        $weekVolume = TradeLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('amount');
        $monthVolume = TradeLog::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $completedTrades = $tradeStats->won_trades + $tradeStats->lost_trades + $tradeStats->draw_trades;
        $winRate = $completedTrades > 0 ? round(($tradeStats->won_trades / $completedTrades) * 100, 2) : 0;
        $profitMargin = $tradeStats->total_volume > 0 ?
            round(($tradeStats->net_profit_loss / $tradeStats->total_volume) * 100, 2) : 0;

        $trade = (object) [
            'total' => $tradeStats->total_trades,
            'today' => $todayVolume,
            'week' => $weekVolume,
            'month' => $monthVolume,
            'wining' => $tradeStats->total_profit,
            'loss' => $tradeStats->total_loss,
            'draw' => $tradeStats->draw_trades,
            'high' => $tradeStats->highest_trade ?? 0,
            'low' => $tradeStats->lowest_trade ?? 0,
            'average' => $tradeStats->average_trade ?? 0,
            'active' => $tradeStats->active_trades,
            'won' => $tradeStats->won_trades,
            'lost' => $tradeStats->lost_trades,
            'net_profit_loss' => $tradeStats->net_profit_loss,
            'total_invested' => $tradeStats->total_volume,
            'win_rate' => $winRate,
            'profit_margin' => $profitMargin,
            'completed_trades' => $completedTrades,
        ];

        $chartData = TradeLog::selectRaw('DATE(created_at) as date, SUM(amount) as total_amount')
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $days = [];
        $amount = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateKey = $date->format('Y-m-d');
            $days[] = $date->format('M d');
            $amount[] = (float) ($chartData->get($dateKey)->total_amount ?? 0);
        }

        $latestTradeLogs = TradeLog::with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($tradeLog) {
                $tradeLog->cryptoCurrency = $tradeLog->setting;
                return $tradeLog;
            });

        $topSymbols = TradeLog::selectRaw('symbol, COUNT(*) as trade_count, SUM(amount) as volume')
            ->groupBy('symbol')
            ->orderByDesc('volume')
            ->limit(5)
            ->get();

        $coins = CryptoCurrency::where('status', 'active')
            ->orderByDesc('total_volume')
            ->limit(12)
            ->get();

        if ($coins->isEmpty() && isset($this->currencyService)) {
            $allCoins = $this->currencyService->getTopCurrencies();
            $coins = $allCoins->filter(function($coin) {
                return ($coin->total_trading_amount ?? 0) > 0;
            })->take(12);
        }

        return view('admin.statistic.trade', compact(
            'setTitle',
            'trade',
            'latestTradeLogs',
            'coins',
            'days',
            'amount',
            'topSymbols'
        ));
    }

    public function matrix(): View
    {
        $setTitle = __('admin.report.page_title.matrix');

        [$months, $invest] = $this->matrixInvestmentService->monthlyReport();
        $matrixPlans = $this->matrixService->getActivePlan(with: ['matrixEnrolled']);
        $matrixInvest = $this->matrixInvestmentService->getMatrixReport();
        $latestMatrixLogs = $this->matrixInvestmentService->latestMatrix(['user'], 10);

        return view('admin.statistic.matrix', compact(
            'setTitle',
            'matrixPlans',
            'latestMatrixLogs',
            'matrixInvest',
            'months',
            'invest'
        ));
    }
}
