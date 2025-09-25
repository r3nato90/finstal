<?php

namespace App\Services\Payments;

use Illuminate\Support\Facades\Http;

class BSPayGateway extends Gateway
{
    public function createPixCharge(float $usdValue, string $payerName, string $payerCpf, string $referenceId): array
    {
        $amount = $this->applyUsdMultiplier($usdValue);

        // Ajuste conforme https://bspay.readme.io/reference/come%C3%A7ando
        $resp = Http::post('https://api.bspay.com.br/pix/charge', [
            'reference' => $referenceId,
            'amount'    => $amount,
            'payer'     => ['name' => $payerName, 'cpf' => $payerCpf],
            'callback'  => $this->config['pix']['callback_url'] ?? '',
        ]);

        return $resp->json();
    }

    public function createUsdtCharge(float $usdValue, string $referenceId): array
    {
        return ['error' => 'USDT não suportado pela BSPay.'];
    }
}
