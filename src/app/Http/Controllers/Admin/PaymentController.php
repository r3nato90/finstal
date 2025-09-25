<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaymentGateway;
use App\Services\Payment\PaymentGatewayService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    protected $paymentGatewayService;

    public function __construct(PaymentGatewayService $paymentGatewayService)
    {
        $this->paymentGatewayService = $paymentGatewayService;
    }

    // Função para exibir gateways de pagamento
    public function index()
    {
        $gateways = $this->paymentGatewayService->getGateways(); // Chama o serviço para pegar todos os gateways
        return view('admin.payment.gateway.index', compact('gateways'));
    }

    // Função para processar o pagamento com o gateway selecionado
    public function processPayment(Request $request)
    {
        $gatewayCode = $request->input('gateway_code'); // Recebe o código do gateway
        $paymentData = $request->only(['amount', 'currency', 'transaction_id']); // Dados do pagamento

        // Verifica qual gateway foi selecionado e chama a API correspondente
        switch ($gatewayCode) {
            case 'paypal':
                return $this->processPaypalPayment($paymentData);
            case 'paghiper':
                return $this->processPagHiperPayment($paymentData);
            case 'gestaopay':
                return $this->processGestaoPayPayment($paymentData);
            case 'bspay':
                return $this->processBsPayPayment($paymentData);
            default:
                return response()->json(['error' => 'Invalid payment gateway'], 400);
        }
    }

    // Função para processar o pagamento via PayPal
    private function processPaypalPayment($paymentData)
    {
        // Lógica para integrar com a API do PayPal
        $response = $this->paymentGatewayService->processPaypal($paymentData);
        return $response;
    }

    // Função para processar o pagamento via PagHiper
    private function processPagHiperPayment($paymentData)
    {
        // Lógica para integrar com a API do PagHiper
        $response = $this->paymentGatewayService->processPagHiper($paymentData);
        return $response;
    }

    // Função para processar o pagamento via GestaoPay
    private function processGestaoPayPayment($paymentData)
    {
        // Lógica para integrar com a API do GestaoPay
        $response = $this->paymentGatewayService->processGestaoPay($paymentData);
        return $response;
    }

    // Função para processar o pagamento via BsPay
    private function processBsPayPayment($paymentData)
    {
        // Lógica para integrar com a API do BsPay
        $response = $this->paymentGatewayService->processBsPay($paymentData);
        return $response;
    }
}
