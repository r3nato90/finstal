<?php

namespace App\Services\Payment;

use App\Enums\Payment\Withdraw\Status;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WithdrawLog;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WithdrawService
{
    public function __construct(
        protected TransactionService $transactionService,
        protected WalletService $walletService
    ) {
    }

    /**
     * Find withdrawal log by ID
     */
    public function findById(int $id): ?WithdrawLog
    {
        return WithdrawLog::find($id);
    }

    /**
     * Prepare withdrawal parameters for primary wallet only
     */
    public function prepParams(WithdrawMethod $withdrawMethod, Request $request): array
    {
        $amount = (float) $request->input('amount');

        // Calculate charges using centralized method
        $charges = $this->calculateCharges($amount, $withdrawMethod);

        return [
            'uid' => Str::uuid(),
            'withdraw_method_id' => $withdrawMethod->id,
            'user_id' => Auth::id(),
            'currency' => $withdrawMethod->currency_name,
            'rate' => $withdrawMethod->rate,
            'amount' => $amount,
            'charge' => $charges['charge'],
            'final_amount' => $charges['after_charge'] * $withdrawMethod->rate,
            'after_charge' => $charges['after_charge'],
            'trx' => getTrx(),
            'status' => Status::INITIATED->value,
            'wallet_type' => WalletType::PRIMARY->value, // Always primary wallet
        ];
    }

    /**
     * Centralized charge calculation method
     */
    private function calculateCharges(float $amount, WithdrawMethod $withdrawMethod): array
    {
        $charge = $withdrawMethod->fixed_charge + ($amount * $withdrawMethod->percent_charge / 100);
        $afterCharge = $amount - $charge;

        return [
            'charge' => $charge,
            'after_charge' => $afterCharge,
            'total_deducted' => $amount, // Only amount is deducted from wallet, not charge
        ];
    }

    /**
     * Save withdrawal log
     */
    public function save(array $data): WithdrawLog
    {
        return WithdrawLog::create($data);
    }

    /**
     * Validate withdrawal amount with enhanced error messages
     */
    public function validateWithdrawalAmount(int|float|string $amount, WithdrawMethod $withdrawMethod, Wallet $wallet): ?array
    {
        $amount = (float) $amount;

        // Check minimum limit
        if ($amount < $withdrawMethod->min_limit) {
            return [
                'error',
                'Minimum withdrawal amount is ' . getCurrencySymbol() . shortAmount($withdrawMethod->min_limit)
            ];
        }

        // Check maximum limit
        if ($amount > $withdrawMethod->max_limit) {
            return [
                'error',
                'Maximum withdrawal amount is ' . getCurrencySymbol() . shortAmount($withdrawMethod->max_limit)
            ];
        }

        // Calculate charges and check balance
        $charges = $this->calculateCharges($amount, $withdrawMethod);
        $totalRequired = $charges['total_deducted']; // Only amount is deducted

        if ($totalRequired > $wallet->primary_balance) {
            return [
                'error',
                'Insufficient balance. Required: ' . getCurrencySymbol() . shortAmount($totalRequired) .
                ', Available: ' . getCurrencySymbol() . shortAmount($wallet->primary_balance)
            ];
        }

        return null;
    }

    /**
     * Find withdrawal log by UID with security checks
     */
    public function findByUidWithdrawLog(string $uid): ?WithdrawLog
    {
        return WithdrawLog::where('uid', $uid)
            ->where('status', Status::INITIATED->value)
            ->where('user_id', Auth::id()) // Security: Only user's own withdrawals
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Fetch withdrawal logs with filtering
     */
    public function fetchWithdrawLogs(int|string $userId = null, array $with = []): AbstractPaginator
    {
        return WithdrawLog::where('status', '!=', Status::INITIATED->value)
            ->filter(request()->all())
            ->when(!is_null($userId), fn ($query) => $query->where('user_id', $userId))
            ->latest()
            ->when(!empty($with), fn ($query) => $query->with($with))
            ->paginate(getPaginate());
    }

    /**
     * Get withdrawal statistics for API
     */
    public function getApiReport(int|string $userId = null): array
    {
        $withdraw = $this->getWithdrawReport($userId);

        return [
            'total' => $withdraw->total ?? 0,
            'pending' => $withdraw->pending ?? 0,
            'rejected' => $withdraw->rejected ?? 0,
            'charge' => $withdraw->charge ?? 0,
        ];
    }

    /**
     * Get detailed withdrawal report
     */
    private function getWithdrawReport(int|string $userId = null)
    {
        $query = WithdrawLog::query();

        if (!is_null($userId)) {
            $query->where('user_id', $userId);
        }

        return $query->selectRaw('
            SUM(CASE WHEN status = ? THEN amount ELSE 0 END) as total,
            SUM(CASE WHEN status = ? THEN amount ELSE 0 END) as pending,
            SUM(CASE WHEN status = ? THEN amount ELSE 0 END) as rejected,
            SUM(CASE WHEN status = ? THEN charge ELSE 0 END) as charge
        ', [
            Status::SUCCESS->value,
            Status::PENDING->value,
            Status::CANCEL->value,
            Status::SUCCESS->value,
        ])->first();
    }

    /**
     * Get withdrawal report (public method)
     */
    public function getReport(int|string $userId = null)
    {
        return $this->getWithdrawReport($userId);
    }

    /**
     * Create withdrawal parameters for manual/system withdrawals
     */
    public function withdrawParams(int|float $amount, int|float|string $charge = 0, int|string $userId = null): array
    {
        $amount = (float) $amount;
        $charge = (float) $charge;

        return [
            'uid' => Str::uuid(),
            'withdraw_method_id' => 0,
            'user_id' => $userId ?? Auth::id(),
            'currency' => getCurrencyName(),
            'rate' => 1,
            'amount' => $amount,
            'charge' => $charge,
            'final_amount' => $amount - $charge,
            'after_charge' => $amount - $charge,
            'trx' => getTrx(),
            'status' => Status::SUCCESS->value,
            'wallet_type' => WalletType::PRIMARY->value,
        ];
    }

    /**
     * Execute withdrawal with enhanced security and error handling
     */
    public function execute(WithdrawLog $withdrawLog, WithdrawMethod $withdrawMethod, Wallet $wallet, Request $request): void
    {
        try {
            DB::transaction(function () use ($withdrawLog, $request, $withdrawMethod, $wallet) {
                $lockedWallet = Wallet::where('id', $wallet->id)
                    ->where('user_id', Auth::id())
                    ->lockForUpdate()
                    ->first();

                if (!$lockedWallet) {
                    throw new \Exception('Wallet not found or access denied');
                }

                if ($withdrawLog->amount > $lockedWallet->primary_balance) {
                    throw new \Exception(
                        'Insufficient balance. Required: ' . getCurrencySymbol() . shortAmount($withdrawLog->amount) .
                        ', Available: ' . getCurrencySymbol() . shortAmount($lockedWallet->primary_balance)
                    );
                }

                if ($withdrawLog->status !== Status::INITIATED->value) {
                    throw new \Exception('Invalid withdrawal status: ' . $withdrawLog->status);
                }

                $withdrawLog->status = Status::PENDING->value;
                $withdrawLog->meta = $request->only(array_keys($withdrawMethod->parameter ?? []));
                $withdrawLog->save();

                $lockedWallet->primary_balance -= $withdrawLog->amount;
                $lockedWallet->save();

                $this->createTransactionRecord($withdrawLog, $lockedWallet);
                Log::info('Withdrawal executed successfully', [
                    'withdraw_log_id' => $withdrawLog->id,
                    'user_id' => Auth::id(),
                    'amount' => $withdrawLog->amount,
                    'final_amount' => $withdrawLog->final_amount,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Withdrawal execution failed', [
                'withdraw_log_id' => $withdrawLog->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Create transaction record for withdrawal
     */
    private function createTransactionRecord(WithdrawLog $withdrawLog, Wallet $wallet): void
    {
        $transactionData = $this->transactionService->prepParams([
            'user_id' => Auth::id(),
            'amount' => $withdrawLog->amount,
            'wallet' => $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
            'charge' => $withdrawLog->charge,
            'trx' => $withdrawLog->trx,
            'type' => Type::MINUS->value,
            'wallet_type' => WalletType::PRIMARY->value,
            'source' => Source::ALL->value,
            'details' => "Withdraw " . shortAmount($withdrawLog->final_amount) . " " .
                $withdrawLog->currency . " via " . $withdrawLog->withdrawMethod->name,
        ]);

        $this->transactionService->save($transactionData);
    }

    /**
     * Get withdrawal charges for preview
     */
    public function getWithdrawalCharges(float $amount, WithdrawMethod $withdrawMethod): array
    {
        return $this->calculateCharges($amount, $withdrawMethod);
    }

    /**
     * Check if user can withdraw (daily limits, etc.)
     */
    public function canUserWithdraw(int $userId, float $amount): bool
    {
        $user = \App\Models\User::find($userId);
        if (!$user || !$user->wallet) {
            return false;
        }

        return $user->wallet->primary_balance >= $amount;
    }

    /**
     * Get user's withdrawal statistics
     */
    public function getUserWithdrawalStats(int $userId): array
    {
        $today = now()->startOfDay();
        $thisMonth = now()->startOfMonth();

        return [
            'today_total' => WithdrawLog::where('user_id', $userId)
                ->where('created_at', '>=', $today)
                ->where('status', Status::SUCCESS->value)
                ->sum('amount'),

            'month_total' => WithdrawLog::where('user_id', $userId)
                ->where('created_at', '>=', $thisMonth)
                ->where('status', Status::SUCCESS->value)
                ->sum('amount'),

            'pending_count' => WithdrawLog::where('user_id', $userId)
                ->where('status', Status::PENDING->value)
                ->count(),
        ];
    }
}
