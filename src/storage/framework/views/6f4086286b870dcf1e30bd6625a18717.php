<?php
    $pages = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::PAGE, \App\Enums\Frontend\Content::ENHANCEMENT);
    $contact = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CONTACT, \App\Enums\Frontend\Content::FIXED);
    $fixedSocialContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SOCIAL, \App\Enums\Frontend\Content::FIXED);
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FOOTER, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FOOTER, \App\Enums\Frontend\Content::ENHANCEMENT);
    $moduleCookieActivation = \App\Models\Setting::get('module_cookie_activation', 1);
?>

<footer class="pt-80 position-relative">
    <div class="footer-vector">
        <img src="<?php echo e(displayImage(getArrayFromValue($fixedContent?->meta, 'footer_vector'), "481x481")); ?>" alt="<?php echo e(__('Vector Image')); ?>">
    </div>
    <div class="container">
        <div class="row align-items-end mb-60 gy-4">
            <div class="col-lg-7 pe-lg-5">
                <div class="footer-logo mb-4">
                    <img src="<?php echo e(displayImage($logo_white, "592x89")); ?>" alt="<?php echo e(__('white logo')); ?>">
                </div>
                <h5 class="footer-title mb-0"><?php echo e(getArrayFromValue($fixedContent?->meta, 'news_letter_title')); ?></h5>
            </div>

            <div class="col-lg-5">
                <div class="newsletter-box row align-items-center g-4">
                    <form class="subscribe-form" method="POST">
                        <div class="input-wrapper">
                            <input type="email" id="email_subscribe" placeholder="<?php echo e(__('Your Email Address')); ?>" required>
                            <button><i class="bi bi-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row gy-5">
            <div class="col-lg-5 col-md-12 pe-lg-5">
                <p class="mb-5"><?php echo e(getArrayFromValue($fixedContent?->meta, 'details')); ?></p>
                <div class="payment-logos">
                    <img src="<?php echo e(displayImage(getArrayFromValue($fixedContent?->meta, 'payment'), "583x83")); ?>" alt="image">
                </div>
            </div>

            <div class="col-lg-2 col-md-6 col-6">
                <h5 class="footer-title"><?php echo e(__('Important Link')); ?></h5>
                <ul class="footer-menu">
                    <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($menu->name == 'Home'): ?>
                            <li><a href="<?php echo e(route('home')); ?>"><?php echo e($menu->name); ?></a></li>
                        <?php elseif($menu->name == 'Trade'): ?>
                            <li><a href="<?php echo e(route('trade')); ?>"><?php echo e($menu->name); ?></a></li>
                        <?php elseif($menu->children->isEmpty()): ?>
                            <li><a href="<?php echo e(route('dynamic.page', $menu->url)); ?>"><?php echo e($menu->name); ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 col-6">
                <h5 class="footer-title"><?php echo e(__('Quick Link')); ?></h5>
                <ul class="footer-menu">
                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e(route('policy', ['slug' => slug(getArrayFromValue($page->meta, 'name')), 'id' => $page->id])); ?>"><?php echo e(__(getArrayFromValue($page->meta, 'name'))); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(route('contact')); ?>"><?php echo e(__('Contact')); ?></a></li>
                </ul>
            </div>

            <div class="col-lg-3">
                <div class="footer-address-wrapper">
                    <div class="address-item d-flex gap-2">
                        <i class="bi bi-envelope text-white"></i>
                        <a class="address" href="mailto:<?php echo e(getArrayFromValue($contact?->meta, 'email')); ?>"><?php echo e(getArrayFromValue($contact?->meta, 'email')); ?></a>
                    </div>
                    <div class="address-item d-flex gap-2">
                        <i class="bi bi-telephone text-white"></i>
                        <a class="address" href="tel:<?php echo e(getArrayFromValue($contact?->meta, 'phone')); ?>"><?php echo e(getArrayFromValue($contact?->meta, 'phone')); ?></a>
                    </div>
                    <div class="address-item d-flex gap-2">
                        <i class="bi bi-geo-alt text-white"></i>
                        <div class="address"><?php echo e(getArrayFromValue($contact?->meta, 'address')); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-6 text-lg-start text-center">
                    <ul class="footer-social">
                        <li><a href="<?php echo e(getArrayFromValue($fixedSocialContent?->meta, 'facebook_url')); ?>"><?php echo  getArrayFromValue($fixedSocialContent?->meta, 'facebook_icon') ?></a></li>
                        <li><a href="<?php echo e(getArrayFromValue($fixedSocialContent?->meta, 'twitter_url')); ?>"><?php echo  getArrayFromValue($fixedSocialContent?->meta, 'twitter_icon') ?></a></li>
                        <li><a href="<?php echo e(getArrayFromValue($fixedSocialContent?->meta, 'instagram_url')); ?>"><?php echo  getArrayFromValue($fixedSocialContent?->meta, 'instagram_icon') ?></a></li>
                        <li><a href="<?php echo e(getArrayFromValue($fixedSocialContent?->meta, 'tiktok_url')); ?>"><?php echo  getArrayFromValue($fixedSocialContent?->meta, 'tiktok_icon') ?></a></li>
                        <li><a href="<?php echo e(getArrayFromValue($fixedSocialContent?->meta, 'telegram_url')); ?>"><?php echo  getArrayFromValue($fixedSocialContent?->meta, 'telegram_icon') ?></a></li>
                    </ul>
                </div>
                <div class="col-lg-6 col-lg-6 text-lg-end text-center">
                    <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'copy_right_text')); ?></p>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php if($moduleCookieActivation == \App\Enums\Status::ACTIVE->value): ?>
    <?php echo $__env->make(getActiveTheme().'.partials.cookie', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        'use strict';
        $(document).on('submit', '.subscribe-form', function(e) {
            e.preventDefault();
            const email = $("#email_subscribe").val();
            if (email) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
                    },
                    url: "<?php echo e(route('subscribe')); ?>",
                    method: "POST",
                    data: {
                        email: email
                    },
                    success: function(response) {
                        notify('success', response.success);
                        $("#email_subscribe").val('');
                    },
                    error: function(response) {
                        const errorMessage = response.responseJSON ? response.responseJSON.error : "An error occurred.";
                        notify('error', errorMessage);
                    }
                });
            } else {
                notify('error', "Please Input Your Email");
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/default_theme/partials/footer.blade.php ENDPATH**/ ?>