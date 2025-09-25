<?php

namespace App\Services\Payments;

use Illuminate\Support\Facades\Http;

class VersellPayGateway extends Gateway
{
    public function createPixCharge(float $usdValue, string $payerName, string $payerCpf, string $referenceId): array
    {
        $amount = $this->applyUsdMultiplier($usdValue);

        // Ajuste conforme https://docs.versellpay.com/
        $resp = Http::post('https://api.versellpay.com/pix/charge', [
            'reference' => $referenceId,
            'amount'    => $amount,
            'payer'     => ['name' => $payerName, 'cpf' => $payerCpf],
            'callback'  => $this->config['pix']['callback_url'] ?? '',
        ]);

        return $resp->json();
    }

    public function createUsdtCharge(float $usdValue, string $referenceId): array
    {
        // Ajuste conforme https://docs.versellpay.com/
        $resp = Http::post('https://api.versellpay.com/usdt/trc20/charge', [
            'reference' => $referenceId,
            'amount'    => $usdValue,
            'callback'  => $this->config['usdt_trc20']['callback_url'] ?? '',
        ]);

        return $resp->json();
    }
}
