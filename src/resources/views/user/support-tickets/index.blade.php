@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ __('Support Tickets') }}</h3>
                    <a href="{{ route('user.support-tickets.create') }}" class="i-btn btn--primary btn--sm">
                        <i class="fas fa-plus"></i> {{ __('Create Ticket') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="i-card-sm">
                    <div class="card-body">
                        <form method="GET" action="{{ route('user.support-tickets.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="search"
                                       placeholder="{{ __('Search by ticket number or subject') }}"
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">{{ __('All Status') }}</option>
                                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>{{ __('Open') }}</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>{{ __('Closed') }}</option>
                                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>{{ __('Resolved') }}</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="sort_field" class="form-control">
                                    <option value="created_at" {{ request('sort_field') == 'created_at' ? 'selected' : '' }}>{{ __('Date Created') }}</option>
                                    <option value="updated_at" {{ request('sort_field') == 'updated_at' ? 'selected' : '' }}>{{ __('Last Updated') }}</option>
                                    <option value="priority" {{ request('sort_field') == 'priority' ? 'selected' : '' }}>{{ __('Priority') }}</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="sort_direction" class="form-control">
                                    <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>{{ __('Descending') }}</option>
                                    <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>{{ __('Ascending') }}</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="i-btn btn--primary btn--sm w-100">
                                   Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets List -->
        <div class="row">
            <div class="col-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">{{ __('My Support Tickets') }}</h4>
                        <span class="badge badge--primary">{{ $tickets->total() }} {{ __('Total') }}</span>
                    </div>
                    <div class="card-body">
                        @forelse($tickets as $ticket)
                            <div class="ticket-item border rounded p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-start">
                                            <div class="me-3">
                                                @php
                                                    $statusColors = [
                                                        'open' => 'success',
                                                        'closed' => 'danger',
                                                        'resolved' => 'info',
                                                        'pending' => 'warning'
                                                    ];
                                                    $priorityColors = [
                                                        'low' => 'secondary',
                                                        'medium' => 'primary',
                                                        'high' => 'warning',
                                                        'urgent' => 'danger'
                                                    ];
                                                @endphp
                                                <span class="badge badge--{{ $statusColors[$ticket->status] ?? 'secondary' }}">
                                                    {{ ucfirst($ticket->status) }}
                                                </span>
                                                <span class="badge badge--{{ $priorityColors[$ticket->priority] ?? 'secondary' }} ms-1">
                                                    {{ ucfirst($ticket->priority) }}
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">
                                                    <a href="{{ route('user.support-tickets.show', $ticket) }}" class="text-decoration-none">
                                                        #{{ $ticket->ticket_number }} - {{ $ticket->subject }}
                                                    </a>
                                                </h6>
                                                <p class="text--muted mb-2">{{ Str::limit($ticket->description, 100) }}</p>
                                                <div class="d-flex align-items-center gap-3 fs-12 text--light">
                                                    <span><i class="fas fa-calendar"></i> {{ $ticket->created_at->format('M d, Y') }}</span>
                                                    @if($ticket->category)
                                                        <span><i class="fas fa-tag"></i> {{ $ticket->category }}</span>
                                                    @endif
                                                    <span><i class="fas fa-comments"></i> {{ $ticket->replies_count }} {{ __('Replies') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div class="mb-2">
                                            <small class="text--muted">{{ __('Last Updated') }}</small><br>
                                            <span class="text-white">{{ $ticket->updated_at->diffForHumans() }}</span>
                                        </div>
                                        <a href="{{ route('user.support-tickets.show', $ticket) }}" class="i-btn btn--primary btn--sm">
                                            <i class="fas fa-eye"></i> {{ __('View') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-ticket-alt fs-48 text--muted mb-3"></i>
                                <h5 class="text--muted">{{ __('No Support Tickets Found') }}</h5>
                                <p class="text--light mb-4">{{ __('You haven\'t created any support tickets yet.') }}</p>
                                <a href="{{ route('user.support-tickets.create') }}" class="i-btn btn--primary btn--sm">
                                    <i class="fas fa-plus"></i> {{ __('Create Your First Ticket') }}
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($tickets->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('style-push')
        <style>
            .ticket-item:hover {
                background-color: rgba(255, 255, 255, 0.05);
                transition: all 0.3s ease;
            }
            .ticket-item a:hover {
                color: var(--primary-color) !important;
            }
        </style>
    @endpush
@endsection
