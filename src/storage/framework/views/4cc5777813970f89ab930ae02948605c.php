<?php $__env->startSection('panel'); ?>
    <section>
        <div class="page-header">
            <h3 class="page-title"><?php echo e(__('Support Tickets Management')); ?></h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Tickets')); ?></h6>
                        <h4 class="text--dark"><?php echo e(shortAmount($stats['totalTickets'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Open Tickets')); ?></h6>
                        <h4 class="text--primary"><?php echo e(shortAmount($stats['openTickets'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('In Progress')); ?></h6>
                        <h4 class="text--warning"><?php echo e(shortAmount($stats['inProgressTickets'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Urgent Tickets')); ?></h6>
                        <h4 class="text--danger"><?php echo e(shortAmount($stats['urgentTickets'])); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.support-tickets.index')); ?>">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search"><?php echo e(__('Search')); ?></label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="<?php echo e(request('search')); ?>"
                                       placeholder="<?php echo e(__('Ticket # or User...')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status"><?php echo e(__('Status')); ?></label>
                                <select name="status" id="status" class="form-control">
                                    <option value=""><?php echo e(__('All Status')); ?></option>
                                    <option value="open" <?php echo e(request('status') == 'open' ? 'selected' : ''); ?>><?php echo e(__('Open')); ?></option>
                                    <option value="in_progress" <?php echo e(request('status') == 'in_progress' ? 'selected' : ''); ?>><?php echo e(__('In Progress')); ?></option>
                                    <option value="resolved" <?php echo e(request('status') == 'resolved' ? 'selected' : ''); ?>><?php echo e(__('Resolved')); ?></option>
                                    <option value="closed" <?php echo e(request('status') == 'closed' ? 'selected' : ''); ?>><?php echo e(__('Closed')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="priority"><?php echo e(__('Priority')); ?></label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value=""><?php echo e(__('All Priorities')); ?></option>
                                    <option value="low" <?php echo e(request('priority') == 'low' ? 'selected' : ''); ?>><?php echo e(__('Low')); ?></option>
                                    <option value="medium" <?php echo e(request('priority') == 'medium' ? 'selected' : ''); ?>><?php echo e(__('Medium')); ?></option>
                                    <option value="high" <?php echo e(request('priority') == 'high' ? 'selected' : ''); ?>><?php echo e(__('High')); ?></option>
                                    <option value="urgent" <?php echo e(request('priority') == 'urgent' ? 'selected' : ''); ?>><?php echo e(__('Urgent')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field"><?php echo e(__('Sort By')); ?></label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" <?php echo e((request('sort_field') ?? 'created_at') == 'created_at' ? 'selected' : ''); ?>><?php echo e(__('Date Created')); ?></option>
                                    <option value="ticket_number" <?php echo e(request('sort_field') == 'ticket_number' ? 'selected' : ''); ?>><?php echo e(__('Ticket Number')); ?></option>
                                    <option value="subject" <?php echo e(request('sort_field') == 'subject' ? 'selected' : ''); ?>><?php echo e(__('Subject')); ?></option>
                                    <option value="priority" <?php echo e(request('sort_field') == 'priority' ? 'selected' : ''); ?>><?php echo e(__('Priority')); ?></option>
                                    <option value="status" <?php echo e(request('sort_field') == 'status' ? 'selected' : ''); ?>><?php echo e(__('Status')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block"><?php echo e(__('Filter')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><?php echo e(__('Support Tickets')); ?></h5>
                <div class="card-tools">
                    <span class="text-muted"><?php echo e(__('View Only Mode')); ?></span>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th><?php echo e(__('Ticket #')); ?></th>
                        <th><?php echo e(__('User')); ?></th>
                        <th><?php echo e(__('Subject')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th><?php echo e(__('Priority')); ?></th>
                        <th><?php echo e(__('Assigned To')); ?></th>
                        <th><?php echo e(__('Replies')); ?></th>
                        <th><?php echo e(__('Created')); ?></th>
                        <th><?php echo e(__('Last Updated')); ?></th>
                        <th><?php echo e(__('Actions')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo e(__('Ticket #')); ?>">
                                <strong>#<?php echo e($ticket->ticket_number); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('User')); ?>">
                                <div class="user-info">
                                    <strong><?php echo e($ticket->user->name ?? 'Unknown'); ?></strong>
                                    <br><small class="text-muted"><?php echo e($ticket->user->email ?? 'N/A'); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Subject')); ?>">
                                <div class="subject-info">
                                    <strong><?php echo e(Str::limit($ticket->subject, 30)); ?></strong>
                                    <?php if($ticket->category): ?>
                                        <br><small class="text-muted"><?php echo e($ticket->category); ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Status')); ?>">
                                <?php
                                    $statusClass = match($ticket->status) {
                                        'open' => 'badge--primary',
                                        'in_progress' => 'badge--warning',
                                        'resolved' => 'badge--success',
                                        'closed' => 'badge--secondary',
                                        default => 'badge--secondary'
                                    };
                                ?>
                                <span class="badge <?php echo e($statusClass); ?>"><?php echo e(strtoupper($ticket->status)); ?></span>
                            </td>
                            <td data-label="<?php echo e(__('Priority')); ?>">
                                <?php
                                    $priorityClass = match($ticket->priority) {
                                        'low' => 'badge--info',
                                        'medium' => 'badge--primary',
                                        'high' => 'badge--warning',
                                        'urgent' => 'badge--danger',
                                        default => 'badge--secondary'
                                    };
                                ?>
                                <span class="badge <?php echo e($priorityClass); ?>"><?php echo e(strtoupper($ticket->priority)); ?></span>
                            </td>
                            <td data-label="<?php echo e(__('Assigned To')); ?>">
                                <?php if($ticket->assignedTo): ?>
                                    <span class="text-primary fw-bold"><?php echo e($ticket->assignedTo->name); ?></span>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo e(__('Unassigned')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Replies')); ?>">
                                <span class="badge badge--info-transparent"><?php echo e($ticket->replies_count); ?></span>
                            </td>
                            <td data-label="<?php echo e(__('Created')); ?>">
                                <div class="time-info">
                                    <strong class="text-dark"><?php echo e($ticket->created_at->format('M d, Y')); ?></strong>
                                    <br><small class="text-muted"><?php echo e($ticket->created_at->format('h:i A')); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Last Updated')); ?>">
                                <div class="time-info">
                                    <strong class="text-dark"><?php echo e($ticket->updated_at->format('M d, Y')); ?></strong>
                                    <br><small class="text-muted"><?php echo e($ticket->updated_at->diffForHumans()); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Actions')); ?>">
                                <a href="<?php echo e(route('admin.support-tickets.show', $ticket)); ?>"
                                   class="badge badge--primary-transparent">
                                    <i class="fa fa-eye"></i> <?php echo e(__('View')); ?>

                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-muted text-center" colspan="10"><?php echo e(__('No support tickets found')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($tickets->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($tickets->appends(request()->all())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            <?php if(request()->get('status') === 'open' || !request()->get('status')): ?>
            setInterval(function() {
                if ($('.badge--primary:contains("OPEN")').length > 0) {
                    window.location.reload();
                }
            }, 120000);
            <?php endif; ?>

            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-push'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/support-tickets/index.blade.php ENDPATH**/ ?>