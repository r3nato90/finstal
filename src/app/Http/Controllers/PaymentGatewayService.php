<?php

namespace App\Services\Payments;

use App\Models\PaymentProvider;
use Illuminate\Support\Facades\Http;

class PaymentGatewayService
{
    public function createPixCharge(float $usdValue, string $payerName, string $payerCpf, string $referenceId, PaymentProvider $provider)
    {
        $amount = $this->applyUsdMultiplier($usdValue, $provider);
        $response = Http::post($provider->config['pix']['callback_url'], [
            'amount' => $amount,
            'payer'  => ['name' => $payerName, 'cpf' => $payerCpf],
            'reference' => $referenceId,
        ]);

        return $response->json();
    }

    public function createUsdtCharge(float $usdValue, string $referenceId, PaymentProvider $provider)
    {
        $response = Http::post($provider->config['usdt_trc20']['callback_url'], [
            'amount'   => $usdValue,
            'reference' => $referenceId,
        ]);

        return $response->json();
    }

    protected function applyUsdMultiplier(float $usdValue, PaymentProvider $provider): float
    {
        $multiplier = $provider->config['pix']['usd_multiplier'] ?? 1.00;
        return $usdValue * $multiplier;
    }
}
