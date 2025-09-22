<?php

namespace App\Http\Controllers\Admin\Investment;

use App\Enums\Investment\Status;
use App\Http\Controllers\Controller;
use App\Models\InvestmentLog;
use App\Services\Investment\InvestmentService;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class InvestmentLogController extends Controller
{
    public function __construct(
        protected readonly TransactionService $transactionService,
        protected readonly WalletService $walletService,
        protected InvestmentService $investmentService,
    )
    {

    }
    /**
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function investment(): View
    {
        $setTitle = __('Investment Logs Management');

        $search = request()->get('search');
        $plan = request()->get('plan');
        $status = request()->get('status');
        $recaptureType = request()->get('recapture_type');
        $sortField = request()->get('sort_field', 'created_at');
        $sortDirection = request()->get('sort_direction', 'desc');

        $query = InvestmentLog::with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('uid', 'like', "%{$search}%")
                    ->orWhere('trx', 'like', "%{$search}%")
                    ->orWhere('plan_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('fullname', 'like', "%{$search}%");
                    });
            });
        }

        if ($plan) {
            $query->where('investment_plan_id', $plan);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($recaptureType) {
            $query->where('recapture_type', $recaptureType);
        }

        $allowedSortFields = ['uid', 'plan_name', 'amount', 'status', 'created_at', 'profit_time', 'interest_rate'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'desc' ? 'desc' : 'asc');
        } else {
            $query->latest();
        }

        $perPage = (int) request()->get('per_page', 20);
        $investmentLogs = $query->paginate($perPage)->appends(request()->all());

        $plans = InvestmentLog::select('investment_plan_id', 'plan_name')
            ->whereNotNull('plan_name')
            ->distinct()
            ->get()
            ->pluck('plan_name', 'investment_plan_id');

        $stats = $this->getInvestmentStats();

        $filters = [
            'search' => $search,
            'plan' => $plan,
            'status' => $status,
            'recapture_type' => $recaptureType,
            'sort_field' => $sortField,
            'sort_direction' => $sortDirection,
        ];

        return view('admin.investment.index', compact(
            'investmentLogs',
            'plans',
            'stats',
            'filters',
            'setTitle'
        ));
    }

    /**
     * Get investment statistics
     */
    private function getInvestmentStats(): array
    {
        return [
            'totalInvestments' => InvestmentLog::count(),
            'initiatedInvestments' => InvestmentLog::where('status', Status::INITIATED->value)->count(),
            'profitCompletedInvestments' => InvestmentLog::where('status', Status::PROFIT_COMPLETED->value)->count(),
            'completedInvestments' => InvestmentLog::where('status', Status::COMPLETED->value)->count(),
            'cancelledInvestments' => InvestmentLog::where('status', Status::CANCELLED->value)->count(),
            'totalInvestedAmount' => InvestmentLog::sum('amount'),
            'totalProfitPaid' => InvestmentLog::sum('profit'),
        ];
    }
}
