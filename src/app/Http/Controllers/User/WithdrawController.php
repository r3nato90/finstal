<?php

namespace App\Http\Controllers\User;

use App\Concerns\CustomValidation;
use App\Enums\Payment\NotificationType;
use App\Enums\Payment\Withdraw\MethodStatus;
use App\Enums\Payment\Withdraw\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawProcessRequest;
use App\Notifications\WithdrawNotification;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\Payment\WithdrawGatewayService;
use App\Services\Payment\WithdrawService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class WithdrawController extends Controller
{
    use CustomValidation;

    public function __construct(
        protected WithdrawService $withdrawService,
        protected UserService $userService,
        protected TransactionService $transactionService,
        protected WalletService $walletService,
        protected WithdrawGatewayService $withdrawGatewayService,
    ){
        $this->middleware('throttle:5,1')->only(['process', 'makeSuccess']);
    }

    /**
     * Display withdrawal methods and history
     */
    public function index(): View
    {
        $setTitle = "Cash out";
        $userId = Auth::id();
        $withdrawMethods = $this->withdrawGatewayService->fetchActiveWithdrawMethod();
        $withdrawLogs = $this->withdrawService->fetchWithdrawLogs(userId: $userId, with: ['user', 'withdrawMethod']);

        return view('user.withdraw.index', compact(
            'setTitle',
            'withdrawMethods',
            'withdrawLogs',
        ));
    }

    /**
     * Process withdrawal request
     */
    public function process(WithdrawProcessRequest $request): RedirectResponse
    {
        try {
            $withdrawMethod = $this->withdrawGatewayService->findById($request->integer('id'));
            if (!$withdrawMethod || $withdrawMethod->status == MethodStatus::INACTIVE->value) {
                return back()->withNotify([['error', 'Withdrawal method not found or inactive.']]);
            }

            $amount = $request->validated('amount');
            $validationError = $this->validateWithdrawal($amount, $withdrawMethod);
            if ($validationError) {
                return back()->withNotify([$validationError]);
            }

            $withdrawLog = $this->withdrawService->save(
                $this->withdrawService->prepParams($withdrawMethod, $request)
            );

            Log::info('Withdrawal initiated', [
                'user_id' => Auth::id(),
                'withdraw_log_id' => $withdrawLog->id,
                'amount' => $amount,
                'method_id' => $withdrawMethod->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect()->route('user.withdraw.preview', $withdrawLog->uid);

        } catch (\Exception $e) {
            Log::error('Withdrawal process failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip_address' => $request->ip()
            ]);

            return back()->withNotify([['error', 'An error occurred while processing your withdrawal request. Please try again.']]);
        }
    }

    /**
     * Validate withdrawal request
     */
    private function validateWithdrawal(float $amount, $withdrawMethod): ?array
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet) {
            return ['error', 'Wallet not found. Please contact support.'];
        }

        $charges = $this->calculateCharges($amount, $withdrawMethod);
        $totalRequired = $amount + $charges['charge'];

        if ($totalRequired > $wallet->primary_balance) {
            return ['error', 'Insufficient wallet balance. Required: ' . getCurrencySymbol() . shortAmount($totalRequired) . ', Available: ' . getCurrencySymbol() . shortAmount($wallet->primary_balance)];
        }

        return $this->withdrawService->validateWithdrawalAmount($amount, $withdrawMethod, $wallet);
    }

    /**
     * Calculate withdrawal charges
     */
    private function calculateCharges(float $amount, $withdrawMethod): array
    {
        $charge = $withdrawMethod->fixed_charge + ($amount * $withdrawMethod->percent_charge / 100);

        return [
            'charge' => $charge,
            'after_charge' => $amount - $charge,
            'total_deducted' => $amount,
        ];
    }

    /**
     * Show withdrawal preview with security checks
     */
    public function preview(string $uid): View | RedirectResponse
    {
        $withdrawLog = $this->withdrawService->findByUidWithdrawLog($uid);
        if (!$withdrawLog) {
            Log::warning('Withdrawal preview - Log not found', [
                'uid' => $uid,
                'user_id' => Auth::id(),
                'ip_address' => request()->ip()
            ]);
            abort(404, 'Withdrawal request not found');
        }

        if ($withdrawLog->user_id != Auth::id()) {
            Log::warning('Unauthorized withdrawal preview attempt', [
                'user_id' => Auth::id(),
                'withdraw_log_id' => $withdrawLog->id,
                'actual_user_id' => $withdrawLog->user_id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            abort(404, 'Withdrawal request not found');
        }

        if ($withdrawLog->status != Status::INITIATED->value) {
            Log::info('Withdrawal preview - Invalid status', [
                'withdraw_log_id' => $withdrawLog->id,
                'current_status' => $withdrawLog->status,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('user.withdraw.index')
                ->with('notify', [['error', 'This withdrawal request has already been processed.']]);
        }

        $setTitle = 'Withdraw preview';
        return view('user.withdraw.preview', compact(
            'setTitle',
            'withdrawLog',
            'uid',
        ));
    }

    /**
     * Process withdrawal confirmation with enhanced security
     */
    public function makeSuccess(Request $request, string $uid): RedirectResponse
    {
        try {
            $withdrawLog = $this->withdrawService->findByUidWithdrawLog($uid);

            if (!$withdrawLog) {
                Log::warning('Withdrawal confirmation - Log not found', [
                    'uid' => $uid,
                    'user_id' => Auth::id(),
                    'ip_address' => $request->ip()
                ]);
                abort(404, 'Withdrawal request not found');
            }

            if ($withdrawLog->user_id != Auth::id()) {
                Log::warning('Unauthorized withdrawal confirmation attempt', [
                    'user_id' => Auth::id(),
                    'withdraw_log_id' => $withdrawLog->id,
                    'actual_user_id' => $withdrawLog->user_id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);
                abort(404, 'Withdrawal request not found');
            }

            if ($withdrawLog->status != Status::INITIATED->value) {
                Log::info('Withdrawal confirmation - Invalid status', [
                    'withdraw_log_id' => $withdrawLog->id,
                    'current_status' => $withdrawLog->status,
                    'user_id' => Auth::id()
                ]);

                return redirect()->route('user.withdraw.index')
                    ->with('notify', [['error', 'This withdrawal request has already been processed.']]);
            }

            $gateway = $withdrawLog->withdrawMethod;
            if (!$gateway || $gateway->status == MethodStatus::INACTIVE->value) {
                Log::warning('Withdrawal confirmation - Gateway unavailable', [
                    'withdraw_log_id' => $withdrawLog->id,
                    'gateway_id' => $gateway?->id,
                    'gateway_status' => $gateway?->status,
                    'user_id' => Auth::id()
                ]);

                return redirect()->route('user.withdraw.index')
                    ->with('notify', [['error', 'Withdrawal method is no longer available.']]);
            }

            if (!empty($gateway->parameter)) {
                $this->validate($request, $this->parameterValidation((array)$gateway->parameter));
            }

            $this->processWithdrawal($withdrawLog, $gateway, $request);
            $withdrawLog->notify(new WithdrawNotification(NotificationType::REQUESTED));
            Log::info('Withdrawal processed successfully', [
                'user_id' => Auth::id(),
                'withdraw_log_id' => $withdrawLog->id,
                'amount' => $withdrawLog->amount,
                'final_amount' => $withdrawLog->final_amount,
                'ip_address' => $request->ip()
            ]);

            return redirect(route('user.withdraw.index'))
                ->with('notify', [['success', 'Withdrawal request submitted successfully. You will be notified once processed.']]);

        } catch (ValidationException $e) {
            Log::warning('Withdrawal confirmation - Validation failed', [
                'user_id' => Auth::id(),
                'withdraw_log_uid' => $uid,
                'errors' => $e->errors(),
                'ip_address' => $request->ip()
            ]);

            return back()->withErrors($e->errors())
                ->with('notify', [['error', 'Please check the form and try again.']]);

        } catch (\Exception $e) {
            Log::error('Withdrawal confirmation failed', [
                'user_id' => Auth::id(),
                'withdraw_log_uid' => $uid,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip_address' => $request->ip()
            ]);

            return back()->with('notify', [['error', 'An error occurred while processing your withdrawal. Please try again.']]);
        }
    }

    /**
     * Process withdrawal execution
     */
    private function processWithdrawal($withdrawLog, $gateway, Request $request): void
    {
        $wallet = Auth::user()->wallet;

        if (!$wallet) {
            throw new \Exception('Primary wallet not found');
        }

        // Final balance check before processing
        $totalDeduction = $withdrawLog->amount + $withdrawLog->charge;
        if ($totalDeduction > $wallet->primary_balance) {
            throw new \Exception('Insufficient primary wallet balance. Required: ' . getCurrencySymbol() . shortAmount($totalDeduction) . ', Available: ' . getCurrencySymbol() . shortAmount($wallet->primary_balance));
        }

        // Execute withdrawal through service
        $this->withdrawService->execute($withdrawLog, $gateway, $wallet, $request);
    }

    /**
     * Get withdrawal statistics (for API or dashboard)
     */
    public function getStats(): array
    {
        $userId = Auth::id();
        $stats = $this->withdrawService->getApiReport($userId);

        return [
            'total_withdrawn' => $stats['total'],
            'pending_withdrawals' => $stats['pending'],
            'rejected_withdrawals' => $stats['rejected'],
            'total_charges' => $stats['charge'],
            'available_balance' => Auth::user()->wallet->primary_balance ?? 0
        ];
    }
}
