<div class="form-wrapper bg--light">
    <h5 class="mb-2"> <?php echo e(__($title)); ?></h5>
    <div class="row g-4">
        <div class="col-xl-10 col-lg-9 col-md-8 col-sm-12">
            <?php echo e(__($details)); ?>

        </div>

        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12">
            <a href="javascript:void(0)" class="i-btn btn--primary btn--md border-0 rounded new-data w-100"><i class="las la-plus"></i>  <?php echo e(__('Add New')); ?></a>
        </div>
    </div>

    <?php if(!is_null($parameter)): ?>
        <?php $__currentLoopData = $parameter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="row remove-field my-2 g-3 align-items-center">
                <div class="mb-3 col-lg-5">
                    <input name="field_name[]" class="form-control" value="<?php echo e(getArrayFromValue($value, 'field_label')); ?>" type="text" placeholder=" <?php echo e(__('Field Name')); ?>">
                </div>

                <div class="mb-3 col-lg-5">
                    <select name="field_type[]" class="form-select">
                        <option value="text" <?php if(getArrayFromValue($value, 'field_type') == "text"): ?> selected <?php endif; ?>><?php echo e(__('Input Text')); ?></option>
                        <option value="file" <?php if(getArrayFromValue($value, 'field_type') == "file"): ?> selected <?php endif; ?>><?php echo e(__('File')); ?></option>
                        <option value="textarea" <?php if(getArrayFromValue($value, 'field_type') == "textarea"): ?> selected <?php endif; ?>> <?php echo e(__('Textarea')); ?> </option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-12 mt-md-0 mt-2 text-right">
                    <span class="input-group-btn">
                        <button class="i-btn btn--danger btn--md text--white removeBtn w-100" type="button">
                            <i class="las la-times"></i>
                        </button>
                    </span>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <div class="payment-gateway-information-add"></div>
</div>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $('.new-data').on('click', function(){
                const html = `
		        <div class="row remove-field my-2">
		    		<div class="mb-3 col-lg-5">
						<input name="field_name[]" class="form-control" type="text" required placeholder=" <?php echo e(__('Field Name')); ?>">
					</div>

					<div class="mb-3 col-lg-5">
						<select name="field_type[]" class="form-control">
	                        <option value="text">  <?php echo e(__('Input Text')); ?> </option>
	                        <option value="file">  <?php echo e(__('File')); ?> </option>
	                        <option value="textarea"> <?php echo e(__('Textarea')); ?> </option>
	                    </select>
					</div>

		    		<div class="col-lg-2 col-md-12 mt-md-0 mt-2 text-right">
		                <span class="input-group-btn">
		                    <button class="i-btn btn--danger btn--md text--white removeBtn w-100" type="button">
		                        <i class="las la-times"></i>
		                    </button>
		                </span>
		            </div>
		        </div>`;
                $('.payment-gateway-information-add').append(html);
            });

            $(document).on('click', '.removeBtn', function () {
                $(this).closest('.remove-field').remove();
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/partials/custom-field.blade.php ENDPATH**/ ?>