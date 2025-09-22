<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\Matrix\PinStatus;
use App\Enums\Status;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PinGenerateRequest;
use App\Http\Requests\PinRechargeRequest;
use App\Http\Resources\PinResource;
use App\Models\Setting;
use App\Services\Payment\DepositService;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\Payment\WithdrawService;
use App\Services\PinGenerateService;
use App\Services\SettingService;
use App\Services\UserService;
use App\Utilities\Api\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class RechargeController extends Controller
{
    public function __construct(
        protected PinGenerateService $pinGenerateService,
        protected WalletService $walletService,
        protected TransactionService $transactionService,
        protected WithdrawService $withdrawService,
        protected DepositService $depositService,
        protected UserService $userService
    ) {

    }

    public function index(): JsonResponse
    {
        $pins = $this->pinGenerateService->getPinsByPaginate(userId: Auth::id());
        return ApiJsonResponse::success('User info fetched successfully', [
            'pins' => PinResource::collection($pins),
            'pin_meta' => paginateMeta($pins),
        ]);

    }

    public function save(PinRechargeRequest $request): JsonResponse
    {
        $setting = SettingService::getSetting();
        if (Setting::get('module_e_pin', 1) != \App\Enums\Status::ACTIVE->value){
            return ApiJsonResponse::error('E-pin recharge currently off');
        }

        $pinNumber = $this->pinGenerateService->findByPinNumber($request->input('pin_number'));

        if (!$pinNumber) {
            return ApiJsonResponse::error('Recharge E-pin not found');
        }

        if ($pinNumber->status == PinStatus::USED->value) {
            return ApiJsonResponse::error('Recharge E-pin already used.');
        }

        $user = Auth::user();
        $wallet = $user->wallet;

        $wallet->primary_balance += $pinNumber->amount;
        $wallet->save();

        $pinNumber->status = PinStatus::USED->value;
        $pinNumber->save();

        $wallet->refresh();
        $user = $this->userService->findById($user->id);
        $this->userService->transactionProcess(
            $user,
            Type::PLUS,
            new \Illuminate\Http\Request([
                'wallet_type' => WalletType::PRIMARY->value,
                'amount' => $pinNumber->amount,
            ]),
            $wallet,
            'Top up E-Pin with amount ' . getCurrencySymbol() . shortAmount($pinNumber->amount),
        );
        return ApiJsonResponse::success('Balance has been added to your primary wallet');
    }


    public function generate(PinGenerateRequest $request): JsonResponse
    {
        $ePinCharge = Setting::get('e_pin_charge', 1);
        $moduleEPin = Setting::get('module_e_pin', 1);
        if($moduleEPin == Status::INACTIVE->value){
            return ApiJsonResponse::error('E-pin generate currently off');
        }

        $user = Auth::user();
        $wallet = $user->wallet;
        $charge = (($request->input('amount') / 100) * $ePinCharge);
        $account = $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet);
        $amount = $request->input('amount');

        if($amount + $charge > Arr::get($account, 'balance')){
            return ApiJsonResponse::error("Your primary account balance is insufficient for generate pin.");
        }

        $params = $this->pinGenerateService->prepParams(1,$amount - $charge, $charge, 'Generate an E-pin worth '.getCurrencySymbol().shortAmount($amount));
        foreach ($params as &$param) {
            $param = Arr::add($param, 'set_user_id', $user->id);
        }
        $wallet->primary_balance -= $request->input('amount');
        $wallet->save();
        $wallet->refresh();

        $this->pinGenerateService->save($params);
        $user = $this->userService->findById($user->id);
        $this->userService->transactionProcess(
            $user,
            Type::MINUS,
            new \Illuminate\Http\Request([
                'wallet_type' => WalletType::PRIMARY->value,
                'amount' => $amount,
            ]),
            $wallet,
            'Generate an E-pin worth '.getCurrencySymbol().shortAmount($amount),
            $charge
        );

        return ApiJsonResponse::success("E-pin generate successfully ");
    }
}
