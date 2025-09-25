<?php

namespace App\Http\Controllers\Payment;

use App\Concerns\CustomValidation;
use App\Concerns\UploadedFile;
use App\Enums\CommissionType;
use App\Enums\Payment\Deposit\Status;
use App\Enums\Payment\GatewayCode;
use App\Enums\Payment\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentProcessRequest;
use App\Notifications\DepositNotification;
use App\Services\Investment\CommissionService;
use App\Services\Payment\DepositService;
use App\Services\Payment\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Throwable;

class PaymentController extends Controller
{
    use CustomValidation, UploadedFile;

    public function __construct(
        protected PaymentService $paymentService,
        protected DepositService $depositService,
        protected CommissionService $commissionService,
    ){

    }

    public function index(): View
    {
        $setTitle = "Payment Gateway";
        $gateways = $this->paymentService->fetchActivePaymentGateways();
        $deposits = $this->depositService->getUserDepositByPaginated((int)Auth::id(), ['gateway'], Status::INITIATED->value);

        return view('payment.process', compact(
            'setTitle',
            'gateways',
            'deposits',
        ));
    }

    public function commission(): View
    {
        $setTitle = "Referral Deposit Commission Rewards";
        $depositCommissions = $this->commissionService->getCommissionsOfType(CommissionType::DEPOSIT, ['user']);

        return view('payment.commission', compact(
            'setTitle',
            'depositCommissions',
        ));
    }

