<?php

namespace App\Services;

use App\Models\Referral;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReferralService
{
    /**
     * @param $referredUserId
     * @param int $amount
     * @return bool
     * @throws Exception
     */
    public function processReferral($referredUserId, int $amount = 10): bool
    {
        $referredUser = User::find($referredUserId);
        if (!$referredUser || !$referredUser->referred_by) {
            return false;
        }

        $referrer = User::find($referredUser->referred_by);
        if (!$referrer) {
            return false;
        }

        $wallet = $referrer->wallets()->where('type', Type::MAIN->value)->first();
        if (!$wallet) {
            throw new Exception('Wallet not found');
        }

        $commissionRate = Setting::get('referral_deposit_commission_rate', 1);
        $addAmount = ($amount * (float)$commissionRate) / 100;

        if ($addAmount <= 0) {
            throw new Exception('Invalid referral amount');
        }

        $previousBalance = (float) $wallet->balance;
        $newBalance = round($previousBalance + $addAmount, 2);

        Referral::create([
            'referrer_id' => $referrer->id,
            'referred_id' => $referredUser->id,
            'commission' => $addAmount,
            'status' => 'paid'
        ]);

        $wallet->update([
            'balance' => $newBalance,
            'last_activity' => now()
        ]);

        Transaction::create([
            'transaction_id' => Str::random(),
            'user_id' => $referrer->id,
            'type' => 'credit',
            'wallet_type' => 'main_wallet',
            'amount' => $addAmount,
            'post_balance' => $newBalance,
            'status' => 'completed',
            'details' => "Referral commission from " . e($referredUser->name) . " - Commission: $" . number_format($addAmount, 2)
        ]);

        try {
            EmailSmsTemplateService::sendTemplateEmail('referral_commission', $referrer, [
                'user_name' => e($referrer->name),
                'referred_user_name' => e($referredUser->name),
                'commission_amount' => number_format($addAmount, 2),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send referral commission email: ' . $e->getMessage(), [
                'referrer_id' => $referrer->id,
                'referred_user_id' => $referredUserId,
                'amount' => $addAmount
            ]);
        }

        return true;
    }

    /**
     * @param $referralCode
     * @return null
     */
    public function handleRegistration($referralCode)
    {
        if (!$referralCode) {
            return null;
        }

        $referrer = User::where('uuid', $referralCode)->first();
        return $referrer ? $referrer->id : null;
    }
}
