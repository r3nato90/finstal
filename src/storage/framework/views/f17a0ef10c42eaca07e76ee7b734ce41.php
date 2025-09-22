<?php $__env->startSection('content'); ?>
    <div class="main-content" data-simplebar>
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><?php echo e(__('Support Tickets')); ?></h3>
                    <a href="<?php echo e(route('user.support-tickets.create')); ?>" class="i-btn btn--primary btn--sm">
                        <i class="fas fa-plus"></i> <?php echo e(__('Create Ticket')); ?>

                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="i-card-sm">
                    <div class="card-body">
                        <form method="GET" action="<?php echo e(route('user.support-tickets.index')); ?>" class="row g-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="search"
                                       placeholder="<?php echo e(__('Search by ticket number or subject')); ?>"
                                       value="<?php echo e(request('search')); ?>">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value=""><?php echo e(__('All Status')); ?></option>
                                    <option value="open" <?php echo e(request('status') == 'open' ? 'selected' : ''); ?>><?php echo e(__('Open')); ?></option>
                                    <option value="closed" <?php echo e(request('status') == 'closed' ? 'selected' : ''); ?>><?php echo e(__('Closed')); ?></option>
                                    <option value="resolved" <?php echo e(request('status') == 'resolved' ? 'selected' : ''); ?>><?php echo e(__('Resolved')); ?></option>
                                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="sort_field" class="form-control">
                                    <option value="created_at" <?php echo e(request('sort_field') == 'created_at' ? 'selected' : ''); ?>><?php echo e(__('Date Created')); ?></option>
                                    <option value="updated_at" <?php echo e(request('sort_field') == 'updated_at' ? 'selected' : ''); ?>><?php echo e(__('Last Updated')); ?></option>
                                    <option value="priority" <?php echo e(request('sort_field') == 'priority' ? 'selected' : ''); ?>><?php echo e(__('Priority')); ?></option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="sort_direction" class="form-control">
                                    <option value="desc" <?php echo e(request('sort_direction') == 'desc' ? 'selected' : ''); ?>><?php echo e(__('Descending')); ?></option>
                                    <option value="asc" <?php echo e(request('sort_direction') == 'asc' ? 'selected' : ''); ?>><?php echo e(__('Ascending')); ?></option>
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
                        <h4 class="title"><?php echo e(__('My Support Tickets')); ?></h4>
                        <span class="badge badge--primary"><?php echo e($tickets->total()); ?> <?php echo e(__('Total')); ?></span>
                    </div>
                    <div class="card-body">
                        <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="ticket-item border rounded p-3 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-start">
                                            <div class="me-3">
                                                <?php
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
                                                ?>
                                                <span class="badge badge--<?php echo e($statusColors[$ticket->status] ?? 'secondary'); ?>">
                                                    <?php echo e(ucfirst($ticket->status)); ?>

                                                </span>
                                                <span class="badge badge--<?php echo e($priorityColors[$ticket->priority] ?? 'secondary'); ?> ms-1">
                                                    <?php echo e(ucfirst($ticket->priority)); ?>

                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">
                                                    <a href="<?php echo e(route('user.support-tickets.show', $ticket)); ?>" class="text-decoration-none">
                                                        #<?php echo e($ticket->ticket_number); ?> - <?php echo e($ticket->subject); ?>

                                                    </a>
                                                </h6>
                                                <p class="text--muted mb-2"><?php echo e(Str::limit($ticket->description, 100)); ?></p>
                                                <div class="d-flex align-items-center gap-3 fs-12 text--light">
                                                    <span><i class="fas fa-calendar"></i> <?php echo e($ticket->created_at->format('M d, Y')); ?></span>
                                                    <?php if($ticket->category): ?>
                                                        <span><i class="fas fa-tag"></i> <?php echo e($ticket->category); ?></span>
                                                    <?php endif; ?>
                                                    <span><i class="fas fa-comments"></i> <?php echo e($ticket->replies_count); ?> <?php echo e(__('Replies')); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div class="mb-2">
                                            <small class="text--muted"><?php echo e(__('Last Updated')); ?></small><br>
                                            <span class="text-white"><?php echo e($ticket->updated_at->diffForHumans()); ?></span>
                                        </div>
                                        <a href="<?php echo e(route('user.support-tickets.show', $ticket)); ?>" class="i-btn btn--primary btn--sm">
                                            <i class="fas fa-eye"></i> <?php echo e(__('View')); ?>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-ticket-alt fs-48 text--muted mb-3"></i>
                                <h5 class="text--muted"><?php echo e(__('No Support Tickets Found')); ?></h5>
                                <p class="text--light mb-4"><?php echo e(__('You haven\'t created any support tickets yet.')); ?></p>
                                <a href="<?php echo e(route('user.support-tickets.create')); ?>" class="i-btn btn--primary btn--sm">
                                    <i class="fas fa-plus"></i> <?php echo e(__('Create Your First Ticket')); ?>

                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <?php if($tickets->hasPages()): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <?php echo e($tickets->links()); ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('style-push'); ?>
        <style>
            .ticket-item:hover {
                background-color: rgba(255, 255, 255, 0.05);
                transition: all 0.3s ease;
            }
            .ticket-item a:hover {
                color: var(--primary-color) !important;
            }
        </style>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/user/support-tickets/index.blade.php ENDPATH**/ ?>