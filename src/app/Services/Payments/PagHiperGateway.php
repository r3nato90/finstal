<?php

namespace App\Services\Payments;

use Illuminate\Support\Facades\Http;

class PagHiperGateway extends Gateway
{
    public function createPixCharge(float $usdValue, string $payerName, string $payerCpf, string $referenceId): array
    {
        $amount = $this->applyUsdMultiplier($usdValue);

        // Ajuste conforme https://dev.paghiper.com/reference/objetivo
        $resp = Http::post('https://pix.paghiper.com/invoice/create/', [
            'order_id'        => $referenceId,
            'payer_cpf_cnpj'  => $payerCpf,
            'payer_name'      => $payerName,
            'value'           => number_format($amount, 2, '.', ''),
            'notification_url'=> $this->config['pix']['callback_url'] ?? '',
        ]);

        return $resp->json();
    }

    public function createUsdtCharge(float $usdValue, string $referenceId): array
    {
        return ['error' => 'USDT não suportado pela PagHiper.'];
    }
}
