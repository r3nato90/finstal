<?php

namespace App\Http\Controllers\User;

use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StakingInvestmentRequest;
use App\Models\Setting;
use App\Models\StakingInvestment;
use App\Services\Investment\Staking\PlanService;
use App\Services\Investment\Staking\StakingInvestmentService;
use App\Services\Payment\WalletService;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StakingInvestmentController extends Controller
{
    public function __construct(
        protected PlanService $planService,
        protected WalletService $walletService,
        protected StakingInvestmentService $investmentService,
    )
    {

    }

    public function index(): View
    {
        $investmentStakingInvestment = Setting::get('investment_staking_investment', 1);
        if($investmentStakingInvestment == 0){
            abort(404);
        }

        $setTitle = "Staking Investment";
        $userId = Auth::id();
        $stakingInvestments = StakingInvestment::where('user_id', $userId)->filter(request()->all())->with('user')->orderBy('id', 'desc')->paginate(getPaginate());
        $plans = $this->planService->getActivePlans();

        return view('user.investment.staking.index', compact('setTitle', 'stakingInvestments', 'plans'));
    }

    /**
     * @param StakingInvestmentRequest $request
     * @return RedirectResponse
     */
    public function store(StakingInvestmentRequest $request): RedirectResponse
    {
        $investmentStakingInvestment = Setting::get('investment_staking_investment', 1);
        if($investmentStakingInvestment == 0){
            abort(404);
        }

        $plan = $this->planService->findById($request->input('plan_id'));
        $wallet = Auth::user()->wallet;
        $account = $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet);

        if($request->input('amount') > Arr::get($account, 'balance')){
            return back()->with('notify', [['warning', "Your primary account balance is insufficient for this investment."]]);
        }

        if ($request->input('amount') < $plan->minimum_amount || $request->input('amount') > $plan->maximum_amount) {
            return back()->with('notify', [['warning', 'The investment amount should be between ' . getCurrencySymbol().shortAmount($plan->minimum_amount) . ' and ' . getCurrencySymbol().shortAmount($plan->maximum_amount)]]);
        }

        $this->investmentService->executeInvestment($request, $wallet, $plan);
        return back()->with('notify', [['success', "Staking Investment has been added successfully"]]);
    }

}
