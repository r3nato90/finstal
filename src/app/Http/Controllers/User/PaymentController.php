<?php

namespace App\Http\Controllers\User;
use App\Models\PaymentTransaction;
use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;


class PaymentController extends Controller
{
    /**
     * Display a listing of the payment gateways.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Pega todos os gateways de pagamento
        $gateways = PaymentGateway::all();

        // Retorna a view com os dados dos gateways
        return view('admin.payment_gateway.index', compact('gateways'));
    }
}