<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Payment\NotificationType;
use App\Enums\Payment\Withdraw\Status;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Enums\Transaction\Source;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\WithdrawLog;
use App\Models\WithdrawMethod;
use App\Notifications\WithdrawNotification;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\Payment\WithdrawService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class WithdrawController extends Controller
{
    public function __construct(
        protected WithdrawService $withdrawService,
        protected TransactionService $transactionService,
        protected WalletService $walletService,
    ){

    }

    /**
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View
    {
        $setTitle = __('Withdraw Logs Management');

        $search = request()->get('search');
        $method = request()->get('method');
        $status = request()->get('status');
        $currency = request()->get('currency');
        $sortField = request()->get('sort_field', 'created_at');
        $sortDirection = request()->get('sort_direction', 'desc');

        $query = WithdrawLog::with(['user', 'withdrawMethod']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('uid', 'like', "%{$search}%")
                    ->orWhere('trx', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('fullname', 'like', "%{$search}%");
                    });
            });
        }

        if ($method) {
            $query->where('withdraw_method_id', $method);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($currency) {
            $query->where('currency', $currency);
        }

        $allowedSortFields = ['uid', 'trx', 'amount', 'charge', 'final_amount', 'status', 'created_at'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'desc' ? 'desc' : 'asc');
        } else {
            $query->latest();
        }

        $perPage = (int) request()->get('per_page', 20);
        $withdrawLogs = $query->paginate($perPage)->appends(request()->all());

        $withdrawMethods = WithdrawMethod::select('id', 'name')
            ->where('status', 1)
            ->get()
            ->pluck('name', 'id');

        $currencies = WithdrawLog::select('currency')
            ->whereNotNull('currency')
            ->distinct()
            ->get()
            ->pluck('currency', 'currency');

        $stats = $this->getWithdrawStats();

        $filters = [
            'search' => $search,
            'method' => $method,
            'status' => $status,
            'currency' => $currency,
            'sort_field' => $sortField,
            'sort_direction' => $sortDirection,
        ];

        return view('admin.withdraw.index', compact(
            'withdrawLogs',
            'withdrawMethods',
            'currencies',
            'stats',
            'filters',
            'setTitle'
        ));
    }


    /**
     * Get withdraw statistics
     */
    private function getWithdrawStats(): array
    {
        return [
            'totalWithdraws' => WithdrawLog::count(),
            'initiatedWithdraws' => WithdrawLog::where('status', Status::INITIATED->value)->count(),
            'pendingWithdraws' => WithdrawLog::where('status', Status::PENDING->value)->count(),
            'successWithdraws' => WithdrawLog::where('status', Status::SUCCESS->value)->count(),
            'cancelledWithdraws' => WithdrawLog::where('status', Status::CANCEL->value)->count(),
            'totalWithdrawAmount' => WithdrawLog::where('status', Status::SUCCESS->value)->sum('amount'),
            'totalCharges' => WithdrawLog::where('status', Status::SUCCESS->value)->sum('charge'),
            'totalFinalAmount' => WithdrawLog::where('status', Status::SUCCESS->value)->sum('final_amount'),
            'totalAfterCharge' => WithdrawLog::where('status', Status::SUCCESS->value)->sum('after_charge'),
        ];
    }

    /**
     * @param int $id
     * @return View
     */
    public function details(int $id): View
    {
        $setTitle = __('admin.withdraw.page_title.details');
        $withdraw = $this->withdrawService->findById($id);

        if(!$withdraw){
            abort(404);
        }

        return view('admin.withdraw.details', compact(
            'setTitle',
            'withdraw',
        ));
    }

    /**
     * @param Request $request
     * @param int|string $id
     * @return RedirectResponse
     */
    public function update(Request $request, int|string $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(Status::SUCCESS->value, Status::CANCEL->value)]
        ]);

        $withdraw = $this->withdrawService->findById($id);
        if($withdraw->wallet_type == \App\Enums\Wallet\WalletType::ICO->value){
            $wallet = $withdraw?->icoWallet;
        }else{
            $wallet = $withdraw?->user?->wallet;
        }

        if(!$withdraw || !$wallet || $withdraw->status != Status::PENDING->value){
            abort(404);
        }

        if($request->input('status') == Status::CANCEL->value){
            DB::transaction(function () use ($withdraw, $wallet) {

                if($withdraw->wallet_type == \App\Enums\Wallet\WalletType::ICO->value){
                    $wallet->balance += $withdraw->ico_token;
                    $wallet->save();

                    $wallet->fresh();
                    Transaction::create([
                        'user_id' =>  Auth::id(),
                        'amount' => $withdraw->ico_token,
                        'post_balance' =>$wallet->balance,
                        'charge' => 0,
                        'trx' => $withdraw->trx,
                        'type' => Type::PLUS->value,
                        'wallet_type' => 5,
                        'source' => Source::ICO->value,
                        'details' => 'Withdrawal canceled: Amount returned to user\'s ico wallet.',
                        'wallet_mode' => $withdraw->wallet_mode,
                        'ico_wallet_id' => $withdraw->ico_wallet_id,
                    ]);
                }else{
                    $wallet->primary_balance += $withdraw->after_charge;
                    $wallet->save();

                    $this->transactionService->save($this->transactionService->prepParams([
                        'user_id' => $withdraw->user_id,
                        'amount' => $withdraw->amount,
                        'wallet' => $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
                        'charge' => $withdraw->charge,
                        'trx' => $withdraw->trx,
                        'type' => Type::PLUS->value,
                        'wallet_type' => WalletType::PRIMARY->value,
                        'source' => Source::ALL->value,
                        'details' => 'Withdrawal canceled: Amount returned to user\'s primary account.',
                    ]));
                }

            });
            $withdraw->notify(new WithdrawNotification(NotificationType::REJECTED));
        }else{
            $withdraw->notify(new WithdrawNotification(NotificationType::APPROVED));
        }

        $withdraw->status = $request->input('status');
        $withdraw->details = $request->input('details');
        $withdraw->save();

        return back()->with('notify', [['success', __('admin.withdraw.notify.update.success')]]);
    }
}
