<?php

namespace App\Http\Controllers;

use App\Enums\CommissionType;
use App\Enums\CronCode;
use App\Enums\Status;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Models\Cron;
use App\Models\InvestmentUserReward;
use App\Models\Setting;
use App\Models\User;
use App\Services\Investment\CommissionService;
use App\Services\Investment\InvestmentService;
use App\Services\Investment\Staking\StakingInvestmentService;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class CronController extends Controller
{
    public function __construct(
        protected InvestmentService $investmentService,
        protected StakingInvestmentService $stakingInvestmentService,
        protected TransactionService $transactionService,
        protected WalletService $walletService,
        protected CommissionService $commissionService,
    )
    {

    }

    /**
     */
    public function handle(): void
    {
        $cron = Cron::all();
        foreach ($cron as $value) {
            if ($value->code == CronCode::INVESTMENT_PROCESS->value || $value->code == CronCode::TRADE_OUTCOME->value){
                $value->last_run = Carbon::now();
            }

            $value->save();
        }

        Artisan::call('crypto:update-prices');
        Artisan::call('trade:process-expired');

        $this->investmentService->cron();
        $this->stakingInvestmentService->cron();
        $this->investmentReward();
    }


    public function investmentReward(): void
    {
        if (Setting::get('module_investment_reward', 1) != Status::ACTIVE->value) {
            return;
        }

        $rewardUsers = User::with('referredUsers', 'ongoingReferrals')
            ->orderBy('last_reward_update')
            ->limit(100)
            ->get();

        foreach ($rewardUsers as $user) {
            $user->last_reward_update = now();
            $user->save();

            $referralCount   = $user->ongoingReferrals->count();
            $depositAmount = $user->deposit->sum('final_amount');
            $aggregateInvestment = $user->aggregate_investment;
            $collectiveInvestment = $user->collective_investment;

            $rewards = InvestmentUserReward::where('status', Status::ACTIVE->value)
                ->where('id', '>', $user->reward_identifier)
                ->where('invest', '<=', $aggregateInvestment)
                ->where('team_invest', '<=', $collectiveInvestment)
                ->where('deposit', '<=', $depositAmount)
                ->where('referral_count', '<=', $referralCount)
                ->get();


            foreach ($rewards as $investmentReward) {
                $user->reward_identifier = $investmentReward->id;
                $user->save();

                $wallet = $user->wallet->fresh();
                $wallet->investment_balance += $investmentReward->reward;
                $wallet->save();

                $transactionParams = [
                    'user_id' => (int) $user->id,
                    'amount' => $investmentReward->reward,
                    'type' => Type::PLUS,
                    'trx' => getTrx(),
                    'details' => shortAmount($investmentReward->reward) . ' ' . getCurrencyName() . ' investment reward for ' . @$investmentReward->name,
                    'wallet' => $this->walletService->findBalanceByWalletType(WalletType::INVESTMENT->value, $wallet),
                    'source' => Source::INVESTMENT->value,
                ];

                $this->transactionService->save($this->transactionService->prepParams($transactionParams));
                $this->commissionService->save($this->commissionService->prepParams(
                    $user->id,
                    shortAmount($investmentReward->reward) . ' ' . getCurrencyName() . ' investment reward for ' . @$investmentReward->name,
                    CommissionType::INVESTMENT,
                    $investmentReward->reward,
                ));
            }
        }
    }
}
