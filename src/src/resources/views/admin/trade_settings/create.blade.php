@extends('admin.layouts.main')
@section('panel')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="mb-1">{{ $setTitle }}</h4>
                        <p class="text-muted mb-0 small">{{ __('Configure a new symbol for trading') }}</p>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 small">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.trade-settings.index') }}" class="text-decoration-none text-muted">{{ __('Trade Settings') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Create') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card simple-card">
                    <form method="POST" action="{{ route('admin.trade-settings.store') }}" id="tradeSettingForm">
                        @csrf
                        <div class="card-body">
                            <div class="section-title">{{ __('Symbol Information') }}</div>

                            <div class="row">
                                <div class="col-12">
                                    <label for="symbol" class="form-label">{{ __('Trading Symbol') }} <span class="text-danger">*</span></label>
                                    <select name="symbol" id="symbol" class="form-select @error('symbol') is-invalid @enderror" required>
                                        <option value="">{{ __('Select Currency') }}</option>
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency->symbol }}" {{ old('symbol') == $currency->symbol ? 'selected' : '' }}>
                                                    {{ strtoupper($currency->symbol) }} - {{ $currency->name }}
                                                </option>
                                            @endforeach
                                    </select>
                                    @error('symbol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top">
                            <div class="section-title">{{ __('Trading Configuration') }}</div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="min_amount" class="form-label">{{ __('Minimum Amount') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">$</span>
                                        <input type="number" name="min_amount" id="min_amount" step="0.01" min="0.01"
                                               value="{{ old('min_amount', 1) }}"
                                               class="form-control border-start-0 @error('min_amount') is-invalid @enderror"
                                               placeholder="1.00" required>
                                        @error('min_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="max_amount" class="form-label">{{ __('Maximum Amount') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">$</span>
                                        <input type="number" name="max_amount" id="max_amount" step="0.01" min="0.01"
                                               value="{{ old('max_amount', 10000) }}"
                                               class="form-control border-start-0 @error('max_amount') is-invalid @enderror"
                                               placeholder="10000.00" required>
                                        @error('max_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="payout_rate" class="form-label">{{ __('Payout Rate') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="payout_rate" id="payout_rate" step="0.01" min="1" max="1000"
                                               value="{{ old('payout_rate', 85) }}"
                                               class="form-control border-end-0 @error('payout_rate') is-invalid @enderror"
                                               placeholder="85.00" required>
                                        <span class="input-group-text bg-white border-start-0">%</span>
                                        @error('payout_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Status') }}</label>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label for="is_active" id="status-label">
                                            {{ old('is_active', true) ? __('Active') : __('Inactive') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Financial Preview Section -->
                        <div class="card-body border-top bg-light" id="financial-preview">
                            <div class="section-title">{{ __('Financial Preview') }}</div>

                            <div class="row text-center g-3">
                                <div class="col-md-4">
                                    <div class="small text-muted mb-1">{{ __('Investment Range') }}</div>
                                    <div class="fw-semibold" id="investment-range">$1.00 - $10,000.00</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="small text-muted mb-1">{{ __('Example ($100 investment)') }}</div>
                                    <div class="fw-semibold text--success" id="profit-example">$85.00 profit potential</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="small text-muted mb-1">{{ __('Payout Rate') }}</div>
                                    <div class="fw-semibold" id="payout-display">85.00%</div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top">
                            <div class="section-title">{{ __('Duration Options') }}</div>
                            @php
                                $predefinedDurations = [
                                    ['label' => '30 sec', 'value' => 30],
                                    ['label' => '1 min', 'value' => 60],
                                    ['label' => '2 min', 'value' => 120],
                                    ['label' => '5 min', 'value' => 300],
                                    ['label' => '10 min', 'value' => 600],
                                    ['label' => '15 min', 'value' => 900],
                                    ['label' => '30 min', 'value' => 1800],
                                    ['label' => '1 hour', 'value' => 3600],
                                    ['label' => '2 hours', 'value' => 7200],
                                    ['label' => '4 hours', 'value' => 14400]
                                ];
                                $selectedDurations = old('durations', [60, 300, 900]);
                            @endphp

                            <div class="row g-3">
                                @foreach($predefinedDurations as $duration)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="form-check">
                                            <input class="form-check-input duration-checkbox" type="checkbox"
                                                   name="durations[]" value="{{ $duration['value'] }}"
                                                   id="duration_{{ $duration['value'] }}"
                                                {{ in_array($duration['value'], $selectedDurations) ? 'checked' : '' }}>
                                            <label for="duration_{{ $duration['value'] }}">
                                                {{ $duration['label'] }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('durations')
                            <div class="text-danger mt-2 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card-body border-top">
                            <div class="section-title">{{ __('Trading Schedule') }}</div>
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm schedule-preset-btn" onclick="setAllDays(true)">
                                    {{ __('Enable All Days') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm schedule-preset-btn" onclick="setAllDays(false)">
                                    {{ __('Disable All Days') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm schedule-preset-btn" onclick="setWeekdaysOnly()">
                                    {{ __('Weekdays Only') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm schedule-preset-btn" onclick="set24Hours()">
                                    {{ __('24/7 Trading') }}
                                </button>
                            </div>

                            @php
                                $defaultHours = [
                                    'monday' => ['enabled' => true, 'start' => '09:00', 'end' => '17:00'],
                                    'tuesday' => ['enabled' => true, 'start' => '09:00', 'end' => '17:00'],
                                    'wednesday' => ['enabled' => true, 'start' => '09:00', 'end' => '17:00'],
                                    'thursday' => ['enabled' => true, 'start' => '09:00', 'end' => '17:00'],
                                    'friday' => ['enabled' => true, 'start' => '09:00', 'end' => '17:00'],
                                    'saturday' => ['enabled' => false, 'start' => '09:00', 'end' => '17:00'],
                                    'sunday' => ['enabled' => false, 'start' => '09:00', 'end' => '17:00']
                                ];
                                $tradingHours = old('trading_hours', $defaultHours);
                            @endphp

                            <div class="row g-3">
                                @foreach($tradingHours as $day => $hours)
                                    <div class="col-md-6">
                                        <div class="schedule-card p-3 rounded">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <h6 class="mb-0 text-capitalize small fw-semibold">{{ __($day) }}</h6>
                                                <div class="form-check">
                                                    <input class="form-check-input trading-day" type="checkbox"
                                                           id="trading_{{ $day }}" name="trading_hours[{{ $day }}][enabled]"
                                                           value="1" {{ ($hours['enabled'] ?? false) ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="trading-time-inputs" style="{{ ($hours['enabled'] ?? false) ? '' : 'display: none;' }}">
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <label class="form-label small text-muted">{{ __('Start') }}</label>
                                                        <input type="time" name="trading_hours[{{ $day }}][start]"
                                                               value="{{ $hours['start'] ?? '09:00' }}"
                                                               class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label small text-muted">{{ __('End') }}</label>
                                                        <input type="time" name="trading_hours[{{ $day }}][end]"
                                                               value="{{ $hours['end'] ?? '17:00' }}"
                                                               class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="trading-closed-text text-center" style="{{ ($hours['enabled'] ?? false) ? 'display: none;' : '' }}">
                                                <small class="text-muted">{{ __('Closed') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-footer bg-light border-top">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.trade-settings.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>{{ __('Cancel') }}
                                </a>
                                <button type="submit" class="btn btn-dark" id="submit-btn">
                                    <span class="spinner-border spinner-border-sm d-none me-2" id="submit-spinner"></span>
                                    <i class="fas fa-save me-1"></i>{{ __('Create Setting') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card preview-card sticky-top" style="top: 2rem;">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold">{{ __('Trade Setting Preview') }}</h6>
                            <span class="badge badge-simple small">{{ __('Create Mode') }}</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="preview-item px-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">{{ __('Symbol') }}:</span>
                                <span id="preview-symbol" class="fw-semibold">-</span>
                            </div>
                        </div>

                        <div class="preview-item px-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">{{ __('Status') }}:</span>
                                <span id="preview-status" class="badge badge-active small">{{ __('Active') }}</span>
                            </div>
                        </div>

                        <div class="preview-item px-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">{{ __('Min Amount') }}:</span>
                                <span id="preview-min" class="fw-semibold">$1.00</span>
                            </div>
                        </div>

                        <div class="preview-item px-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">{{ __('Max Amount') }}:</span>
                                <span id="preview-max" class="fw-semibold">$10,000.00</span>
                            </div>
                        </div>

                        <div class="preview-item px-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">{{ __('Payout Rate') }}:</span>
                                <span id="preview-payout" class="fw-semibold">85.00%</span>
                            </div>
                        </div>

                        <div class="preview-item px-3">
                            <span class="text-muted small d-block mb-2">{{ __('Selected Durations') }}:</span>
                            <div id="preview-durations" class="d-flex flex-wrap gap-1">
                                <span class="badge badge-simple small">1 min</span>
                                <span class="badge badge-simple small">5 min</span>
                                <span class="badge badge-simple small">15 min</span>
                            </div>
                        </div>

                        <div class="preview-item px-3">
                            <span class="text-muted small d-block mb-2">{{ __('Trading Days') }}:</span>
                            <div id="preview-trading-days">
                                <small class="text-muted">{{ __('Monday - Friday (09:00 - 17:00)') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Tips Card -->
                <div class="card simple-card mt-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-semibold">{{ __('Quick Tips') }}</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-circle text-muted me-2 mt-1" style="font-size: 6px;"></i>
                                {{ __('Higher payout rates attract more traders') }}
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-circle text-muted me-2 mt-1" style="font-size: 6px;"></i>
                                {{ __('Multiple durations give traders more flexibility') }}
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-circle text-muted me-2 mt-1" style="font-size: 6px;"></i>
                                {{ __('Weekend trading can increase volume') }}
                            </li>
                            <li class="mb-0 d-flex align-items-start">
                                <i class="fas fa-circle text-muted me-2 mt-1" style="font-size: 6px;"></i>
                                {{ __('Test settings with small amounts first') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style-push')
    <style>
        :root {
            --border-light: #e9ecef;
            --text-muted: #6c757d;
            --bg-light: #f8f9fa;
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .simple-card {
            border: 1px solid var(--border-light) !important;
            box-shadow: var(--shadow-sm) !important;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-light);
        }

        .form-label {
            font-weight: 500 !important;
            color: #495057 !important;
            font-size: 13px !important;
        }

        .schedule-card {
            border: 1px solid var(--border-light) !important;
            background: white !important;
        }

        .schedule-preset-btn {
            font-size: 12px !important;
            padding: 0.25rem 0.75rem !important;
            border-color: #ced4da !important;
            color: #6c757d !important;
        }

        .schedule-preset-btn:hover {
            border-color: #adb5bd !important;
            background-color: #f8f9fa !important;
            color: #495057 !important;
        }

        .preview-card {
            background: white !important;
            border: 1px solid var(--border-light) !important;
        }

        .preview-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .preview-item:last-child {
            border-bottom: none;
        }

        .badge-simple {
            background-color: #e9ecef !important;
            color: #495057 !important;
            font-weight: normal !important;
        }

        .badge-active {
            background-color: #d4edda !important;
            color: #155724 !important;
        }

        /* Override any existing button styles */
        .btn-outline-secondary {
            border-color: #6c757d !important;
            color: #6c757d !important;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            color: white !important;
        }

        .btn-dark {
            background-color: #495057 !important;
            border-color: #495057 !important;
        }

        .btn-dark:hover {
            background-color: #343a40 !important;
            border-color: #343a40 !important;
        }

        /* Input group styling */
        .input-group-text {
            background-color: #f8f9fa !important;
            border-color: #ced4da !important;
            color: #6c757d !important;
        }

        .form-control {
            border-color: #ced4da !important;
        }

        .form-control:focus {
            border-color: #adb5bd !important;
            box-shadow: 0 0 0 0.25rem rgba(108, 117, 125, 0.25) !important;
        }

        /* Override card backgrounds */
        .card-header {
            background-color: #f8f9fa !important;
            border-bottom-color: #e9ecef !important;
        }

        .card-footer {
            background-color: #f8f9fa !important;
            border-top-color: #e9ecef !important;
        }

        /* Time input styling */
        input[type="time"] {
            border-color: #ced4da !important;
        }

        input[type="time"]:focus {
            border-color: #adb5bd !important;
            box-shadow: 0 0 0 0.25rem rgba(108, 117, 125, 0.25) !important;
        }

    </style>
@endpush

@push('script-push')
    <script>
        // Form interactions
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('tradeSettingForm');
            const inputs = form.querySelectorAll('input, select');

            inputs.forEach(input => {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            });

            // Trading day toggles
            document.querySelectorAll('.trading-day').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const timeInputs = this.closest('.schedule-card').querySelector('.trading-time-inputs');
                    const closedText = this.closest('.schedule-card').querySelector('.trading-closed-text');

                    if (this.checked) {
                        timeInputs.style.display = 'block';
                        closedText.style.display = 'none';
                    } else {
                        timeInputs.style.display = 'none';
                        closedText.style.display = 'block';
                    }
                    updatePreview();
                });
            });


            function updatePreview() {
                // Update symbol
                const symbolSelect = document.getElementById('symbol');
                const symbolText = symbolSelect.options[symbolSelect.selectedIndex]?.text || '-';
                document.getElementById('preview-symbol').textContent = symbolText.split(' - ')[0] || '-';

                // Update amounts
                const minAmount = document.getElementById('min_amount').value || '0';
                const maxAmount = document.getElementById('max_amount').value || '0';
                const payoutRate = document.getElementById('payout_rate').value || '0';

                document.getElementById('preview-min').textContent = `$${parseFloat(minAmount).toFixed(2)}`;
                document.getElementById('preview-max').textContent = `$${parseFloat(maxAmount).toLocaleString('en-US', {minimumFractionDigits: 2})}`;
                document.getElementById('preview-payout').textContent = `${parseFloat(payoutRate).toFixed(2)}%`;

                // Update financial preview
                document.getElementById('investment-range').textContent = `$${parseFloat(minAmount).toFixed(2)} - $${parseFloat(maxAmount).toLocaleString('en-US', {minimumFractionDigits: 2})}`;
                document.getElementById('profit-example').textContent = `$${(100 * parseFloat(payoutRate) / 100).toFixed(2)} profit potential`;
                document.getElementById('payout-display').textContent = `${parseFloat(payoutRate).toFixed(2)}%`;

                // Update durations
                const checkedDurations = document.querySelectorAll('.duration-checkbox:checked');
                const durationContainer = document.getElementById('preview-durations');
                durationContainer.innerHTML = '';

                checkedDurations.forEach(checkbox => {
                    const label = document.querySelector(`label[for="${checkbox.id}"]`);
                    if (label) {
                        const badge = document.createElement('span');
                        badge.textContent = label.textContent.trim();
                        durationContainer.appendChild(badge);
                    }
                });

                // Update trading days
                const activeDays = [];
                document.querySelectorAll('.trading-day:checked').forEach(checkbox => {
                    const day = checkbox.id.replace('trading_', '');
                    activeDays.push(day.charAt(0).toUpperCase() + day.slice(1));
                });

                const tradingDaysText = activeDays.length > 0 ?
                    `${activeDays.join(', ')} (09:00 - 17:00)` :
                    'No trading days selected';

                document.getElementById('preview-trading-days').innerHTML =
                    `<small class="text-muted">${tradingDaysText}</small>`;
            }

            // Initialize preview
            updatePreview();
        });

        // Schedule preset functions
        function setAllDays(enabled) {
            document.querySelectorAll('.trading-day').forEach(checkbox => {
                checkbox.checked = enabled;
                checkbox.dispatchEvent(new Event('change'));
            });
        }

        function setWeekdaysOnly() {
            const weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
            document.querySelectorAll('.trading-day').forEach(checkbox => {
                const day = checkbox.id.replace('trading_', '');
                checkbox.checked = weekdays.includes(day);
                checkbox.dispatchEvent(new Event('change'));
            });
        }

        function set24Hours() {
            document.querySelectorAll('.trading-day').forEach(checkbox => {
                checkbox.checked = true;
                checkbox.dispatchEvent(new Event('change'));
            });

            document.querySelectorAll('input[type="time"]').forEach(timeInput => {
                if (timeInput.name.includes('[start]')) {
                    timeInput.value = '00:00';
                } else if (timeInput.name.includes('[end]')) {
                    timeInput.value = '23:59';
                }
            });
        }
    </script>
@endpush
