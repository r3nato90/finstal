<?php

namespace App\Enums\Payment;

enum GatewayName: string
{
    case STRIPE = 'stripe';
    case PAYPAL = 'paypal';
    case PAY_STACK = 'pay-stack';
    case RAZORPAY = 'RazorPay';
    case FLUTTER_WAVE = 'Flutterwave';
}
