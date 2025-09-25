<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use App\Enums\Payment\GatewayCode;
use App\Services\Payment\Gateway\FlutterWaveGateway;
use App\Services\Payment\Gateway\PaypalGateway;
use App\Services\Payment\Gateway\PayStackGateway;
use App\Services\Payment\Gateway\StripeGateway;
use App\Services\Payment\Gateway\TraditionalGateway;

class PaymentGatewayFactory
{
    public static function create(string $gatewayName): PaymentGatewayInterface {
        return match ($gatewayName) {
            GatewayCode::STRIPE->value => new StripeGateway(),
            GatewayCode::PAYPAL->value => new PaypalGateway(),
            GatewayCode::FLUTTER_WAVE->value => new FlutterWaveGateway(),
            GatewayCode::PAY_STACK->value => new PayStackGateway(),
            default => new TraditionalGateway(),
        };
    }

}
