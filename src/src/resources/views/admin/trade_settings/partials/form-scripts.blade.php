@push('style-push')
    <style>
        .form-check-label[for*="duration_"] {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .form-check-input[type="checkbox"]:checked + .form-check-label {
            background-color: var(--bs-primary) !important;
            color: white !important;
            border-color: var(--bs-primary) !important;
        }

        .form-check-label[for*="duration_"]:hover {
            background-color: var(--bs-light);
            border-color: var(--bs-primary);
        }

        .trading-time-inputs {
            transition: all 0.3s ease;
        }

        .preview-item {
            transition: all 0.2s ease;
        }

        .card {
            border-radius: 0.75rem;
        }

        .form-switch .form-check-input {
            width: 2.5rem;
            height: 1.25rem;
        }

        .form-switch .form-check-input:checked {
            background-color: var(--bs-success);
            border-color: var(--bs-success);
        }

        @media (max-width: 768px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
            }

            .btn-lg {
                width: 100%;
            }
        }
    </style>
@endpush

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function() {
            // Initialize preview
            updatePreview();
            updateFinancialPreview();
            updateDurationPreview();
            updateTradingDaysPreview();

            // Symbol selection change (only for create mode)
            $('#symbol').on('change', function() {
                updatePreview();
            });

            // Status toggle
            $('#is_active').on('change', function() {
                const isActive = $(this).is(':checked');
                $('#status-label').text(isActive ? '{{ __("Active") }}' : '{{ __("Inactive") }}');
                updatePreview();
            });

            // Amount and payout rate changes
            $('#min_amount, #max_amount, #payout_rate').on('input keyup', function() {
                updatePreview();
                updateFinancialPreview();
            });

            // Duration checkboxes
            $('.duration-checkbox').on('change', function() {
                updateDurationPreview();
            });

            // Trading day toggles
            $('.trading-day').on('change', function() {
                const day = $(this).attr('id').replace('trading_', '');
                const isEnabled = $(this).is(':checked');
                const timeInputs = $(this).closest('.card-body').find('.trading-time-inputs');
                const closedText = $(this).closest('.card-body').find('.trading-closed-text');

                if (isEnabled) {
                    timeInputs.show();
                    closedText.hide();
                } else {
                    timeInputs.hide();
                    closedText.show();
                }

                updateTradingDaysPreview();
            });

            // Form submission
            $('#tradeSettingForm').on('submit', function(e) {
                const submitBtn = $('#submit-btn');
                const spinner = $('#submit-spinner');

                // Basic validation
                let isValid = true;
                const minAmount = parseFloat($('#min_amount').val()) || 0;
                const maxAmount = parseFloat($('#max_amount').val()) || 0;
                const payoutRate = parseFloat($('#payout_rate').val()) || 0;
                const selectedDurations = $('.duration-checkbox:checked').length;

                // Check if max amount is greater than min amount
                if (minAmount > 0 && maxAmount > 0 && maxAmount <= minAmount) {
                    e.preventDefault();
                    showToast('{{ __("Maximum amount must be greater than minimum amount") }}', 'error');
                    return false;
                }

                // Check if at least one duration is selected
                if (selectedDurations === 0) {
                    e.preventDefault();
                    showToast('{{ __("Please select at least one trading duration") }}', 'error');
                    return false;
                }

                // Check if at least one trading day is enabled
                const enabledDays = $('.trading-day:checked').length;
                if (enabledDays === 0) {
                    e.preventDefault();
                    showToast('{{ __("Please enable at least one trading day") }}', 'error');
                    return false;
                }

                if (isValid) {
                    submitBtn.prop('disabled', true);
                    spinner.removeClass('d-none');
                }
            });

            // Functions
            function updatePreview() {
                // Symbol (only update if element exists - for create mode)
                const symbolInput = $('#symbol');
                let symbol = '';
                if (symbolInput.length > 0) {
                    symbol = symbolInput.val() || '-';
                } else {
                    // For edit mode, get from existing display
                    symbol = $('#preview-symbol').text() || '-';
                }
                $('#preview-symbol').text(symbol.toUpperCase());

                // Status
                const isActive = $('#is_active').is(':checked');
                const statusBadge = $('#preview-status');
                if (isActive) {
                    statusBadge.removeClass('bg-danger').addClass('bg-success').text('{{ __("Active") }}');
                } else {
                    statusBadge.removeClass('bg-success').addClass('bg-danger').text('{{ __("Inactive") }}');
                }

                // Amounts
                const minAmount = parseFloat($('#min_amount').val()) || 0;
                const maxAmount = parseFloat($('#max_amount').val()) || 0;
                $('#preview-min').text('$' + formatNumber(minAmount));
                $('#preview-max').text('$' + formatNumber(maxAmount));

                // Payout rate
                const payoutRate = parseFloat($('#payout_rate').val()) || 0;
                $('#preview-payout').text(payoutRate.toFixed(2) + '%');
            }

            function updateFinancialPreview() {
                const minAmount = parseFloat($('#min_amount').val()) || 0;
                const maxAmount = parseFloat($('#max_amount').val()) || 0;
                const payoutRate = parseFloat($('#payout_rate').val()) || 0;

                if (minAmount > 0 && maxAmount > 0 && payoutRate > 0) {
                    $('#financial-preview').show();

                    // Investment range
                    $('#investment-range').text('$' + formatNumber(minAmount) + ' - $' + formatNumber(maxAmount));

                    // Example profit
                    const exampleProfit = (100 * payoutRate) / 100;
                    $('#profit-example').text('$' + formatNumber(exampleProfit) + ' profit potential');

                    // Payout display
                    $('#payout-display').text(payoutRate.toFixed(1) + '%');
                } else {
                    // Only hide for create mode, keep visible for edit mode
                    if ($('#symbol').length > 0) {
                        $('#financial-preview').hide();
                    }
                }
            }

            function updateDurationPreview() {
                const selectedDurations = [];
                const durationLabels = {
                    30: '30 sec',
                    60: '1 min',
                    120: '2 min',
                    300: '5 min',
                    600: '10 min',
                    900: '15 min',
                    1800: '30 min',
                    3600: '1 hour',
                    7200: '2 hours',
                    14400: '4 hours'
                };

                $('.duration-checkbox:checked').each(function() {
                    const value = parseInt($(this).val());
                    if (durationLabels[value]) {
                        selectedDurations.push(durationLabels[value]);
                    }
                });

                const previewContainer = $('#preview-durations');
                previewContainer.empty();

                if (selectedDurations.length > 0) {
                    selectedDurations.forEach(function(duration) {
                        previewContainer.append('<span class="badge bg-primary me-1 mb-1">' + duration + '</span>');
                    });
                } else {
                    previewContainer.append('<small class="text-muted">{{ __("No durations selected") }}</small>');
                }
            }

            function updateTradingDaysPreview() {
                const activeDays = [];
                const dayNames = {
                    'monday': '{{ __("Monday") }}',
                    'tuesday': '{{ __("Tuesday") }}',
                    'wednesday': '{{ __("Wednesday") }}',
                    'thursday': '{{ __("Thursday") }}',
                    'friday': '{{ __("Friday") }}',
                    'saturday': '{{ __("Saturday") }}',
                    'sunday': '{{ __("Sunday") }}'
                };

                $('.trading-day:checked').each(function() {
                    const day = $(this).attr('id').replace('trading_', '');
                    const startTime = $('input[name="trading_hours[' + day + '][start]"]').val();
                    const endTime = $('input[name="trading_hours[' + day + '][end]"]').val();

                    if (dayNames[day]) {
                        activeDays.push({
                            name: dayNames[day],
                            start: startTime,
                            end: endTime
                        });
                    }
                });

                const previewContainer = $('#preview-trading-days');
                previewContainer.empty();

                if (activeDays.length > 0) {
                    if (activeDays.length === 7) {
                        previewContainer.append('<small class="text-success">{{ __("24/7 Trading Active") }}</small>');
                    } else if (activeDays.length === 5) {
                        const weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
                        const isWeekdaysOnly = weekdays.every(day => $('.trading-day[id="trading_' + day + '"]').is(':checked'));

                        if (isWeekdaysOnly) {
                            previewContainer.append('<small class="text-success">{{ __("Weekdays Only") }} (' + activeDays[0].start + ' - ' + activeDays[0].end + ')</small>');
                        } else {
                            activeDays.forEach(function(day, index) {
                                previewContainer.append('<small class="text-success d-block">' + day.name + ' (' + day.start + ' - ' + day.end + ')</small>');
                            });
                        }
                    } else {
                        activeDays.forEach(function(day, index) {
                            previewContainer.append('<small class="text-success d-block">' + day.name + ' (' + day.start + ' - ' + day.end + ')</small>');
                        });
                    }
                } else {
                    previewContainer.append('<small class="text-danger">{{ __("No trading days selected") }}</small>');
                }
            }

            function formatNumber(num) {
                return new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(num);
            }

            // Global functions for schedule presets
            window.setAllDays = function(enabled) {
                $('.trading-day').prop('checked', enabled).trigger('change');

                // Show toast notification
                const message = enabled ? '{{ __("All days enabled") }}' : '{{ __("All days disabled") }}';
                showToast(message, 'success');
            };

            window.setWeekdaysOnly = function() {
                const weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
                const weekends = ['saturday', 'sunday'];

                weekdays.forEach(function(day) {
                    $('#trading_' + day).prop('checked', true).trigger('change');
                });

                weekends.forEach(function(day) {
                    $('#trading_' + day).prop('checked', false).trigger('change');
                });

                showToast('{{ __("Weekdays only enabled") }}', 'success');
            };

            window.set24Hours = function() {
                $('.trading-day').prop('checked', true);
                $('input[name*="[start]"]').val('00:00');
                $('input[name*="[end]"]').val('23:59');
                $('.trading-day').trigger('change');

                showToast('{{ __("24/7 trading enabled") }}', 'success');
            };

            // Toast notification function
            function showToast(message, type = 'info') {
                // Create toast container if it doesn't exist
                if ($('#toast-container').length === 0) {
                    $('body').append('<div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>');
                }

                const toastId = 'toast_' + Date.now();
                const bgClass = type === 'success' ? 'bg-success' : (type === 'error' ? 'bg-danger' : 'bg-info');
                const iconClass = type === 'success' ? 'check-circle' : (type === 'error' ? 'exclamation-circle' : 'info-circle');

                const toastHtml = `
            <div id="${toastId}" class="toast ${bgClass} text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body d-flex align-items-center">
                    <i class="fas fa-${iconClass} me-2"></i>
                    <span class="flex-grow-1">${message}</span>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

                $('#toast-container').append(toastHtml);

                // Show toast
                const toastElement = new bootstrap.Toast(document.getElementById(toastId), {
                    autohide: true,
                    delay: 4000
                });
                toastElement.show();

                // Remove toast after it's hidden
                document.getElementById(toastId).addEventListener('hidden.bs.toast', function() {
                    $(this).remove();
                });
            }

            // Validation
            $('#min_amount, #max_amount').on('input', function() {
                const minAmount = parseFloat($('#min_amount').val()) || 0;
                const maxAmount = parseFloat($('#max_amount').val()) || 0;

                if (minAmount > 0 && maxAmount > 0 && maxAmount <= minAmount) {
                    $('#max_amount').addClass('is-invalid');
                    if ($('#max_amount').next('.invalid-feedback').length === 0) {
                        $('#max_amount').after('<div class="invalid-feedback">{{ __("Maximum amount must be greater than minimum amount") }}</div>');
                    }
                } else {
                    $('#max_amount').removeClass('is-invalid');
                    $('#max_amount').next('.invalid-feedback').remove();
                }
            });

            // Payout rate validation
            $('#payout_rate').on('input', function() {
                const payoutRate = parseFloat($(this).val()) || 0;

                if (payoutRate < 1) {
                    $(this).addClass('is-invalid');
                    if ($(this).next('.invalid-feedback').length === 0) {
                        $(this).after('<div class="invalid-feedback">{{ __("Payout rate must be at least 1%") }}</div>');
                    }
                } else if (payoutRate > 1000) {
                    $(this).addClass('is-invalid');
                    if ($(this).next('.invalid-feedback').length === 0) {
                        $(this).after('<div class="invalid-feedback">{{ __("Payout rate cannot exceed 1000%") }}</div>');
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });

            // Duration selection validation
            $('.duration-checkbox').on('change', function() {
                const selectedCount = $('.duration-checkbox:checked').length;

                if (selectedCount === 0) {
                    $('.duration-checkbox').closest('.card-body').find('.text-danger').remove();
                    $('.duration-checkbox').closest('.card-body').append('<div class="text-danger mt-2">{{ __("Please select at least one trading duration") }}</div>');
                } else {
                    $('.duration-checkbox').closest('.card-body').find('.text-danger').remove();
                }
            });

            // Trading days validation
            $('.trading-day').on('change', function() {
                const enabledCount = $('.trading-day:checked').length;

                if (enabledCount === 0) {
                    $('.trading-day').closest('.card-body').find('.text-danger').remove();
                    $('.trading-day').closest('.card-body').append('<div class="text-danger mt-2">{{ __("Please enable at least one trading day") }}</div>');
                } else {
                    $('.trading-day').closest('.card-body').find('.text-danger').remove();
                }
            });

            // Initialize form with server data (for edit mode)
            @if(isset($tradeSetting))
            // Initialize values for edit mode
            setTimeout(function() {
                updatePreview();
                updateFinancialPreview();
                updateDurationPreview();
                updateTradingDaysPreview();
            }, 100);
            @endif

            // Show flash messages if they exist
            @if(session('success'))
            showToast('{{ session('success') }}', 'success');
            @endif

            @if(session('error'))
            showToast('{{ session('error') }}', 'error');
            @endif

            @if(session('warning'))
            showToast('{{ session('warning') }}', 'warning');
            @endif

            @if(session('info'))
            showToast('{{ session('info') }}', 'info');
            @endif

            // Handle server validation errors
            @if($errors->any())
            @foreach($errors->all() as $error)
            showToast('{{ $error }}', 'error');
            @endforeach
            @endif

            // Auto-focus first input on page load
            setTimeout(function() {
                if ($('#symbol').length > 0 && !$('#symbol').val()) {
                    $('#symbol').focus();
                } else if ($('#min_amount').length > 0) {
                    $('#min_amount').focus();
                }
            }, 500);

            // Keyboard shortcuts
            $(document).on('keydown', function(e) {
                // Ctrl+S to save form
                if ((e.ctrlKey || e.metaKey) && e.which === 83) {
                    e.preventDefault();
                    $('#tradeSettingForm').submit();
                }

                // Escape to go back
                if (e.which === 27) {
                    window.location.href = '{{ route('admin.trade-settings.index') }}';
                }
            });

            // Unsaved changes warning
            let formChanged = false;
            $('#tradeSettingForm input, #tradeSettingForm select, #tradeSettingForm textarea').on('change', function() {
                formChanged = true;
            });

            $(window).on('beforeunload', function(e) {
                if (formChanged) {
                    return '{{ __("You have unsaved changes. Are you sure you want to leave this page?") }}';
                }
            });

            $('#tradeSettingForm').on('submit', function() {
                formChanged = false;
            });

            // Auto-save functionality (optional - you can enable this if needed)
            /*
            let autoSaveTimer;
            $('#tradeSettingForm input, #tradeSettingForm select, #tradeSettingForm textarea').on('input change', function() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(function() {
                    // Auto-save logic here if needed
                    console.log('Auto-saving...');
                }, 5000);
            });
            */
        });
    </script>
@endpush
