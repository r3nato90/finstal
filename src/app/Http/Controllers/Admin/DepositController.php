<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommissionType;
use App\Enums\Payment\Deposit\Status;
use App\Enums\Payment\NotificationType;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use App\Notifications\DepositNotification;
use App\Services\Investment\CommissionService;
use App\Services\Payment\DepositService;
use App\Services\Payment\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class DepositController extends Controller
{
    public function __construct(
        protected DepositService $depositService,
        protected PaymentService $paymentService,
        protected CommissionService $commissionService,
    )
    {

    }

    /**
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View
    {
        $setTitle = __('Deposit Logs Management');

        $search = request()->get('search');
        $gateway = request()->get('gateway');
        $status = request()->get('status');
        $walletType = request()->get('wallet_type');
        $sortField = request()->get('sort_field', 'created_at');
        $sortDirection = request()->get('sort_direction', 'desc');

        $query = Deposit::with(['user', 'gateway']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('trx', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('fullname', 'like', "%{$search}%");
                    });
            });
        }

        if ($gateway) {
            $query->where('payment_gateway_id', $gateway);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($walletType) {
            $query->where('wallet_type', $walletType);
        }

        $allowedSortFields = ['trx', 'amount', 'charge', 'final_amount', 'status', 'created_at'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'desc' ? 'desc' : 'asc');
        } else {
            $query->latest();
        }

        $perPage = (int) request()->get('per_page', 20);
        $deposits = $query->paginate($perPage)->appends(request()->all());

        $gateways = PaymentGateway::select('id', 'name')
            ->where('status', 1)
            ->get()
            ->pluck('name', 'id');

        $stats = $this->getDepositStats();

        $filters = [
            'search' => $search,
            'gateway' => $gateway,
            'status' => $status,
            'wallet_type' => $walletType,
            'sort_field' => $sortField,
            'sort_direction' => $sortDirection,
        ];

        return view('admin.deposit.index', compact(
            'deposits',
            'gateways',
            'stats',
            'filters',
            'setTitle'
        ));
    }

    /**
     * Get deposit statistics
     */
    private function getDepositStats(): array
    {
        return [
            'totalDeposits' => Deposit::count(),
            'initiatedDeposits' => Deposit::where('status', Status::INITIATED->value)->count(),
            'pendingDeposits' => Deposit::where('status', Status::PENDING->value)->count(),
            'successDeposits' => Deposit::where('status', Status::SUCCESS->value)->count(),
            'cancelledDeposits' => Deposit::where('status', Status::CANCEL->value)->count(),
            'totalDepositAmount' => Deposit::where('status', Status::SUCCESS->value)->sum('amount'),
            'totalCharges' => Deposit::where('status', Status::SUCCESS->value)->sum('charge'),
            'totalFinalAmount' => Deposit::where('status', Status::SUCCESS->value)->sum('final_amount'),
        ];
    }

    /**
     * @param int $id
     * @return View
     */
    public function details(int $id): View
    {
        $setTitle = __('admin.deposit.page_title.details');
        $deposit = $this->depositService->findById($id);

        if(!$deposit){
            abort(404);
        }

        return view('admin.deposit.details', compact(
            'setTitle',
            'deposit',
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

        $deposit = $this->depositService->findById($id);

        if(!$deposit){
            abort(404);
        }

        if($request->input('status') == Status::SUCCESS->value){
            $this->paymentService->successPayment($deposit->trx);
        }else{
            $deposit->status = Status::CANCEL->value;
            $deposit->save();

            $deposit->notify(new DepositNotification(NotificationType::REJECTED));
        }

        return back()->with('notify', [['success', __('admin.deposit.notify.update.success')]]);
    }


    /**
     * @return View
     */
    public function commissions(): View
    {
        $setTitle = __('Referral Deposit Commission Rewards');
        $depositCommissions = $this->commissionService->getCommissionsOfType(CommissionType::DEPOSIT, ['user']);

        return view('admin.deposit.commission', compact(
            'setTitle',
            'depositCommissions'
        ));
    }

    public function download(string $fileName): bool|int
    {
        $fileName = base64_decode($fileName);
        $fullPath = 'assets/files/' . $fileName;

        if (!file_exists($fullPath)) {
            return false;
        }

        $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
        $mimetype = mime_content_type($fullPath);

        header("Content-Disposition: attachment; filename=\"" . Str::random() . ".$ext\"");
        header("Content-Type: $mimetype");
        header("Content-Length: " . filesize($fullPath));

        readfile($fullPath);
        return true;
    }


}
