<div class="row">
    <div class="col-12">
        <h6 class="text-white mb-3"><?php echo e(__('Personal Information')); ?></h6>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="first_name" class="form-label text-white"><?php echo e(__('First Name')); ?></label>
        <input type="text" class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               id="first_name" name="first_name"
               value="<?php echo e(old('first_name', $isResubmission && $kyc ? $kyc->first_name : '')); ?>" required>
        <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="col-md-6 mb-3">
        <label for="last_name" class="form-label text-white"><?php echo e(__('Last Name')); ?></label>
        <input type="text" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               id="last_name" name="last_name"
               value="<?php echo e(old('last_name', $isResubmission && $kyc ? $kyc->last_name : '')); ?>" required>
        <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="date_of_birth" class="form-label text-white"><?php echo e(__('Date of Birth')); ?></label>
        <input type="date" class="form-control <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               id="date_of_birth" name="date_of_birth"
               value="<?php echo e(old('date_of_birth', $isResubmission && $kyc ? $kyc->date_of_birth->format('Y-m-d') : '')); ?>" required>
        <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="col-md-6 mb-3">
        <label for="phone" class="form-label text-white"><?php echo e(__('Phone Number')); ?></label>
        <input type="tel" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               id="phone" name="phone"
               value="<?php echo e(old('phone', $isResubmission && $kyc ? $kyc->phone : '')); ?>" required>
        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h6 class="text-white mb-3"><?php echo e(__('Address Information')); ?></h6>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <label for="address" class="form-label text-white"><?php echo e(__('Street Address')); ?></label>
        <textarea class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                  id="address" name="address" rows="3" required><?php echo e(old('address', $isResubmission && $kyc ? $kyc->address : '')); ?></textarea>
        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="city" class="form-label text-white"><?php echo e(__('City')); ?></label>
        <input type="text" class="form-control <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               id="city" name="city"
               value="<?php echo e(old('city', $isResubmission && $kyc ? $kyc->city : '')); ?>" required>
        <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="col-md-6 mb-3">
        <label for="state" class="form-label text-white"><?php echo e(__('State/Province')); ?></label>
        <input type="text" class="form-control <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               id="state" name="state"
               value="<?php echo e(old('state', $isResubmission && $kyc ? $kyc->state : '')); ?>" required>
        <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="country" class="form-label text-white"><?php echo e(__('Country')); ?></label>
        <select class="form-control <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="country" name="country" required>
            <option value=""><?php echo e(__('Select Country')); ?></option>
            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($country); ?>"
                    <?php echo e(old('country', $isResubmission && $kyc ? $kyc->country : '') == $country ? 'selected' : ''); ?>>
                    <?php echo e($country); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="col-md-6 mb-3">
        <label for="postal_code" class="form-label text-white"><?php echo e(__('Postal Code')); ?></label>
        <input type="text" class="form-control <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               id="postal_code" name="postal_code"
               value="<?php echo e(old('postal_code', $isResubmission && $kyc ? $kyc->postal_code : '')); ?>" required>
        <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h6 class="text-white mb-3"><?php echo e(__('Identity Document')); ?></h6>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="document_type" class="form-label text-white"><?php echo e(__('Document Type')); ?></label>
        <select class="form-control <?php $__errorArgs = ['document_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="document_type" name="document_type" required>
            <option value=""><?php echo e(__('Select Document Type')); ?></option>
            <option value="passport"
                <?php echo e(old('document_type', $isResubmission && $kyc ? $kyc->document_type : '') == 'passport' ? 'selected' : ''); ?>>
                <?php echo e(__('Passport')); ?>

            </option>
            <option value="driver_license"
                <?php echo e(old('document_type', $isResubmission && $kyc ? $kyc->document_type : '') == 'driver_license' ? 'selected' : ''); ?>>
                <?php echo e(__('Driver License')); ?>

            </option>
            <option value="national_id"
                <?php echo e(old('document_type', $isResubmission && $kyc ? $kyc->document_type : '') == 'national_id' ? 'selected' : ''); ?>>
                <?php echo e(__('National ID')); ?>

            </option>
        </select>
        <?php $__errorArgs = ['document_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="col-md-6 mb-3">
        <label for="document_number" class="form-label text-white"><?php echo e(__('Document Number')); ?></label>
        <input type="text" class="form-control <?php $__errorArgs = ['document_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               id="document_number" name="document_number"
               value="<?php echo e(old('document_number', $isResubmission && $kyc ? $kyc->document_number : '')); ?>" required>
        <?php $__errorArgs = ['document_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h6 class="text-white mb-3"><?php echo e(__('Document Upload')); ?></h6>
        <p class="text-white-50 small"><?php echo e(__('Please upload clear, high-quality images. Maximum file size: 10MB per image.')); ?></p>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="document_front" class="form-label text-white">
            <?php echo e(__('Document Front')); ?> <span class="text-danger">*</span>
        </label>
        <input type="file" class="form-control <?php $__errorArgs = ['document_front'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               id="document_front" name="document_front" accept="image/*" <?php echo e(!$isResubmission ? 'required' : ''); ?>>
        <?php $__errorArgs = ['document_front'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <?php if($isResubmission && $kyc && $kyc->document_front_path): ?>
            <div class="mt-2">
                <small class="text-white-50"><?php echo e(__('Current file uploaded')); ?></small>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4 mb-3">
        <label for="document_back" class="form-label text-white">
            <?php echo e(__('Document Back')); ?> <span class="text-white-50">(<?php echo e(__('If applicable')); ?>)</span>
        </label>
        <input type="file" class="form-control <?php $__errorArgs = ['document_back'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               id="document_back" name="document_back" accept="image/*">
        <?php $__errorArgs = ['document_back'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <?php if($isResubmission && $kyc && $kyc->document_back_path): ?>
            <div class="mt-2">
                <small class="text-white-50"><?php echo e(__('Current file uploaded')); ?></small>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4 mb-3">
        <label for="selfie" class="form-label text-white">
            <?php echo e(__('Selfie with Document')); ?> <span class="text-danger">*</span>
        </label>
        <input type="file" class="form-control <?php $__errorArgs = ['selfie'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               id="selfie" name="selfie" accept="image/*" <?php echo e(!$isResubmission ? 'required' : ''); ?>>
        <?php $__errorArgs = ['selfie'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <?php if($isResubmission && $kyc && $kyc->selfie_path): ?>
            <div class="mt-2">
                <small class="text-white-50"><?php echo e(__('Current file uploaded')); ?></small>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="alert alert-info bg-dark border-info">
            <h6 class="text-info"><?php echo e(__('Upload Guidelines:')); ?></h6>
            <ul class="mb-0 small text-white-50">
                <li><?php echo e(__('Ensure all text on the document is clearly readable')); ?></li>
                <li><?php echo e(__('Document should be well-lit and in focus')); ?></li>
                <li><?php echo e(__('For selfie: Hold your document next to your face')); ?></li>
                <li><?php echo e(__('Accepted formats: JPG, JPEG, PNG')); ?></li>
                <li><?php echo e(__('Maximum file size: 10MB per image')); ?></li>
            </ul>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-shield-check me-2"></i>
                <?php echo e($isResubmission ? __('Resubmit KYC Verification') : __('Submit KYC Verification')); ?>

            </button>
        </div>
    </div>
</div>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/user/settings/partials/kyc_form.blade.php ENDPATH**/ ?>