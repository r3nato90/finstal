@extends('admin.layouts.main')

@section('panel')
    <section>
        <!-- Page Header -->
        <div class="page-header">
            <h3 class="page-title">{{ __('ICO Token Management') }}</h3>
        </div>

        <!-- Action Buttons -->
        <div class="filter-action mb-4">
            <a href="{{ route('admin.ico.token.create') }}" class="i-btn btn--primary btn--md">
                <i class="las la-plus"></i> {{ __('Create New Token') }}
            </a>
        </div>

        <!-- Tokens Table Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('ICO Tokens') }}</h5>
                <div class="card-tools">
                    <span class="text-muted">
                        Showing {{ $tokens->firstItem() ?? 0 }} to {{ $tokens->lastItem() ?? 0 }}
                        of {{ $tokens->total() ?? 0 }} ICO tokens
                    </span>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('Token Info') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Progress') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Sale Period') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($tokens as $token)
                        <tr>
                            <td data-label="{{ __('Token Info') }}">
                                <div class="token-info">
                                    <h6 class="mb-1">{{ $token->name }} ({{ $token->symbol }})</h6>
                                    <small class="text-muted">{{ Str::limit($token->description, 50) }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Price') }}">
                                <div class="price-info">
                                    <strong>${{ shortAmount($token->price, 4) }}</strong>
                                    @if($token->current_price != $token->price)
                                        <br><small class="text-muted">Current: {{ getCurrencySymbol() }}{{ shortAmount($token->current_price, 4) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td data-label="{{ __('Progress') }}">
                                @php
                                    $progress = $token->total_supply > 0 ? ($token->tokens_sold / $token->total_supply) * 100 : 0;
                                @endphp
                                <div class="progress-info">
                                    <div class="progress mb-1" style="height: 8px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <small>{{ shortAmount($token->tokens_sold) }} / {{ shortAmount($token->total_supply) }}</small>
                                    <br><small class="text-muted">{{ shortAmount($progress, 1) }}% sold</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Status') }}">
                                @if($token->status == 'active')
                                    <span class="badge badge--success">{{ __('Active') }}</span>
                                @elseif($token->status == 'paused')
                                    <span class="badge badge--warning">{{ __('Paused') }}</span>
                                @elseif($token->status == 'completed')
                                    <span class="badge badge--info">{{ __('Completed') }}</span>
                                @elseif($token->status == 'cancelled')
                                    <span class="badge badge--danger">{{ __('Cancelled') }}</span>
                                @else
                                    <span class="badge badge--secondary">{{ __('Unknown') }}</span>
                                @endif
                                @if($token->is_featured)
                                    <br><span class="badge badge--primary mt-1">{{ __('Featured') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Sale Period') }}">
                                <div class="sale-period">
                                    @if($token->sale_start_date)
                                        <small>{{ __('Start') }}: {{ showDateTime($token->sale_start_date, 'd M Y') }}</small>
                                    @endif
                                    @if($token->sale_end_date)
                                        <br><small>{{ __('End') }}: {{ showDateTime($token->sale_end_date, 'd M Y') }}</small>
                                    @endif
                                    @if(!$token->sale_start_date && !$token->sale_end_date)
                                        <small class="text-muted">{{ __('Not set') }}</small>
                                    @endif
                                </div>
                            </td>
                            <td data-label="{{ __('Actions') }}">
                                <a href="{{ route('admin.ico.token.edit', $token->id) }}" class="badge badge--primary-transparent">{{ __('Edit') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="6">{{ __('No tokens found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($tokens->hasPages())
                <div class="card-footer">
                    {{ $tokens->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
