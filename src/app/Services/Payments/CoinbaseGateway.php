<?php

namespace App\Services\Payments;

class CoinbaseGateway extends Gateway
{
    public function createPixCharge(float $usdValue, string $payerName, string $payerCpf, string $referenceId): array
    {
        return ['error' => 'PIX não suportado pela Coinbase.'];
    }

    public function createUsdtCharge(float $usdValue, string $referenceId): array
    {
        // Ajuste conforme https://docs.cdp.coinbase.com/exchange/introduction/welcome
        return ['note' => 'Implementar recebimento USDT TRC-20 via Coinbase (conforme docs oficiais).'];
    }
}
