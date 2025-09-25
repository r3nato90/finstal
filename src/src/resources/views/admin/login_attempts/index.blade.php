@extends('admin.layouts.main')

@section('panel')
    <section>
        <!-- Page Header -->
        <div class="page-header">
            <h3 class="page-title">{{ __('Login Attempts') }}</h3>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="card-title text-muted mb-0">{{ __('Total Attempts') }}</p>
                                <h6 class="font-weight-bold mb-0">{{ $statistics['total_attempts'] ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="card-title text-muted mb-0">{{ __('Successful') }}</p>
                                <h6 class="font-weight-bold mb-0 text--success">{{ $statistics['successful_attempts'] ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="card-title text-muted mb-0">{{ __('Failed') }}</p>
                                <h6 class="font-weight-bold mb-0 text--danger">{{ $statistics['failed_attempts'] ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="card-title text-muted mb-0">{{ __('Success Rate') }}</p>
                                <h6 class="font-weight-bold mb-0 text--info">{{ $statistics['success_rate'] ?? 0 }}%</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.login-attempts.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('Search') }}</label>
                                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="{{ __('Email, IP, Location...') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('Status') }}</label>
                                <select name="successful" class="form-control">
                                    <option value="">{{ __('All') }}</option>
                                    <option value="1" {{ request('successful') == '1' ? 'selected' : '' }}>{{ __('Successful') }}</option>
                                    <option value="0" {{ request('successful') == '0' ? 'selected' : '' }}>{{ __('Failed') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('Device Type') }}</label>
                                <select name="device_type" class="form-control">
                                    <option value="">{{ __('All') }}</option>
                                    @foreach($filterOptions['device_types'] ?? [] as $deviceType)
                                        <option value="{{ $deviceType }}" {{ request('device_type') == $deviceType ? 'selected' : '' }}>
                                            {{ ucfirst($deviceType) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('Date From') }}</label>
                                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{ __('Date To') }}</label>
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn--primary w-100">
                                    <i class="las la-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="filter-action mb-4">
            <button type="button" class="i-btn btn--danger btn--md" data-bs-toggle="modal" data-bs-target="#clearOldModal">
                <i class="las la-trash"></i> {{ __('Clear Old Records') }}
            </button>
        </div>

        <!-- Login Attempts Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('Login Attempts') }}</h5>
                <div class="card-tools">
                    <span class="text-muted">
                        Showing {{ $loginAttempts->firstItem() ?? 0 }} to {{ $loginAttempts->lastItem() ?? 0 }}
                        of {{ $loginAttempts->total() ?? 0 }} login attempts
                    </span>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('IP & Location') }}</th>
                        <th>{{ __('Device Info') }}</th>
                        <th>  {{ __('Status') }}</th>
                        <th> {{ __('Date') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($loginAttempts as $attempt)
                        <tr>
                            <td data-label="{{ __('User') }}">
                                <div class="user-info">
                                    <h6 class="mb-1">{{ $attempt->user ? $attempt->user->fullname : __('Unknown') }}</h6>
                                    <small class="text-muted">{{ $attempt->email }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('IP & Location') }}">
                                <div class="location-info">
                                    <strong>{{ $attempt->ip_address }}</strong>
                                    @if($attempt->location)
                                        <br><small class="text-muted">{{ $attempt->location }}</small>
                                    @endif
                                </div>
                            </td>
                            <td data-label="{{ __('Device Info') }}">
                                <div class="device-info">
                                    @if($attempt->device_type)
                                        <span class="badge badge--info">{{ ucfirst($attempt->device_type) }}</span>
                                    @endif
                                    @if($attempt->browser)
                                        <br><small class="text-muted">{{ $attempt->browser }}</small>
                                    @endif
                                    @if($attempt->platform)
                                        <br><small class="text-muted">{{ $attempt->platform }}</small>
                                    @endif
                                </div>
                            </td>
                            <td data-label="{{ __('Status') }}">
                                @if($attempt->successful)
                                    <span class="badge badge--success">{{ __('Success') }}</span>
                                @else
                                    <span class="badge badge--danger">{{ __('Failed') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Date') }}">
                                <div class="date-info">
                                    <strong>{{ $attempt->attempted_at->format('d M Y') }}</strong>
                                    <br><small class="text-muted">{{ $attempt->attempted_at->format('H:i:s') }}</small>
                                    <br><small class="text-muted">{{ $attempt->attempted_at->diffForHumans() }}</small>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="5">{{ __('No login attempts found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            {{ $loginAttempts->appends(request()->all())->links() }}
        </div>
    </section>

    <div class="modal fade" id="clearOldModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Clear Old Login Attempts') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.login-attempts.clear-old') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('Delete attempts older than (days)') }}</label>
                            <input type="number" name="days" class="form-control" value="30" min="1" max="365" required>
                            <small class="form-text text-muted">{{ __('This action cannot be undone') }}</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn--danger">{{ __('Delete Records') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
