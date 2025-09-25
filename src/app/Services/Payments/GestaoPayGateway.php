<?php

namespace App\Services\Payments;

use Illuminate\Support\Facades\Http;

class GestaoPayGateway extends Gateway
{
    public function createPixCharge(float $usdValue, string $payerName, string $payerCpf, string $referenceId): array
    {
        $amount = $this->applyUsdMultiplier($usdValue);

        // Ajuste conforme https://app.gestaopay.com.br/docs/intro/first-steps
        $resp = Http::post('https://api.gestaopay.com.br/pix/charge', [
            'reference' => $referenceId,
            'amount'    => $amount,
            'payer'     => ['name' => $payerName, 'cpf' => $payerCpf],
            'callback'  => $this->config['pix']['callback_url'] ?? '',
        ]);

        return $resp->json();
    }

    public function createUsdtCharge(float $usdValue, string $referenceId): array
    {
        return ['error' => 'USDT não suportado pela GestãoPay.'];
    }
}
