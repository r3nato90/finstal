@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>{{ __('Payment via PIX') }}</h2>
        <div class="payment-info">
            <!-- Exibir o QR Code -->
            <div class="qr-code">
                <img src="{{ $transaction->qr_code }}" alt="PIX QR Code" />
            </div>

            <!-- Exibir o código PIX -->
            <div class="pix-code">
                <label>{{ __('PIX Code') }}</label>
                <input type="text" value="{{ $transaction->pix_code }}" id="pix_code" readonly />
                <button onclick="copyToClipboard()">Copy</button>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("pix_code");
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand("copy");
            alert("PIX Code copied: " + copyText.value);
        }
    </script>
@endsection
