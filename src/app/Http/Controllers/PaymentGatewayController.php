<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentGatewayController extends Controller
{
    public function index(Request $request)
    {
        // Query gateways with pagination, ensuring no missing records
        $rows = PaymentProvider::paginate(10);

        return view('admin.payment_gateways', compact('rows'));
    }

    public function update(Request $request)
    {
        $data = $request->input('providers', []);

        // Update gateway provider configurations (as already done)
        DB::transaction(function () use ($data) {
            foreach ($data as $key => $payload) {
                $provider = PaymentProvider::where('key', $key)->first();
                if (!$provider) continue;

                $provider->enabled = !empty($payload['enabled']) ? 1 : 0;
                $config = $provider->config ?? [];

                // Adicionando a integração com o PIX e USDT da VersellPay
                if (isset($payload['pix'])) {
                    $config['pix'] = array_merge($config['pix'] ?? [], [
                        'callback_url'   => $payload['pix']['callback_url'] ?? '',
                        'usd_multiplier' => isset($payload['pix']['usd_multiplier']) ? (float)$payload['pix']['usd_multiplier'] : 1.00,
                    ]);

                    // Criar uma sessão de pagamento via API da VersellPay para PIX
                    $response = Http::withBasicAuth(env('VERSALLPAY_API_KEY'), env('VERSALLPAY_API_SECRET'))
                        ->post(env('VERSALLPAY_API_URL') . '/sessions', [
                            'amount' => $payload['pix']['amount'],  // Adicione o valor do pagamento
                            'currency' => 'BRL',
                            'callback_url' => $payload['pix']['callback_url'] ?? '',
                        ]);

                    if ($response->successful()) {
                        $sessionData = $response->json();
                        $config['pix']['session_id'] = $sessionData['session_id'];  // Salvar o ID da sessão para futuras verificações
                    }
                }

                if (isset($payload['usdt_trc20'])) {
                    $config['usdt_trc20'] = array_merge($config['usdt_trc20'] ?? [], [
                        'callback_url' => $payload['usdt_trc20']['callback_url'] ?? '',
                    ]);

                    // Criar uma sessão de pagamento via API da VersellPay para USDT
                    $response = Http::withBasicAuth(env('VERSALLPAY_API_KEY'), env('VERSALLPAY_API_SECRET'))
                        ->post(env('VERSALLPAY_API_URL') . '/sessions', [
                            'amount' => $payload['usdt_trc20']['amount'],  // Adicione o valor do pagamento
                            'currency' => 'USDT',
                            'callback_url' => $payload['usdt_trc20']['callback_url'] ?? '',
                        ]);

                    if ($response->successful()) {
                        $sessionData = $response->json();
                        $config['usdt_trc20']['session_id'] = $sessionData['session_id'];  // Salvar o ID da sessão para futuras verificações
                    }
                }

                $provider->config = $config;
                $provider->save();
            }
        });

        return back()->with('status', 'Configurações salvas com sucesso!');
    }
}
