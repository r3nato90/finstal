@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <!-- Stats Cards -->
            <div class="col-lg-3 col-md-6">
                <div class="i-card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="ms-3">
                                <h5 class="mb-0">{{ $stats['total_attempts'] ?? 0 }}</h5>
                                <p class="text-white mb-0">{{ __('Total Attempts') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="i-card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="ms-3">
                                <h5 class="mb-0">{{ $stats['successful_logins'] ?? 0 }}</h5>
                                <p class="text-white mb-0">{{ __('Successful Logins') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="i-card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="ms-3">
                                <h5 class="mb-0">{{ $stats['failed_attempts'] ?? 0 }}</h5>
                                <p class="text-white mb-0">{{ __('Failed Attempts') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="i-card-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="ms-3">
                                <h5 class="mb-0">{{ $stats['unique_ips'] ?? 0 }}</h5>
                                <p class="text-white mb-0">{{ __('Unique IPs') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-container">
                                    <table id="myTable" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{ __('Date & Time') }}</th>
                                                <th scope="col">{{ __('IP Address') }}</th>
                                                <th scope="col">{{ __('Location') }}</th>
                                                <th scope="col">{{ __('Device') }}</th>
                                                <th scope="col">{{ __('Status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($loginHistory as $history)
                                            <tr>
                                                <td>
                                                    <span>{{ $history->attempted_at->format('M d, Y') }}</span><br>
                                                    <small class="text-white">{{ $history->attempted_at->format('h:i A') }}</small>
                                                </td>
                                                <td>
                                                    <span>{{ $history->ip_address }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $history->location ?? 'Unknown' }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ Str::limit($history->user_agent ?? 'Unknown', 30) }}</span>
                                                </td>
                                                <td>
                                                    @if($history->successful)
                                                        <span class="i-badge bg--primary">{{ __('Success') }}</span>
                                                    @else
                                                        <span class="i-badge  bg--danger">{{ __('Failed') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">{{ $loginHistory->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
