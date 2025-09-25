@extends('layouts.admin')
@section('content')
    <div class="container">
        <h2>{{ __('Configure Payment Gateway') }}</h2>
        <form method="POST" action="{{ route('admin.payment.store2') }}">
            @csrf
            <!-- Campos do formulário para registrar os dados -->
            <div class="form-group">
                <label for="name">{{ __('Payment Gateway Name') }}</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label for="api_url">{{ __('API URL') }}</label>
                <input type="text" class="form-control" name="api_url" id="api_url" required>
            </div>

            <div class="form-group">
                <label for="api_key">{{ __('API Key') }}</label>
                <input type="text" class="form-control" name="api_key" id="api_key" required>
            </div>

            <div class="form-group">
                <label for="secret_key">{{ __('Secret Key') }}</label>
                <input type="text" class="form-control" name="secret_key" id="secret_key" required>
            </div>

            <div class="form-group">
                <label for="currency">{{ __('Currency') }}</label>
                <input type="text" class="form-control" name="currency" id="currency" value="USD" required>
            </div>

            <div class="form-group">
                <label for="enabled">{{ __('Enabled') }}</label>
                <select class="form-control" name="enabled" id="enabled" required>
                    <option value="1">{{ __('Yes') }}</option>
                    <option value="0">{{ __('No') }}</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Save Configuration') }}</button>
        </form>
    </div>
@endsection
