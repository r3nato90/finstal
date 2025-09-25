<?php

namespace App\Services\Payments;

use App\Models\PaymentProvider;

abstract class Gateway
{
    protected PaymentProvider $provider;
    protected array $config;

    public function __construct(PaymentProvider $provider)
    {
        $this->provider = $provider;
        $this->config   = $provider->config ?? [];
    }

    abstract public function createPixCharge(float $usdValue, string $payerName, string $payerCpf, string $referenceId): array;

    abstract public function createUsdtCharge(float $usdValue, string $referenceId): array;

    protected function applyUsdMultiplier(float $usdValue): float
    {
        $mult = (float)($this->config['pix']['usd_multiplier'] ?? 1.00);
        return $usdValue * ($mult > 0 ? $mult : 1.00);
    }
}
