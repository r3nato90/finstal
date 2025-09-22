@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <h3 class="page-title">{{ __('Support Tickets Management') }}</h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Tickets') }}</h6>
                        <h4 class="text--dark">{{ shortAmount($stats['totalTickets']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Open Tickets') }}</h6>
                        <h4 class="text--primary">{{ shortAmount($stats['openTickets']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('In Progress') }}</h6>
                        <h4 class="text--warning">{{ shortAmount($stats['inProgressTickets']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Urgent Tickets') }}</h6>
                        <h4 class="text--danger">{{ shortAmount($stats['urgentTickets']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.support-tickets.index') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ request('search') }}"
                                       placeholder="{{ __('Ticket # or User...') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">{{ __('All Status') }}</option>
                                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>{{ __('Open') }}</option>
                                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>{{ __('Resolved') }}</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>{{ __('Closed') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="priority">{{ __('Priority') }}</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="">{{ __('All Priorities') }}</option>
                                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>{{ __('Low') }}</option>
                                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>{{ __('Medium') }}</option>
                                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>{{ __('High') }}</option>
                                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>{{ __('Urgent') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field">{{ __('Sort By') }}</label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" {{ (request('sort_field') ?? 'created_at') == 'created_at' ? 'selected' : '' }}>{{ __('Date Created') }}</option>
                                    <option value="ticket_number" {{ request('sort_field') == 'ticket_number' ? 'selected' : '' }}>{{ __('Ticket Number') }}</option>
                                    <option value="subject" {{ request('sort_field') == 'subject' ? 'selected' : '' }}>{{ __('Subject') }}</option>
                                    <option value="priority" {{ request('sort_field') == 'priority' ? 'selected' : '' }}>{{ __('Priority') }}</option>
                                    <option value="status" {{ request('sort_field') == 'status' ? 'selected' : '' }}>{{ __('Status') }}</option>
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('Support Tickets') }}</h5>
                <div class="card-tools">
                    <span class="text-muted">{{ __('View Only Mode') }}</span>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th>{{ __('Ticket #') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Subject') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Priority') }}</th>
                        <th>{{ __('Assigned To') }}</th>
                        <th>{{ __('Replies') }}</th>
                        <th>{{ __('Created') }}</th>
                        <th>{{ __('Last Updated') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tickets as $ticket)
                        <tr>
                            <td data-label="{{ __('Ticket #') }}">
                                <strong>#{{ $ticket->ticket_number }}</strong>
                            </td>
                            <td data-label="{{ __('User') }}">
                                <div class="user-info">
                                    <strong>{{ $ticket->user->name ?? 'Unknown' }}</strong>
                                    <br><small class="text-muted">{{ $ticket->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Subject') }}">
                                <div class="subject-info">
                                    <strong>{{ Str::limit($ticket->subject, 30) }}</strong>
                                    @if($ticket->category)
                                        <br><small class="text-muted">{{ $ticket->category }}</small>
                                    @endif
                                </div>
                            </td>
                            <td data-label="{{ __('Status') }}">
                                @php
                                    $statusClass = match($ticket->status) {
                                        'open' => 'badge--primary',
                                        'in_progress' => 'badge--warning',
                                        'resolved' => 'badge--success',
                                        'closed' => 'badge--secondary',
                                        default => 'badge--secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ strtoupper($ticket->status) }}</span>
                            </td>
                            <td data-label="{{ __('Priority') }}">
                                @php
                                    $priorityClass = match($ticket->priority) {
                                        'low' => 'badge--info',
                                        'medium' => 'badge--primary',
                                        'high' => 'badge--warning',
                                        'urgent' => 'badge--danger',
                                        default => 'badge--secondary'
                                    };
                                @endphp
                                <span class="badge {{ $priorityClass }}">{{ strtoupper($ticket->priority) }}</span>
                            </td>
                            <td data-label="{{ __('Assigned To') }}">
                                @if($ticket->assignedTo)
                                    <span class="text-primary fw-bold">{{ $ticket->assignedTo->name }}</span>
                                @else
                                    <span class="text-muted">{{ __('Unassigned') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Replies') }}">
                                <span class="badge badge--info-transparent">{{ $ticket->replies_count }}</span>
                            </td>
                            <td data-label="{{ __('Created') }}">
                                <div class="time-info">
                                    <strong class="text-dark">{{ $ticket->created_at->format('M d, Y') }}</strong>
                                    <br><small class="text-muted">{{ $ticket->created_at->format('h:i A') }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Last Updated') }}">
                                <div class="time-info">
                                    <strong class="text-dark">{{ $ticket->updated_at->format('M d, Y') }}</strong>
                                    <br><small class="text-muted">{{ $ticket->updated_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Actions') }}">
                                <a href="{{ route('admin.support-tickets.show', $ticket) }}"
                                   class="badge badge--primary-transparent">
                                    <i class="fa fa-eye"></i> {{ __('View') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="10">{{ __('No support tickets found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($tickets->hasPages())
                <div class="card-footer">
                    {{ $tickets->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            @if(request()->get('status') === 'open' || !request()->get('status'))
            setInterval(function() {
                if ($('.badge--primary:contains("OPEN")').length > 0) {
                    window.location.reload();
                }
            }, 120000);
            @endif

            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush

@push('style-push')
    <style>
        .user-info strong {
            color: #fff;
        }
        .subject-info strong {
            color: #fff;
        }
        .time-info strong {
            color: #fff;
        }
        .responsive-table table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
        .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
@endpush
