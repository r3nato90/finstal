@php use App\Enums\Matrix\PinStatus; @endphp
@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <h3 class="page-title">{{ __('Pin Management') }}</h3>
            <div class="page-links">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pinGenerateModal">
                    <i class="las la-plus"></i> {{ __('Generate Pin') }}
                </button>
            </div>
        </div>

        <div class="row mb-4 mt-3">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Pins') }}</h6>
                        <h4 class="text--dark">{{ shortAmount($stats['totalPins']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Unused') }}</h6>
                        <h4 class="text--warning">{{ shortAmount($stats['unusedPins']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Used') }}</h6>
                        <h4 class="text--success">{{ shortAmount($stats['usedPins']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Admin Pins') }}</h6>
                        <h4 class="text--info">{{ shortAmount($stats['adminPins']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('User Pins') }}</h6>
                        <h4 class="text--primary">{{ shortAmount($stats['userPins']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Amount') }}</h6>
                        <h4 class="text--dark">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalPinAmount']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Used Pin Amount') }}</h6>
                        <h3 class="text--success">{{ getCurrencySymbol() }}{{ shortAmount($stats['usedPinAmount']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Unused Pin Amount') }}</h6>
                        <h3 class="text--warning">{{ getCurrencySymbol() }}{{ shortAmount($stats['unusedPinAmount']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Total Charges') }}</h6>
                        <h3 class="text--info">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalCharges']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Net Pin Value') }}</h6>
                        <h3 class="text--primary">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalPinAmount'] - $stats['totalCharges']) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.pin.index') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ $filters['search'] ?? '' }}"
                                       placeholder="{{ __('UID, Pin, User...') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">{{ __('All Status') }}</option>
                                    <option value="1" {{ ($filters['status'] ?? '') == '1' ? 'selected' : '' }}>{{ __('Unused') }}</option>
                                    <option value="2" {{ ($filters['status'] ?? '') == '2' ? 'selected' : '' }}>{{ __('Used') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="pin_type">{{ __('Pin Type') }}</label>
                                <select name="pin_type" id="pin_type" class="form-control">
                                    <option value="">{{ __('All Types') }}</option>
                                    <option value="admin" {{ ($filters['pin_type'] ?? '') == 'admin' ? 'selected' : '' }}>{{ __('Admin Generated') }}</option>
                                    <option value="user" {{ ($filters['pin_type'] ?? '') == 'user' ? 'selected' : '' }}>{{ __('User Generated') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="set_user">{{ __('Set By User') }}</label>
                                <select name="set_user" id="set_user" class="form-control">
                                    <option value="">{{ __('All Users') }}</option>
                                    @foreach($setUsers as $userId => $userName)
                                        <option value="{{ $userId }}" {{ ($filters['set_user'] ?? '') == $userId ? 'selected' : '' }}>
                                            {{ $userName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field">{{ __('Sort By') }}</label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" {{ ($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : '' }}>{{ __('Date Created') }}</option>
                                    <option value="uid" {{ ($filters['sort_field'] ?? '') == 'uid' ? 'selected' : '' }}>{{ __('UID') }}</option>
                                    <option value="pin_number" {{ ($filters['sort_field'] ?? '') == 'pin_number' ? 'selected' : '' }}>{{ __('Pin Number') }}</option>
                                    <option value="amount" {{ ($filters['sort_field'] ?? '') == 'amount' ? 'selected' : '' }}>{{ __('Amount') }}</option>
                                    <option value="status" {{ ($filters['sort_field'] ?? '') == 'status' ? 'selected' : '' }}>{{ __('Status') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Filter') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th>{{ __('UID') }}</th>
                        <th>{{ __('Pin Number') }}</th>
                        <th>{{ __('Used By') }}</th>
                        <th>{{ __('Generated By') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Charge') }}</th>
                        <th>{{ __('Net Amount') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Date') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($pins as $pin)
                        <tr>
                            <td data-label="{{ __('UID') }}">
                                <strong>{{ $pin->uid }}</strong>
                            </td>
                            <td data-label="{{ __('Pin Number') }}">
                                <div class="pin-number">
                                    <strong class="text--primary">{{ $pin->pin_number }}</strong>
                                    <button class="btn btn-sm btn-outline-secondary copy-btn"
                                            onclick="copyToClipboard('{{ $pin->pin_number }}')"
                                            title="{{ __('Copy Pin') }}">
                                        <i class="las la-copy"></i>
                                    </button>
                                </div>
                            </td>
                            <td data-label="{{ __('Used By') }}">
                                @if($pin->user)
                                    <div class="user-info">
                                        <strong>{{ $pin->user->fullname ?? $pin->user->username }}</strong>
                                        <br><small class="text-muted">{{ $pin->user->email }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">{{ __('Not Used') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Generated By') }}">
                                @if($pin->setUser)
                                    <div class="user-info">
                                        <strong>{{ $pin->setUser->fullname ?? $pin->setUser->username }}</strong>
                                        <br><small class="text-muted">{{ $pin->setUser->email }}</small>
                                    </div>
                                @else
                                    <span class="badge badge--info">{{ __('Admin') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Amount') }}">
                                <strong>{{ getCurrencySymbol() }}{{ shortAmount($pin->amount, 2) }}</strong>
                            </td>
                            <td data-label="{{ __('Charge') }}">
                                <span class="text--warning">{{ getCurrencySymbol() }}{{ shortAmount($pin->charge, 2) }}</span>
                            </td>
                            <td data-label="{{ __('Net Amount') }}">
                                <strong class="text--success">{{ getCurrencySymbol() }}{{ shortAmount($pin->amount - $pin->charge, 2) }}</strong>
                            </td>
                            <td data-label="{{ __('Status') }}">
                                @php
                                    $statusClass = PinStatus::getColor($pin->status);
                                    $statusText = PinStatus::getName($pin->status);
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ strtoupper($statusText) }}</span>
                                @if($pin->setUser)
                                    <br><span class="mt-1 badge badge--primary-transparent">User Generated</span>
                                @else
                                    <br><span class="mt-1 badge badge--info-transparent">Admin Generated</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Date') }}">
                                <div class="time-info">
                                    <strong>{{ $pin->created_at->format('M d, H:i') }}</strong>
                                    <br><small class="text-muted">{{ $pin->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="10">{{ __('No pins found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($pins->hasPages())
                <div class="card-footer">
                    {{ $pins->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>

    <!-- Pin Generate Modal -->
    <div class="modal fade" id="pinGenerateModal" tabindex="-1" role="dialog" aria-labelledby="pinGenerateModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pinGenerateModalLabel">{{ __('admin.pin.content.generated') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.pin.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="amount">{{ __('admin.input.amount') }} <sup class="text-danger">*</sup></label>
                                <input type="text" name="amount" id="amount" class="form-control" placeholder="{{ __('admin.placeholder.amount') }}" required>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label" for="number">{{ __('admin.input.number') }} <sup class="text-danger">*</sup></label>
                                <input type="text" name="number" id="number" class="form-control" placeholder="{{ __('admin.placeholder.number') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">{{ __('admin.button.close') }}</button>
                        <button type="submit" class="btn btn--primary btn--sm">{{ __('admin.button.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        "use strict";

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                console.log('Copied to clipboard: ' + text);
                showToast('Pin copied to clipboard!');
            }).catch(function(err) {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showToast('Pin copied to clipboard!');
            });
        }

        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'alert alert-success';
            toast.style.position = 'fixed';
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';
            toast.innerHTML = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        $(document).ready(function () {
            $('.reference-copy').click(function() {
                const copyText = $(this).data('pin');
                copyToClipboard(copyText);
            });
        });
    </script>
@endpush

@push('style-push')
    <style>
        .pin-number {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .copy-btn {
            padding: 2px 6px;
            font-size: 12px;
            color: black;
        }

        .user-info {
            max-width: 150px;
        }
    </style>
@endpush
