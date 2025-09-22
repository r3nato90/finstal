<?php $__env->startSection('panel'); ?>
    <section class="mt-3 rounded_box">
        <div class="container-fluid p-0 mb-3 pb-2">
            <div class="row d-flex align-items-start rounded">
                <div class="col-xxl-3 col-xl-4 col-lg-5 mb-30">
                    <div class="card b-radius-5 overflow-hidden profile-card">
                        <div class="card-body">
                            <div class="d-flex p-2 bg--lite--violet align-items-center mb-3 flex-column gap-2">
                                <div class="avatar avatar--xl">
                                    <img src="<?php echo e(displayImage(auth()->guard('admin')->user()->image)); ?>" alt="<?php echo e(auth()->guard('admin')->user()->name); ?>">
                                </div>
                                <div class="pl-3">
                                    <h5 class="text--light m-0 p-0"><?php echo e($admin->name); ?></h5>
                                </div>
                            </div>
                            <ul class="list-group gap-1 mb-0">
                                <li class="list-group-item d-flex justify-content-between align-items-center text--dark fw-bold bg--light border-0">
                                    <?php echo e(__('Name')); ?><span class="fw-normal"><?php echo e($admin->name); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center text--dark fw-bold bg--light border-0">
                                    <?php echo e(__('Username')); ?><span class="fw-normal"><?php echo e($admin->username); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center text--dark fw-bold bg--light border-0">
                                    <?php echo e(__('Email')); ?><span class="fw-normal"><?php echo e($admin->email); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-9 col-xl-8 col-lg-7">
                    <div class="card mb-3">
                        <div class="p-3">
                            <ul class="nav nav-style-two nav-pills mb-1 gap-3 justify-content-center" id="pills-tab" role="tablist">
                                <li class="nav-item flex-grow-1" role="presentation">
                                    <button class=" nav-link w-100 text-center active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Profile Setting</button>
                                </li>
                                <li class="nav-item flex-grow-1" role="presentation">
                                    <button class=" nav-link w-100 text-center" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Password Update</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4 class="card-title"><?php echo e(__('Profile Update')); ?></h4>
                                </div>
                                <div class="card-body">
                                    <form action="<?php echo e(route('admin.profile.update')); ?>" method="POST" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="mb-3">
                                            <label for="name" class="form-label"><?php echo e(__('Name')); ?></label>
                                            <input type="text" class="form-control" id="name" value="<?php echo e($admin->name); ?>" placeholder="<?php echo e(__('Enter Name')); ?>" name="name">
                                        </div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label"><?php echo e(__('Username')); ?></label>
                                            <input type="text" class="form-control" id="username" value="<?php echo e($admin->username); ?>" name="username">
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label"><?php echo e(__('Email')); ?></label>
                                            <input type="email" class="form-control" id="email" value="<?php echo e($admin->email); ?>" name="email">
                                        </div>

                                        <div class="mb-3">
                                            <label for="image" class="form-label"><?php echo e(__('Image')); ?></label>
                                            <input type="file" class="form-control" id="image" name="image">
                                        </div>

                                        <button type="submit" class="btn btn--primary btn--md"><?php echo e(__('Submit')); ?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?php echo e(__('Password Update')); ?></h5>
                                </div>
                                <div class="card-body">
                                    <form action="<?php echo e(route('admin.password.update')); ?>" method="post" class="needs-validation">
                                        <?php echo csrf_field(); ?>
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label"><?php echo app('translator')->get('Current Password'); ?> <sup class="text-danger">*</sup></label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter Current Password" required="">
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label"><?php echo app('translator')->get('New Password'); ?> <sup class="text-danger">*</sup></label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password" required="">
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label"><?php echo app('translator')->get('Confirm Password'); ?> <sup class="text-danger">*</sup></label>
                                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Enter Confirm Password" required="">
                                        </div>
                                        <button class="btn btn--primary btn--md"><?php echo app('translator')->get('Save Changes'); ?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/profile.blade.php ENDPATH**/ ?>