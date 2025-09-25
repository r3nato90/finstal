<?php

namespace App\Services\Payments;

use Illuminate\Support\Facades\Http;

class OndapayGateway extends Gateway
{
    public function createPixCharge(float $usdValue, string $payerName, string $payerCpf, string $referenceId): array
    {
        $amount = $this->applyUsdMultiplier($usdValue);

        // Ajuste conforme https://api.ondapay.app/docs/api
        $resp = Http::post('https://api.ondapay.app/v1/pix/charges', [
            'reference' => $referenceId,
            'amount'    => $amount,
            'payer'     => ['name' => $payerName, 'cpf' => $payerCpf],
            'callback'  => $this->config['pix']['callback_url'] ?? '',
        ]);

        return $resp->json();
    }

    public function createUsdtCharge(float $usdValue, string $referenceId): array
    {
        return ['note' => 'Implementar USDT Ondapay conforme docs oficiais.'];
    }
}
