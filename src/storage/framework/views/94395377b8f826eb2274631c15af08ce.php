<?php $__env->startSection('panel'); ?>
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo e($setTitle); ?></h4>
                </div>

                <div class="card-body">
                    <form action="<?php echo e(route('admin.binary.update')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" value="<?php echo e($scheme->uid); ?>" name="uid">

                        <div class="row g-4 mb-3">
                            <div class="col-lg-6">
                                <label class="form-label" for="name"><?php echo app('translator')->get('Name'); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo e($scheme->name); ?>" required>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label" for="type"><?php echo app('translator')->get('Type'); ?> <sup class="text-danger">*</sup></label>
                                <select class="form-select range-type" id="type" name="type" required>
                                    <?php $__currentLoopData = \App\Enums\Investment\InvestmentRage::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php if($scheme->type == $status): ?> selected <?php endif; ?>><?php echo e(replaceInputTitle($key)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="row amount-fields"></div>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="interest_type"><?php echo app('translator')->get('Interest Type'); ?> <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="interest_type" name="interest_type" required>
                                    <?php $__currentLoopData = \App\Enums\Investment\InterestType::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php if($scheme->interest_type == $status): ?> selected <?php endif; ?>><?php echo e(replaceInputTitle($key)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="mb-3 col-lg-6">
                                <label for="interest_rate" class="form-label"><?php echo app('translator')->get('Interest Rate'); ?> <sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="interest_rate"
                                       name="interest_rate" value="<?php echo e(getAmount($scheme->interest_rate)); ?>" placeholder="<?php echo app('translator')->get('Enter rate'); ?>"
                                       aria-describedby="basic-addon1" required>
                                    <span class="input-group-text" id="basic-addon1">%</span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="time"><?php echo app('translator')->get('Time'); ?> <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="time" name="time_id" required>
                                    <option value="" selected disabled><?php echo app('translator')->get('Select Time'); ?></option>
                                    <?php $__currentLoopData = $timeTables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timeTable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($timeTable->id); ?>" <?php if($timeTable->id == $scheme->time_id): ?> selected <?php endif; ?>><?php echo e(__($timeTable->name)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="interest_return_type"><?php echo app('translator')->get('Return Type'); ?> <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="interest_return_type" name="interest_return_type" required>
                                    <?php $__currentLoopData = \App\Enums\Investment\ReturnType::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php if($scheme->interest_return_type == $status): ?> selected <?php endif; ?>><?php echo e(__(\App\Enums\Investment\ReturnType::getName($status))); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="row interest-return-type-fields"></div>

                        <div class="row mb-4">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label"><?php echo app('translator')->get('Is Recommend'); ?> <sup class="text-danger">*</sup></label>
                                <div class="border px-2 py-2 rounded">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" <?php if($scheme->is_recommend): ?> checked <?php endif; ?> value="1" name="is_recommend" id="flexCheckChecked" >
                                        <label class="form-check-label" for="flexCheckChecked"><?php echo e(__('Yes')); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="status"><?php echo app('translator')->get('Status'); ?> <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" selected disabled><?php echo app('translator')->get('Select Status'); ?></option>
                                    <?php $__currentLoopData = \App\Enums\Status::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>" <?php if($scheme->status == $status): ?> selected <?php endif; ?>><?php echo e(replaceInputTitle($key)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="mb-4 col-lg-12">
                                <label for="terms_policy" class="form-label"><?php echo e(__('Terms Policy')); ?><sup class="text-danger">*</sup></label>
                                <textarea class="form-control" name="terms_policy" id="terms_policy" rows="3" required>
                                    <?php echo e($scheme->terms_policy); ?>

                                </textarea>
                            </div>

                            <div class="col-lg-12">
                                <div class="shadow-md border p-3 bg-body rounded ">
                                    <h5><?php echo app('translator')->get('Features'); ?></h5>
                                    <hr>
                                    <div class="row mb-5 gy-3 gx-2">
                                        <div class="col-lg-10 col-md-8 col-sm-12">
                                            <?php echo app('translator')->get('To add scheme features, please click the "Add New" button located on the right-hand side.'); ?>
                                        </div>

                                        <div class="col-lg-2 col-md-4 col-sm-12">
                                            <a href="javascript:void(0)" class="btn btn--primary btn--md text-light border-0 rounded features">
                                                <i class="las la-plus"></i> <?php echo app('translator')->get('Add New'); ?>
                                            </a>
                                        </div>
                                    </div>

                                    <?php if(!empty($scheme->meta)): ?>
                                        <?php $__currentLoopData = $scheme->meta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="row item gx-2">
                                                <div class="mb-3 col-lg-10">
                                                    <input name="features[]" class="form-control" type="text" value="<?php echo e($value); ?>" required placeholder="<?php echo app('translator')->get('Enter feature'); ?>">
                                                </div>

                                                <div class="col-lg-2 mt-md-0 mt-2 text-right">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-danger remove-item w-100" type="button">
                                                            <i class="las la-times"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <div class="add-data"></div>
                                </div>
                            </div>
                        </div>

                        <button class="i-btn btn--primary btn--lg"><?php echo app('translator')->get('Submit'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            const createNewData = () => {
                const html = `
                    <div class="row item">
                         <div class="mb-3 col-lg-10">
                             <input name="features[]" class="form-control" type="text" required placeholder="<?php echo app('translator')->get('Enter feature'); ?>">
                         </div>

                        <div class="col-lg-2 mt-md-0 mt-2 text-right">
                            <span class="input-group-btn">
                                <button class="btn btn-danger remove-item w-100" type="button">
                                    <i class="las la-times"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                  `;
                $('.add-data').append(html);
            };

            const removeData = (event) => {
                const item = $(event.target).closest('.item');
                if (item.length) {
                    item.remove();
                }
            };

            $('.features').on('click', createNewData);

            $(document).on('click', '.remove-item', function (event) {
                removeData(event);
            });

            function getInvestType(type) {
                let amount;
                if (type == 1) {
                    amount = `
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="minimum"><?php echo app('translator')->get('Minimum'); ?> <sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <?php echo e(getCurrencySymbol()); ?>

                                </div>
                                <input type="number" class="form-control" id="minimum" name="minimum" value="<?php echo e(getAmount($scheme->minimum)); ?>" placeholder="<?php echo app('translator')->get('Enter Amount'); ?>" step="any" required>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="maximum"><?php echo app('translator')->get('Maximum'); ?> <sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <?php echo e(getCurrencySymbol()); ?>

                                </div>
                                 <input type="number" class="form-control" id="maximum" name="maximum" value="<?php echo e(getAmount($scheme->maximum)); ?>" placeholder="<?php echo app('translator')->get('Enter Amount'); ?>" step="any" required>
                            </div>
                        </div>`;
                } else {
                    amount = `
                        <div class="col-lg-12 mb-3">
                            <label class="form-label" for="minimum"><?php echo app('translator')->get('Amount'); ?> <sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <?php echo e(getCurrencySymbol()); ?>

                                </div>
                                <input type="number" class="form-control" id="amount" name="amount" value="<?php echo e(getAmount($scheme->amount)); ?>"  placeholder="<?php echo app('translator')->get('Enter Amount'); ?>" step="any" required>
                            </div>
                        </div>`;
                }

                $('.amount-fields').html(amount);
            }

            function createInterestFields(type) {
                if (type == 2) {
                    var interestFields = `
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="repeat_time"><?php echo app('translator')->get('Repeat Times'); ?> <sup class="text-danger">*</sup></label>
                            <input type="text" name="repeat_time" id="repeat_time" value="<?php echo e(shortAmount($scheme->duration)); ?>" class="form-control" placeholder="<?php echo app('translator')->get('Enter Number'); ?>">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="recapture_type"><?php echo app('translator')->get('Investment Recapture'); ?> <sup class="text-danger">*</sup></label>
                            <select class="form-select" id="recapture_type" name="recapture_type">
                             <?php $__currentLoopData = \App\Enums\Investment\Recapture::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>" <?php if($scheme->recapture_type == $status): ?> selected <?php endif; ?>><?php echo e(__(\App\Enums\Investment\Recapture::getName($status))); ?></option>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="form-text"> <?php echo app('translator')->get("Hold means the user can reinvest this amount or transfer it to the user's main account after completing the profit."); ?></div>
                        </div>`;

                    $('.interest-return-type-fields').html(interestFields);
                }else{
                    $('.interest-return-type-fields').empty();
                }
            }

            $(".range-type").on('change', function () {
                const type = $('#type').val();
                getInvestType(type);
            }).change();

            $("#interest_type").on('change', function () {
                const interestType = $('#interest_type').val();
                getInterestType(interestType);
            }).change();

            $("#interest_return_type").on('change', function () {
                const type = $('#interest_return_type').val();
                createInterestFields(type);
            }).change();

            function getInterestType(type){
                let interestValue = "%";
                if (type == 2){
                    interestValue = "<?php echo e(getCurrencyName()); ?>"
                }
                $(".intertest-rate-symbol").text(interestValue);
            }
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/binary/edit.blade.php ENDPATH**/ ?>