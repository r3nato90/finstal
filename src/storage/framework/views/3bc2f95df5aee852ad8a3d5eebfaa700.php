<?php $__env->startSection('panel'); ?>
    <div class="row">
        <!-- Groups Navigation -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5>Settings Groups</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('admin.settings.index', ['group' => $groupKey])); ?>"
                               class="list-group-item <?php echo e($group === $groupKey ? 'active' : ''); ?>">
                                <?php echo e(ucwords(str_replace('_', ' ', $groupKey))); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Form -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo e($setTitle); ?></h4>
                </div>
                <div class="card-body">

                    <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="group" value="<?php echo e($group); ?>">

                        <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-3">
                                <label class="form-label"><?php echo e($setting->label); ?></label>

                                <?php if($setting->type === 'text' || $setting->type === 'email'): ?>
                                    <input type="<?php echo e($setting->type); ?>"
                                           class="form-control <?php $__errorArgs = [$setting->key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="<?php echo e($setting->key); ?>"
                                           value="<?php echo e(old($setting->key, $setting->value)); ?>">

                                <?php elseif($setting->type === 'number' || $setting->type === 'integer' || $setting->type === 'float'): ?>
                                    <input type="number"
                                           class="form-control <?php $__errorArgs = [$setting->key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="<?php echo e($setting->key); ?>"
                                           value="<?php echo e(old($setting->key, $setting->value)); ?>"
                                           <?php if($setting->type === 'float'): ?> step="0.01" <?php endif; ?>>

                                <?php elseif($setting->type === 'textarea'): ?>
                                    <textarea class="form-control <?php $__errorArgs = [$setting->key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              name="<?php echo e($setting->key); ?>"
                                              rows="3"><?php echo e(old($setting->key, $setting->value)); ?></textarea>

                                <?php elseif($setting->type === 'boolean'): ?>
                                    <select class="form-select <?php $__errorArgs = [$setting->key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="<?php echo e($setting->key); ?>">
                                        <option value="1" <?php echo e(old($setting->key, $setting->value) == '1' || old($setting->key, $setting->value) === true ? 'selected' : ''); ?>>Enable</option>
                                        <option value="0" <?php echo e(old($setting->key, $setting->value) == '0' || old($setting->key, $setting->value) === false ? 'selected' : ''); ?>>Disable</option>
                                    </select>

                                <?php elseif($setting->type === 'select'): ?>
                                    <select class="form-select <?php $__errorArgs = [$setting->key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="<?php echo e($setting->key); ?>">
                                        <option value="1" <?php echo e(old($setting->key, $setting->value) == '1' ? 'selected' : ''); ?>>Enable</option>
                                        <option value="0" <?php echo e(old($setting->key, $setting->value) == '0' ? 'selected' : ''); ?>>Disable</option>
                                    </select>

                                <?php elseif($setting->type === 'color'): ?>
                                    <div class="input-group">
                                        <input type="color"
                                               class="form-control form-control-color color-picker <?php $__errorArgs = [$setting->key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="color_<?php echo e($setting->key); ?>"
                                               value="<?php echo e(old($setting->key, $setting->value ?: '#000000')); ?>"
                                               style="width: 60px; padding: 4px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                        <input type="text"
                                               class="form-control color-text <?php $__errorArgs = [$setting->key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="<?php echo e($setting->key); ?>"
                                               id="text_<?php echo e($setting->key); ?>"
                                               value="<?php echo e(old($setting->key, $setting->value ?: '#000000')); ?>"
                                               placeholder="#000000"
                                               pattern="^#[0-9A-Fa-f]{6}$"
                                               style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                    </div>

                                <?php elseif($setting->type === 'file' || $setting->type === 'image'): ?>
                                    <div class="file-upload-wrapper">
                                        <input type="file"
                                               class="form-control <?php $__errorArgs = [$setting->key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="<?php echo e($setting->key); ?>"
                                               <?php if($setting->type === 'image'): ?> accept="image/*" <?php endif; ?>>
                                        <?php if($setting->value): ?>
                                            <div class="mt-2">
                                                <small class="text-muted">Current file: <?php echo e(basename($setting->value)); ?></small>
                                                <?php if($setting->type === 'image' && file_exists(public_path($setting->value))): ?>
                                                    <div class="mt-1">
                                                        <img src="<?php echo e(asset($setting->value)); ?>" alt="Current image" style="max-width: 100px; max-height: 100px;">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                <?php elseif($setting->type === 'json' && $setting->key === 'seo_keywords'): ?>
                                    <?php
                                        $keywords = [];
                                        if (is_string($setting->value)) {
                                            $keywords = json_decode($setting->value, true) ?: [];
                                        } elseif (is_array($setting->value)) {
                                            $keywords = $setting->value;
                                        }
                                    ?>
                                    <input type="text"
                                           class="form-control"
                                           id="keywords_input"
                                           placeholder="Type keyword and press Enter">
                                    <div class="mt-2" id="keywords_container">
                                        <?php $__currentLoopData = $keywords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-secondary me-1 mb-1">
                                                <?php echo e($keyword); ?>

                                                <button type="button" class="btn-close btn-close-white ms-1" onclick="removeKeyword(<?php echo e($index); ?>)"></button>
                                                <input type="hidden" name="seo_keywords[]" value="<?php echo e($keyword); ?>">
                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                <?php elseif($setting->type === 'json' || $setting->type === 'array'): ?>
                                    <?php
                                        $jsonValue = '';
                                        if (is_string($setting->value)) {
                                            $jsonValue = $setting->value;
                                        } elseif (is_array($setting->value)) {
                                            $jsonValue = json_encode($setting->value, JSON_PRETTY_PRINT);
                                        }
                                    ?>
                                    <textarea class="form-control <?php $__errorArgs = [$setting->key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              name="<?php echo e($setting->key); ?>"
                                              rows="5"
                                              placeholder="Enter valid JSON"><?php echo e(old($setting->key, $jsonValue)); ?></textarea>
                                    <small class="form-text text-muted">Enter valid JSON format</small>

                                <?php else: ?>
                                    <input type="text"
                                           class="form-control <?php $__errorArgs = [$setting->key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="<?php echo e($setting->key); ?>"
                                           value="<?php echo e(old($setting->key, $setting->value)); ?>">
                                <?php endif; ?>

                                <?php $__errorArgs = [$setting->key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                <?php if($setting->description): ?>
                                    <small class="form-text text-muted"><?php echo e($setting->description); ?></small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <button type="submit" class="i-btn btn--primary btn--lg"><?php echo e(__('admin.button.save')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-push'); ?>
    <style>
        .list-group-item.active {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }
        .btn-close-white {
            filter: invert(1);
        }
        .file-upload-wrapper {
            position: relative;
        }
        .badge {
            font-size: 0.875rem;
        }
        .color-picker {
            height: 38px;
            cursor: pointer;
        }
        .color-text {
            font-family: monospace;
            text-transform: uppercase;
        }
        .input-group .color-picker {
            border-right: none;
        }
        .input-group .color-text {
            border-left: none;
        }
        .input-group .color-text:focus {
            border-left: none;
            box-shadow: none;
        }
        .input-group .color-picker:focus {
            border-right: none;
            box-shadow: none;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Color picker sync
            document.querySelectorAll('.color-picker').forEach(function(colorInput) {
                const settingKey = colorInput.id.replace('color_', '');
                const textInput = document.getElementById('text_' + settingKey);

                if (textInput) {
                    // Sync color picker to text input
                    colorInput.addEventListener('input', function() {
                        textInput.value = this.value.toUpperCase();
                    });

                    // Sync text input to color picker
                    textInput.addEventListener('input', function() {
                        const value = this.value.trim();
                        // Validate hex color format
                        if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                            colorInput.value = value;
                            this.style.borderColor = '';
                        } else {
                            this.style.borderColor = '#dc3545';
                        }
                    });

                    // Format on blur
                    textInput.addEventListener('blur', function() {
                        let value = this.value.trim().toUpperCase();
                        if (value && !value.startsWith('#')) {
                            value = '#' + value;
                        }
                        if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                            this.value = value;
                            colorInput.value = value;
                            this.style.borderColor = '';
                        } else if (value === '') {
                            this.value = '#000000';
                            colorInput.value = '#000000';
                            this.style.borderColor = '';
                        }
                    });
                }
            });

            // Keywords input
            const keywordsInput = document.getElementById('keywords_input');
            if (keywordsInput) {
                keywordsInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        addKeyword();
                    }
                });
            }
        });

        function addKeyword() {
            const input = document.getElementById('keywords_input');
            const keyword = input.value.trim();
            if (!keyword) return;

            // Check if keyword already exists
            const existingKeywords = Array.from(document.querySelectorAll('input[name="seo_keywords[]"]'))
                .map(input => input.value);

            if (existingKeywords.includes(keyword)) {
                alert('Keyword already exists!');
                return;
            }

            const container = document.getElementById('keywords_container');
            const index = Date.now(); // Use timestamp as unique index

            const badge = document.createElement('span');
            badge.className = 'badge bg-secondary me-1 mb-1';
            badge.innerHTML = `
                ${keyword}
                <button type="button" class="btn-close btn-close-white ms-1" onclick="removeKeywordElement(this)"></button>
                <input type="hidden" name="seo_keywords[]" value="${keyword}">
            `;

            container.appendChild(badge);
            input.value = '';
        }

        function removeKeyword(index) {
            const container = document.getElementById('keywords_container');
            const badges = container.querySelectorAll('.badge');
            if (badges[index]) {
                badges[index].remove();
            }
        }

        function removeKeywordElement(button) {
            button.closest('.badge').remove();
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/settings/index.blade.php ENDPATH**/ ?>