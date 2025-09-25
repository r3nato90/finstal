@extends('layouts.admin')

@section('content')
<div class="container">
  <h1 class="mb-4">Processadores de Pagamentos Automáticos</h1>

  @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <form action="{{ route('admin.payment_gateways.update') }}" method="POST">
    @csrf
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Provedor</th>
            <th>Ativo</th>
            <th>PIX - Callback</th>
            <th>PIX - USD Multiplier</th>
            <th>USDT TRC-20 - Callback</th>
            <th>Session ID - PIX</th>
            <th>Session ID - USDT TRC-20</th>
            <th>Suporte</th>
          </tr>
        </thead>
        <tbody>
          @foreach($providers as $provider)
            @php
              $cap = $capabilities[$provider->key] ?? ['pix'=>false,'usdt_trc20'=>false];
              $cfg = $provider->config ?? [];
            @endphp
            <tr>
              <td><strong>{{ $provider->title }}</strong><br><code>{{ $provider->key }}</code></td>
              <td>
                <input type="checkbox" name="providers[{{ $provider->key }}][enabled]" value="1" {{ $provider->enabled ? 'checked' : '' }}>
              </td>
              <td>
                @if($cap['pix'])
                  <input type="text" class="form-control" name="providers[{{ $provider->key }}][pix][callback_url]" value="{{ $cfg['pix']['callback_url'] ?? '' }}" placeholder="https://.../callback">
                @else <em>—</em> @endif
              </td>
              <td style="max-width:140px;">
                @if($cap['pix'])
                  <input type="number" step="0.01" min="0" class="form-control" name="providers[{{ $provider->key }}][pix][usd_multiplier]" value="{{ $cfg['pix']['usd_multiplier'] ?? 1.00 }}">
                  <small class="text-muted">Depósito PIX em USD será multiplicado por este fator.</small>
                @else <em>—</em> @endif
              </td>
              <td>
                @if($cap['usdt_trc20'])
                  <input type="text" class="form-control" name="providers[{{ $provider->key }}][usdt_trc20][callback_url]" value="{{ $cfg['usdt_trc20']['callback_url'] ?? '' }}" placeholder="https://.../callback">
                @else <em>—</em> @endif
              </td>
              <td>
                @if($cap['pix'])
                  <input type="text" class="form-control" name="providers[{{ $provider->key }}][pix][session_id]" value="{{ $cfg['pix']['session_id'] ?? '' }}" readonly>
                @else <em>—</em> @endif
              </td>
              <td>
                @if($cap['usdt_trc20'])
                  <input type="text" class="form-control" name="providers[{{ $provider->key }}][usdt_trc20][session_id]" value="{{ $cfg['usdt_trc20']['session_id'] ?? '' }}" readonly>
                @else <em>—</em> @endif
              </td>
              <td>
                <span class="badge bg-{{ $cap['pix'] ? 'success' : 'secondary' }}">PIX</span>
                <span class="badge bg-{{ $cap['usdt_trc20'] ? 'success' : 'secondary' }}">USDT TRC-20</span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
  </form>
</div>
@endsection