    public function process(PaymentProcessRequest $request): RedirectResponse
    {
        try {
            $code = $this->sanitizeInput($request->input('code'));
            $amount = (float) $request->input('amount');

            if ($amount <= 0) {
                return back()->with('notify', [['error', 'Invalid amount provided']]);
            }

            $gateway = $this->paymentService->findByCode($code);
            if (!$gateway) {
                return back()->with('notify', [['error', 'Invalid payment gateway']]);
            }

            if ($amount < $gateway->minimum || $amount > $gateway->maximum) {
                return back()->with('notify', [['error', 'The investment amount should be between ' . getCurrencySymbol().shortAmount($gateway->minimum) . ' and ' . getCurrencySymbol().shortAmount($gateway->maximum)]]);
            }

            $payment = $this->paymentService->makePayment($gateway, $request, $amount);
            if(is_null($payment)){
                return back()->with('notify', [['warning', e($gateway->name) . " Api has issues, please try again later"]]);
            }
            return redirect()->to($payment);

        }catch (\Exception $exception){
            Log::error('Payment process error: ' . $exception->getMessage(), [
                'user_id' => Auth::id(),
                'request_data' => $request->except(['password', 'token'])
            ]);
            return back()->with('notify', [['warning', 'Payment processing failed. Please try again.']]);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ApiErrorException|Throwable
     */
    public function success(Request $request): RedirectResponse
    {
        $trxId = null;
        $gatewayCode = $this->sanitizeInput($request->query('gateway_code'));

        if (!in_array($gatewayCode, [
            GatewayCode::STRIPE->value,
            GatewayCode::PAYPAL->value,
            GatewayCode::FLUTTER_WAVE->value,
            GatewayCode::PAY_STACK->value
        ])) {
            Log::warning('Invalid gateway code provided', ['gateway_code' => $gatewayCode, 'user_id' => Auth::id()]);
            return redirect()->route('user.dashboard')->with('notify', [['error', 'Invalid payment gateway']]);
        }

        try {
            if($gatewayCode == GatewayCode::STRIPE->value){
                $paymentIntent = $this->sanitizeInput($request->query('payment_intent'));
                if (!$paymentIntent) {
                    return back()->with('notify', [['error', "Invalid payment intent"]]);
                }

                $paymentGateway = $this->paymentService->findByCode(GatewayCode::STRIPE->value);
                Stripe::setApiKey(Arr::get($paymentGateway->parameter,'secret_key'));

                $paymentIntentObj = Session::retrieve($paymentIntent);
                $trxId = $paymentIntentObj->metadata['transaction_id'] ?? '';
            }

            if($gatewayCode == GatewayCode::PAYPAL->value){
                $token = $this->sanitizeInput($request->input('token'));
                $trxQuery = $this->sanitizeInput($request->query('trx'));

                if (!$token || !$trxQuery) {
                    return back()->with('notify', [['error', "Invalid PayPal payment data"]]);
                }

                $provider = new PayPalClient;
                $provider->setApiCredentials(config('paypal'));
                $provider->getAccessToken();
                $response = $provider->capturePaymentOrder($token);
                if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                    $trxId = $trxQuery;
                }
            }

            if($gatewayCode == GatewayCode::COINBASE_COMMERCE->value){
                $trxId = $this->sanitizeInput($request->query('trx'));
            }

            if($gatewayCode == GatewayCode::NOW_PAYMENT->value){
                $trxId = $this->sanitizeInput($request->query('trx'));
            }

            if($gatewayCode == GatewayCode::COIN_GATE->value){
                $trxId = $this->sanitizeInput($request->query('payment_intent'));
            }

            if($gatewayCode == GatewayCode::FLUTTER_WAVE->value){
                $status = $this->sanitizeInput($request->query('status'));
                if ($status == 'successful') {
                    $trxId = $this->sanitizeInput($request->query('trx'));
                }
            }

            if($gatewayCode == GatewayCode::PAY_STACK->value){
                $trxId = $this->sanitizeInput($request->query('trx'));
            }

            if (is_null($trxId) || empty($trxId)) {
                Log::warning('Payment success called with null/empty trxId', [
                    'gateway_code' => $gatewayCode,
                    'user_id' => Auth::id()
                ]);
                return back()->with('notify', [['error', "Something went wrong with the payment"]]);
            }

            $payment = $this->paymentService->successPayment($trxId);

            if (!$payment) {
                Log::error('Payment not found or failed to process', [
                    'trx_id' => $trxId,
                    'gateway_code' => $gatewayCode,
                    'user_id' => Auth::id()
                ]);
                return back()->with('notify', [['error', "Something went wrong with the payment"]]);
            }

            return redirect()->route('user.payment.index')->with('notify', [['success', "Payment has been successful"]]);

        } catch (\Exception $exception) {
            Log::error('Payment success processing error: ' . $exception->getMessage(), [
                'user_id' => Auth::id(),
                'gateway_code' => $gatewayCode,
                'trx_id' => $trxId ?? 'unknown'
            ]);
            return back()->with('notify', [['error', "Payment processing failed"]]);
        }
    }

    /**
     * @return RedirectResponse
     */
    public function cancel(): RedirectResponse
    {
        return redirect()->route('user.dashboard');
    }

    public function preview(Request $request): View
    {
        $gatewayCode = $this->sanitizeInput($request->query('gateway_code'));
        $paymentIntent = $this->sanitizeInput($request->query('payment_intent'));

        if (!$gatewayCode || !$paymentIntent) {
            abort(404);
        }

        $gateway = $this->paymentService->findByCode($gatewayCode);
        $payment = $this->depositService->findByTrxId($paymentIntent);

        if (!$gateway || !$payment) {
            abort(404);
        }

        // Ensure user owns this payment
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        $setTitle = e($gateway->name) . " deposit preview";

        return view('payment.preview', compact(
            'gateway',
            'payment',
            'setTitle'
        ));
    }

    /**
     * @throws ValidationException
     */
    public function traditional(Request $request): RedirectResponse
    {
        $gatewayCode = $this->sanitizeInput($request->input('gateway_code'));
        $paymentIntent = $this->sanitizeInput($request->input('payment_intent'));

        if (!$gatewayCode || !$paymentIntent) {
            abort(400);
        }

        $gateway = $this->paymentService->findByCode($gatewayCode);
        $deposit = $this->depositService->findByTrxId($paymentIntent);

        if(!$gateway || !$deposit){
            abort(404);
        }

        // Ensure user owns this deposit
        if ($deposit->user_id !== Auth::id()) {
            abort(403);
        }

        $this->validate($request, $this->parameterValidation((array)$gateway->parameter));

        // Sanitize metadata before storing
        $metadata = $this->paymentService->parameterStoreData((array)$gateway->parameter);
        $deposit->meta = $this->sanitizeMetadata($metadata);
        $deposit->save();

        $this->paymentService->successPayment($deposit->trx);

        $deposit->notify(new DepositNotification(NotificationType::REQUESTED));
        return redirect()->route('user.payment.index')->with('notify', [['success', "Payment has been successful"]]);
    }

    /**
     * Sanitize input to prevent XSS
     */
    private function sanitizeInput($input): ?string
    {
        if (is_null($input)) {
            return null;
        }

        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitize metadata array
     */
    private function sanitizeMetadata(array $metadata): array
    {
        $sanitized = [];
        foreach ($metadata as $key => $value) {
            $sanitizedKey = $this->sanitizeInput($key);
            if (is_array($value)) {
                $sanitized[$sanitizedKey] = $this->sanitizeMetadata($value);
            } else {
                $sanitized[$sanitizedKey] = $this->sanitizeInput($value);
            }
        }
        return $sanitized;
    }
}
