<?php $__env->startSection('content'); ?>
    <?php echo $__env->make(getActiveTheme().'.partials.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="blog-details-section pt-110 pb-110">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-8 pe-lg-4">
                    <div class="blog-detials mb-60">
                        <div class="image">
                            <img src="<?php echo e(displayImage(getArrayFromValue($content?->meta, 'main_image'), '1200x500')); ?>" alt="<?php echo e(__('Blog Details Image')); ?>">
                        </div>
                        <ul class="meta-list">
                            <li><a href="javascript:void(0)"><i class="bi bi-calendar2"></i><?php echo e(showDateTime($content?->created_at)); ?></a></li>
                        </ul>
                        <div class="title">
                            <h3><?php echo e(getArrayFromValue($content?->meta, 'title')); ?></h3>
                        </div>
                        <?php echo getArrayFromValue($content?->meta, 'description') ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-widget">
                        <h5 class="widget-title"><?php echo e(__('RECENT POSTS')); ?></h5>
                        <?php $__currentLoopData = $recentPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recentPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="news-item">
                                <h6>
                                    <a href="<?php echo e(route('blog.detail', $recentPost->id)); ?>" data-cursor="View"><?php echo e(getArrayFromValue($recentPost->meta, 'title')); ?></a>
                                </h6>
                                <span class="time">
                                    <i class="bi bi-clock"></i><?php echo e(showDateTime($recentPost->created_at, 'M d Y')); ?>

                                </span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(getActiveTheme().'.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/default_theme/blog_detail.blade.php ENDPATH**/ ?>