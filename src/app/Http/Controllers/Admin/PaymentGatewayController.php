<?php

namespace App\Http\Controllers\Admin;

use App\Concerns\UploadedFile;
use App\Enums\Payment\GatewayType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentGatewayRequest;
use App\Services\Payment\PaymentGatewayService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Transaction;  // Para salvar ou atualizar transações

class PaymentGatewayController extends Controller
{
    use UploadedFile;

    public function __construct(protected PaymentGatewayService $paymentGatewayService)
    {
    }

    public function index(): View
    {
        $setTitle = __('admin.payment_processor.page_title.automatic.index');
        $gateways = $this->paymentGatewayService->getGatewayByPaginate(GatewayType::AUTOMATIC);

        return view('admin.payment_gateway.index', compact(
            'setTitle',
            'gateways'
        ));
    }

    public function edit(int|string $id): View
    {
        $setTitle = __('admin.payment_processor.page_title.automatic.edit');
        $paymentGateway = $this->paymentGatewayService->findById($id);

        return view('admin.payment_gateway.edit', compact(
            'setTitle',
            'paymentGateway'
        ));
    }

    /**
     * @param PaymentGatewayRequest $request
     * @param string|int $id
     * @return RedirectResponse
     */
    public function update(PaymentGatewayRequest $request, string|int $id): RedirectResponse
    {
        $gateway = $this->paymentGatewayService->findById($id);
        if(blank($gateway)) abort(404);

        $prepParams = $this->paymentGatewayService->prepParams($request, GatewayType::AUTOMATIC);

        $parameter = [];
        foreach ($gateway->parameter as $key => $value) {
            $parameter[$key] = $request->input("method.{$key}");
        }

        $fileName = is_null($prepParams['file']) ? $gateway->file : $prepParams['file'];
        Arr::set($prepParams, 'code', $gateway->code);
        Arr::set($prepParams, 'name', $gateway->name);
        Arr::set($prepParams, 'parameter', $parameter);
        Arr::set($prepParams, 'file', $fileName);

        // Atualiza o gateway
        $gateway->update($prepParams);

        return back()->with('notify', [['success', __('Payment gateway has been updated')]]);
    }

    /**
     * Método para processar o callback do pagamento após a conclusão.
     */
    public function handlePaymentCallback(Request $request)
    {
        $paymentStatus = $request->input('status');
        $orderId = $request->input('order_id');
        $sessionId = $request->input('session_id');  // O ID da sessão de pagamento da VersellPay

        // Verifique o status do pagamento e atualize o pedido ou transação conforme necessário
        if ($paymentStatus == 'completed') {
            // Localize a transação associada ao pedido usando o order_id
            $transaction = Transaction::where('order_id', $orderId)->first();

            if ($transaction) {
                // Atualiza o status da transação para 'concluída'
                $transaction->status = 'completed';
                $transaction->payment_session_id = $sessionId;  // Salve o session_id para controle
                $transaction->save();

                // Retorne uma resposta de sucesso para a VersellPay
                return response()->json(['status' => 'success']);
            }
        }

        // Caso o pagamento não tenha sido completado ou outro erro, marque como falhado
        return response()->json(['status' => 'failed']);
    }
}
