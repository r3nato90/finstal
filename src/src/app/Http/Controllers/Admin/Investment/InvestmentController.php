<?php

namespace App\Http\Controllers\Admin\Investment;

use App\Enums\CommissionType;
use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\Investment\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Matrix\BinaryOptionsRequest;
use App\Models\InvestmentLog;
use App\Models\InvestmentPlan;
use App\Models\User;
use App\Services\EmailSmsTemplateService;
use App\Services\Investment\CommissionService;
use App\Services\Investment\InvestmentPlanService;
use App\Services\Investment\InvestmentService;
use App\Services\Investment\TimeTableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class InvestmentController extends Controller
{
    public function __construct(
        protected InvestmentPlanService $investmentPlanService,
        protected InvestmentService $investmentService,
        protected CommissionService $commissionService,
        protected TimeTableService $timeTableService,
    ){

    }

    /**
     * Display a listing of investment plans
     *
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View
    {
        $setTitle = __('Investment Plans Management');

        $search = request()->get('search');
        $status = request()->get('status');
        $type = request()->get('type');
        $interestType = request()->get('interest_type');
        $sortField = request()->get('sort_field', 'created_at');
        $sortDirection = request()->get('sort_direction', 'desc');

        $query = InvestmentPlan::with(['timeTable', 'investmentLogs']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('uid', 'like', "%{$search}%");
            });
        }

        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        if ($type) {
            $query->where('type', $type);
        }

        if ($interestType) {
            $query->where('interest_type', $interestType);
        }

        $allowedSortFields = ['name', 'interest_rate', 'minimum', 'maximum', 'status', 'created_at', 'duration'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'desc' ? 'desc' : 'asc');
        } else {
            $query->latest();
        }

        $perPage = (int) request()->get('per_page', 20);
        $investmentPlans = $query->paginate($perPage)->appends(request()->all());

        $stats = $this->getInvestmentPlanStats();

        $filters = [
            'search' => $search,
            'status' => $status,
            'type' => $type,
            'interest_type' => $interestType,
            'sort_field' => $sortField,
            'sort_direction' => $sortDirection,
        ];

        return view('admin.binary.index', compact(
            'investmentPlans',
            'stats',
            'filters',
            'setTitle'
        ));
    }

    /**
     * Get investment plan statistics
     */
    private function getInvestmentPlanStats(): array
    {
        return [
            'totalPlans' => InvestmentPlan::count(),
            'activePlans' => InvestmentPlan::where('status', 1)->count(),
            'recommendedPlans' => InvestmentPlan::where('is_recommend', 1)->count(),
            'totalInvestments' => InvestmentLog::count(),
        ];
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $setTitle = __('admin.binary.page_title.create');
        $timeTables = $this->timeTableService->getActiveTime();

        return view('admin.binary.create', compact(
            'setTitle',
            'timeTables'
        ));
    }


    /**
     * @param string $uid
     * @return View
     */
    public function edit(string $uid): View
    {
        $setTitle = __('admin.binary.page_title.edit');
        $scheme = $this->investmentPlanService->findByUid($uid);
        $timeTables = $this->timeTableService->getActiveTime();

        return view('admin.binary.edit', compact(
            'setTitle',
            'scheme',
            'timeTables'
        ));
    }

    /**
     * @param BinaryOptionsRequest $request
     * @return RedirectResponse
     */
    public function store(BinaryOptionsRequest $request): RedirectResponse
    {
        $plan = $this->investmentPlanService->save($this->investmentPlanService->prepParams($request));
        $this->notifyUsersIfRequested($request, $plan);

        return back()->with('notify', [['success', __('admin.binary.notify.plan.update.success')]]);
    }


    /**
     * @param BinaryOptionsRequest $request
     * @return RedirectResponse
     */
    public function update(BinaryOptionsRequest $request): RedirectResponse
    {
        $this->investmentPlanService->update($request);
        return redirect()->route('admin.binary.index')->with('notify', [['success', __('admin.binary.notify.plan.update.success')]]);
    }

    /**
     * @return View
     */
    public function dailyCommissions(): View
    {
        $setTitle = __('Investment Profits and Commissions');
        $dailyCommissions = $this->commissionService->getCommissionsOfType(CommissionType::INVESTMENT, ['user']);

        return view('admin.binary.commission', compact(
            'setTitle',
            'dailyCommissions'
        ));
    }


    /**
     * @param int $id
     * @return View
     */
    public function details(int $id): View
    {
        $setTitle = __('Investment Details');
        $investment = $this->investmentService->findById($id);
        $commissions = $this->commissionService->getCommissionsOfType(CommissionType::INVESTMENT, with: ['user'], investmentLogId: $investment->id);

        return view('admin.binary.details', compact(
            'setTitle',
            'commissions',
            'investment',
        ));
    }

    /**
     * @param BinaryOptionsRequest $request
     * @param InvestmentPlan $plan
     * @return void
     */
    protected function notifyUsersIfRequested(BinaryOptionsRequest $request, InvestmentPlan $plan): void
    {
        if ($request->has('notify')){

            $users = User::where('status', 1)
                ->whereNull('email_verified_at')
                ->select('phone', 'email')
                ->get();

            foreach ($users as $user) {
                EmailSmsTemplateService::sendTemplateEmail(EmailSmsTemplateName::INVESTMENT_PLAN_NOTIFY->value, $user, [
                    'name' => $plan->name,
                    'minimum' => shortAmount($plan->minimum),
                    'maximum' => shortAmount($plan->maximum),
                    'amount' => shortAmount($plan->amount),
                    'interest_rate' => shortAmount($plan->interest_rate),
                    'duration' => $plan->duration,
                ]);
            }
        }
    }
}
