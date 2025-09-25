<?php $__env->startSection('panel'); ?>
<section>
    <div class="container-fluid px-0">
        <div class="row gy-4 mb-4">
            <div class="col-lg-4">
                <div class="card linear-card bg--linear-primary text-center mb-4">
                    <div class="icon">
                        <i class="las la-bell fs-17"></i>
                    </div>
                    <div class="card-body p-3">
                        <h6 class="text-white opacity-75 fw-normal fs-14"><?php echo e(__('admin.dashboard.content.invest.payable_one')); ?></h6>
                        <h4 class="fw-bold mt-1 mb-2 text-white"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investment->payable)); ?></h4>
                        <p class="text-white opacity-5 fs-14"><?php echo e(__('admin.dashboard.content.invest.payable_title', ['amount' => shortAmount($investment->payable)])); ?></p>
                    </div>
                </div>
                <div class="card card-height-100">
                    <div class="card-body">
                        <ul class="list-group list-group-flush border-dashed mb-0">
                            <?php
                                $investments = [
                                    'today_invest' => ['wallet text--primary', 'admin.dashboard.content.invest.today_invest'],
                                    'running' => ['wallet text--primary', 'admin.dashboard.content.invest.running'],
                                    'profit' => ['chart-line text--success', 'admin.dashboard.content.invest.profit'],
                                    'closed' => ['comment-dollar text--warning', 'admin.dashboard.content.invest.closed'],
                                    're_invest' => ['sort-amount-up text--info', 'admin.dashboard.content.invest.re_invest'],
                                ];
                            ?>
                            <?php $__currentLoopData = $investments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item px-0">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 d-flex align-items-center gap-3">
                                            <i class="las la-<?php echo e($details[0]); ?> fs-24"></i>
                                            <h5 class="text--light fs-14"><?php echo e(__($details[1])); ?></h5>
                                        </div>
                                        <div class="flex-shrink-0 text-end">
                                            <h5 class="text--dark fw-bold fs-14"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investment->$key)); ?></h5>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4 class="card-title mb-0"><?php echo e(__('admin.report.statistics.investment.one')); ?></h4>
                    </div>
                    <div class="card-body">
                        <div id="totalInvestment" class="charts-height"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center">
                        <h4 class="card-title mb-0"><?php echo e(__('admin.report.statistics.investment.three')); ?></h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="swiper plan-card-slider">
                                    <div class="swiper-wrapper">
                                        <?php $__empty_1 = true; $__currentLoopData = $investmentPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $investmentPlan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <div class="swiper-slide">
                                                <div class="card card--design ">
                                                    <div class="card-body">
                                                        <div class="row align-items-end g-3">
                                                            <div class="col-8">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar--sm">
                                                                        <i class="las la-list-alt fs-24 text--primary"></i>
                                                                    </div>
                                                                    <h6 class="ms-2 mb-0 fs-14 text--primary"><?php echo e(__($investmentPlan->name)); ?></h6>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 text-end">
                                                                <a href="<?php echo e(route('admin.report.investment.plans', $investmentPlan->uid)); ?>"><i class="las la-info-circle fs-18 text--light"></i></a>
                                                            </div>
                                                            <div class="col-6 text-start">
                                                                <p class="fs-13 fw-normal text--light"><?php echo e(__('admin.dashboard.content.invest.total_one')); ?></p>
                                                                <h6 class="fs-16"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investmentPlan->investmentLogs->sum('amount'))); ?></h6>
                                                            </div>
                                                            <div class="col-6 text-end">
                                                                <p class="fs-13 fw-normal text--light"><?php echo e(__('admin.dashboard.content.invest.profit')); ?></p>
                                                                <h6 class="fs-16"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investmentPlan->investmentLogs->sum('profit'))); ?></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <p class="text-center text-muted"><?php echo e(__('No Data Found')); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1"><?php echo e(__('admin.report.statistics.investment.five')); ?></h4>
                    </div>
                    <div class="card-body">
                        <div id="investProfitChart" class="charts-height"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1"><?php echo e(__('admin.report.statistics.investment.four')); ?></h4>
                        <a href="<?php echo e(route('admin.investment.index')); ?>" class="text--muted text-decoration-underline"><?php echo e(__('admin.button.view')); ?></a>
                    </div>
                    <div class="card-body">
                        <div class="swiper investment-slider">
                            <div class="swiper-wrapper">
                                <?php $__empty_1 = true; $__currentLoopData = $investmentLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $investmentLog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="swiper-slide">
                                        <div class="custom--border">
                                            <div class="card-body">
                                                <div class="mb-4">
                                                    <h6 class="fs-12 text--light"><?php echo e(__('admin.report.statistics.investment.interest_rate', ['rate' => shortAmount($investmentLog->interest_rate)])); ?></h6>
                                                    <div class="progressbar">
                                                        <div class="progress-done" data-done="5"></div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2">
                                                    <h6 class="fs-13 fw-bold text--dark"><?php echo e(__('admin.table.plan')); ?></h6>
                                                    <button class="badge badge--primary-transparent fw-bold"><?php echo e(__($investmentLog->plan->name)); ?></button>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2">
                                                    <h6 class="fs-13 fw-bold text--dark"><?php echo e(__('admin.table.amount')); ?></h6>
                                                    <p class="mb-0 fs-13 text--light"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investmentLog->amount)); ?></p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2">
                                                    <h6 class="fs-13 fw-bold text--dark"><?php echo e(__('admin.table.created_at')); ?></h6>
                                                    <p class="mb-0 fs-13 text--light"><?php echo e(showDateTime($investmentLog->created_at, 'Y-mm-dd')); ?></p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2">
                                                    <h6 class="fs-13 fw-bold text--dark"><?php echo e(__('admin.table.expiration_date')); ?></h6>
                                                    <p class="mb-0 fs-13 text--light"><?php echo e(showDateTime($investmentLog->expiration_date, 'Y-mm-dd')); ?></p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center pt-2">
                                                    <h6 class="fs-13 fw-bold text--dark"><?php echo e(__('admin.table.net_profit')); ?></h6>
                                                    <p class="mb-0 fs-13 text--light fw-bold"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investmentLog->profit)); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <p class="text-center text-muted"><?php echo e(__('No Data Found')); ?></p>
                                    <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            const amount = <?php echo json_encode($amount, 15, 512) ?>;
            const days = <?php echo json_encode($days, 15, 512) ?>;
            const currency = "<?php echo e(getCurrencySymbol()); ?>";
            const content = "<?php echo e(__('admin.report.statistics.investment.two')); ?>"

            const options = {
                series: [{
                    name: 'Investment',
                    data: amount
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: false
                },

                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '50%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: days,
                },
                yaxis: {
                    title: {
                        text: content
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return currency + val
                        }
                    }
                }
            };
            const chart = new ApexCharts(document.querySelector("#totalInvestment"), options);
            chart.render();


            const invest = <?php echo json_encode($invest, 15, 512) ?>;
            const profit = <?php echo json_encode($profit, 15, 512) ?>;
            const months = <?php echo json_encode($months, 15, 512) ?>;

            const investmentOptions = {
                series: [{
                    name: 'Profit',
                    data: profit
                }, {
                    name: 'Invest',
                    data: invest
                }],
                chart: {
                    height: 265,
                    type: 'area'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'date',
                    categories: months
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return currency + val
                        }
                    }
                }
            };

            const investmentProfit = new ApexCharts(document.querySelector("#investProfitChart"), investmentOptions);
            investmentProfit.render();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/statistic/investment.blade.php ENDPATH**/ ?>