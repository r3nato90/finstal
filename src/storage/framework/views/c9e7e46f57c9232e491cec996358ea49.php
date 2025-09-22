<?php
    $tradeInvestmentSetting = \App\Models\Setting::get('investment_trade_prediction', 1);
?>

<?php if($tradeInvestmentSetting == 1): ?>
    <?php
        $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CURRENCY_EXCHANGE, \App\Enums\Frontend\Content::FIXED);
    ?>

    <div class="currency-section full--width pt-110 pb-110">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-7 col-md-9">
                    <div class="section-title text-center mb-60">
                        <h2><?php echo e(getArrayFromValue($fixedContent?->meta, 'heading')); ?></h2>
                        <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'sub_heading')); ?></p>
                    </div>
                </div>
            </div>
            <div class="row gy-5">
                <div class="col-lg-12">
                    <div class="currency-wrapper">
                        <div class="text-start">
                            <a href="<?php echo e(route('trade')); ?>" class="i-btn read-more-btn"><?php echo e(__('Explore Trades')); ?> <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <?php echo $__env->make(getActiveTheme().'.partials.cryptos', ['currencyExchanges' => $currencyExchanges], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/finfunder/src/resources/views/default_theme/component/currency_exchange.blade.php ENDPATH**/ ?>