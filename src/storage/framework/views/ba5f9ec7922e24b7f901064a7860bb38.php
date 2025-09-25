<div class="card">
    <div class="responsive-table">
        <table>
            <thead>
            <tr>
                <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo app('translator')->get($column); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $color = $name = $user = $fromUser = $plan = $parameter = $route = $withdrawGateway = $withdrawFinalAmount = $withdrawConversion = $withdrawRate = $withdrawLimit = $withdrawCharges = $phaseRoute = '';

                    if (\App\Enums\PageIdentifier::MATRIX->value == $page_identifier) {
                        $totalAmount = $row->matrixLevel->sum('amount') + $row->referral_reward;
                        $calculateAmount = $row->amount - $totalAmount;
                        $color = \App\Enums\Matrix\PlanStatus::getColor($row->status);
                        $name = \App\Enums\Matrix\PlanStatus::getName($row->status);
                        $route = '<a href="' . route('admin.matrix.edit', [$row->uid]) . '">' . __('Edit') . '</a>';
                    } elseif (\App\Enums\PageIdentifier::SALE_PHASES->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = '<a href="' . route('admin.ico.phase.edit', ['token_id' => $token->id, 'phase_id' => $row->id]) . '">' . __('Edit') . '</a>';
                    } elseif (\App\Enums\PageIdentifier::ICO_TOKEN->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = '<a href="' . route('admin.ico.token.edit', [$row->id]) . '">' . __('Edit') . '</a>';
                        $phaseRoute = '<a href="' . route('admin.ico.phase.index', [$row->id]) . '">' . __('Phase') . '</a>';
                    } elseif (\App\Enums\PageIdentifier::MATRIX_ENROLLED->value == $page_identifier) {
                        $color = \App\Enums\Matrix\InvestmentStatus::getColor($row->status);
                        $name = \App\Enums\Matrix\InvestmentStatus::getName($row->status);
                    } elseif (\App\Enums\PageIdentifier::STAKING_INVESTMENT->value == $page_identifier) {
                        $color = \App\Enums\Investment\Staking\Status::getColor($row->status);
                        $name = \App\Enums\Investment\Staking\Status::getName($row->status);
                    } elseif (\App\Enums\PageIdentifier::BINARY->value == $page_identifier) {
                        $color = \App\Enums\Matrix\PlanStatus::getColor($row->status);
                        $name = \App\Enums\Matrix\PlanStatus::getName($row->status);
                        $route = '<a href="' . route('admin.binary.edit', $row->uid) . '">' . __('Edit') . '</a>';
                    } elseif (\App\Enums\PageIdentifier::BINARY_INVESTMENT->value == $page_identifier) {
                        $plan = $row->plan_name;
                        $route = "<a href='" . route('admin.binary.details', $row->id) . "'>" . __('Details') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::DAILY_COMMISSIONS->value == $page_identifier) {
                        $user = $row->user->email;
                    } elseif (\App\Enums\PageIdentifier::COMMISSIONS->value == $page_identifier) {
                        $fromUser = optional($row->fromUser)->email;
                    } elseif (\App\Enums\PageIdentifier::PIN_GENERATE->value == $page_identifier) {
                        if ($row->set_user_id) {
                            $user = "<a href=\"" . route('admin.user.details', $row->setUser->id) . "\">" . $row->setUser->email . "</a>";
                        } else {
                            $user = __('Admin');
                        }
                        $color = \App\Enums\Matrix\PinStatus::getColor($row->status);
                        $name = \App\Enums\Matrix\PinStatus::getName($row->status);
                    } elseif (\App\Enums\PageIdentifier::STAKING_PLAN->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='javascript:void(0)' class='updateBtn' data-toggle='modal' data-target='#updateModal' data-id='{$row->id}' data-duration='{$row->duration}' data-interest_rate='" . getAmount($row->interest_rate) . "' data-minimum_amount='" . getAmount($row->minimum_amount) . "' data-maximum_amount='" . getAmount($row->maximum_amount) . "'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::TIME_TABLE->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='javascript:void(0)' class='updateBtn' data-toggle='modal' data-target='#updateModal' data-id='{$row->id}' data-time='{$row->time}' data-name='{$row->name}' data-status='{$row->status}'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::KYC_IDENTITY->value == $page_identifier) {
                        $route = "<a href='javascript:void(0)' class='kyc_identity' data-toggle='modal' data-target='#kycIdentityModal' data-id='{$row->id}'>" . __('Update') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::REWARD->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='javascript:void(0)' class='updateBtn' data-toggle='modal' data-target='#rewardUpdateModal' data-id='{$row->id}' data-level='{$row->level}' data-reward='" . getAmount($row->reward) . "' data-referral_count='" . getAmount($row->referral_count) . "' data-deposit='" . getAmount($row->deposit) . "' data-team_invest='" . getAmount($row->team_invest) . "' data-invest='" . getAmount($row->invest) . "' data-name='{$row->name}' data-status='{$row->status}'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::HOLIDAY_SETTING->value == $page_identifier) {
                        $route = "<a href='javascript:void(0)' class='updateBtn' data-toggle='modal' data-target='#updateModal' data-id='{$row->id}' data-date='{$row->date}' data-name='{$row->name}'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::TRADE_PARAMETER->value == $page_identifier) {
                        $parameter = $row->time . ' ' . $row->unit;
                        $color = \App\Enums\Trade\TradeParameterStatus::getColor($row->status);
                        $name = \App\Enums\Trade\TradeParameterStatus::getName($row->status);
                        $route = "<a href='javascript:void(0)' class='updateBtn' data-toggle='modal' data-target='#updateModal' data-id='{$row->id}' data-time='{$row->time}' data-unit='{$row->unit}' data-status='{$row->status}'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::CRYPTO_CURRENCY->value == $page_identifier) {
                        $color = \App\Enums\Trade\CryptoCurrencyStatus::getColor($row->status);
                        $name = \App\Enums\Trade\CryptoCurrencyStatus::getName($row->status);
                        $route = "<a href='javascript:void(0)' class='updateBtn' data-toggle='modal' data-target='#updateModal' data-id='{$row->id}' data-status='{$row->status}'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::DEPOSIT->value == $page_identifier) {
                        $color = \App\Enums\Payment\Deposit\Status::getColor($row->status);
                        $name = \App\Enums\Payment\Deposit\Status::getName($row->status);
                        $route = "<a href='" . route('admin.deposit.details', $row->id) . "'>" . __('Details') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::WITHDRAW_METHOD->value == $page_identifier) {
                        $color = \App\Enums\Payment\Withdraw\MethodStatus::getColor($row->status);
                        $name = \App\Enums\Payment\Withdraw\MethodStatus::getName($row->status);
                        $withdrawRate = getCurrencySymbol() . "1" . ' = ' . shortAmount($row->rate) . ' ' . $row->currency_name;
                        $withdrawLimit = getCurrencySymbol() . shortAmount($row->min_limit) . ' - ' . getCurrencySymbol() . shortAmount($row->max_limit);
                        $withdrawCharges = "Fixed charge: " . getCurrencySymbol() . shortAmount($row->fixed_charge, 2) . '<br>' . 'Percent Charge: ' . shortAmount($row->percent_charge, 2) . '%';
                        $route = "<a href='" . route('admin.withdraw.method.edit', $row->id) . "'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::WITHDRAW_LOG->value == $page_identifier) {
                        $color = \App\Enums\Payment\Withdraw\Status::getColor($row->status);
                        $name = \App\Enums\Payment\Withdraw\Status::getName($row->status);
                        $withdrawFinalAmount = getCurrencySymbol() . shortAmount($row->amount);
                        $withdrawConversion = getCurrencySymbol() . '1' . ' = ' . shortAmount($row->rate) . ' ' . __($row->currency);
                        $withdrawGateway = $row->withdrawMethod->name ?? 'N/A';
                        $route = "<a href='" . route('admin.withdraw.details', $row->id) . "'>" . __('Details') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::AGENT_WITHDRAW_LOG->value == $page_identifier) {
                        $color = \App\Enums\Payment\Withdraw\Status::getColor($row->status);
                        $name = \App\Enums\Payment\Withdraw\Status::getName($row->status);
                        $withdrawFinalAmount = getCurrencySymbol() . shortAmount($row->amount);
                        $withdrawConversion = getCurrencySymbol() . '1' . ' = ' . shortAmount($row->rate) . ' ' . __($row->currency);
                        $withdrawGateway = $row->withdrawMethod->name ?? 'N/A';
                        $route = "<a href='" . route('admin.agent.withdraw.details', $row->id) . "'>" . __('Details') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::SUPPORT_TICKET->value == $page_identifier) {
                        $color = \App\Enums\SupportTicketStatus::getColor($row->status);
                        $name = \App\Enums\SupportTicketStatus::getName($row->status);
                        $route = "<a href='" . route('admin.support.ticket.details', $row->uid) . "'>" . __('Details') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::USER->value == $page_identifier) {
                        $color = \App\Enums\User\Status::getColor($row->status);
                        $name = \App\Enums\User\Status::getName($row->status);
                        $route = "<a href=\"" . route('admin.user.details', ['id' => $row->id]) . "\">" . __('Details') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::AGENT->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                    } elseif (\App\Enums\PageIdentifier::PAYMENT_GATEWAY->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='" . route('admin.payment.gateway.edit', $row->id) . "'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::MANUAL_PAYMENT_GATEWAY->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='" . route('admin.manual.gateway.edit', $row->id) . "'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::SMS_EMAIL_TEMPLATES->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='" . route('admin.notifications.edit', $row->id) . "'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::SMS_GATEWAYS->value == $page_identifier) {
                        $color = \App\Enums\Status::getColor($row->status);
                        $name = \App\Enums\Status::getName($row->status);
                        $route = "<a href='" . route('admin.sms.gateway.edit', $row->id) . "'>" . __('Edit') . "</a>";
                    } elseif (\App\Enums\PageIdentifier::TRADE->value == $page_identifier) {
                        $color = \App\Enums\Trade\TradeStatus::getColor($row->status);
                        $name = \App\Enums\Trade\TradeStatus::getName($row->status);
                    }
                ?>
                <tr>
                    <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dbColumn => $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td data-label="<?php echo e($column); ?>">
                            <?php if($dbColumn == 'created_at'): ?>
                                <span><?php echo e(showDateTime($row->$dbColumn)); ?></span>
                            <?php elseif($dbColumn == 'pin_amount'): ?>
                                <span><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->amount + $row->charge)); ?></span>
                            <?php elseif($dbColumn == 'last_run'): ?>
                                <?php if(is_null($row->$dbColumn)): ?>
                                    <?php echo e(__('N/A')); ?>

                                <?php else: ?>
                                    <span><?php echo e(showDateTime($row->$dbColumn)); ?></span>
                                <?php endif; ?>
                            <?php elseif($dbColumn == 'pair'): ?>
                                <div class="d-flex justify-content-sm-start justify-content-end align-items-center gap-2">
                                    <div class="crypto-currency-icon">
                                        <img src="<?php echo e($row->file); ?>" alt="<?php echo e($row->name); ?>">
                                    </div>
                                    <span class="flex-shrink-0"><?php echo e($row->pair); ?></span>
                                </div>
                            <?php elseif($dbColumn == 'payment_gateway_name'): ?>
                                <span><?php echo e($row->name); ?></span>
                            <?php elseif($dbColumn == 'sms_gateway_name'): ?>
                                <?php echo e(__(ucfirst($row->name))); ?>

                                <?php if($row->id == $setting->sms_gateway_id): ?>
                                    <span class="text-success"><i class="las la-check"></i></span>
                                <?php endif; ?>
                            <?php elseif($dbColumn == 'parameter'): ?>
                                <span><?php echo e($parameter); ?></span>
                            <?php elseif($dbColumn == 'total_supply'): ?>
                                <span><?php echo e(shortAmount($row->total_supply)); ?></span>
                            <?php elseif($dbColumn == 'transaction_name'): ?>
                                <span><?php echo e($row->agent->name ?? ''); ?></span>
                            <?php elseif($dbColumn == 'duration'): ?>
                                <span><?php echo e($row->duration); ?> <?php echo e(__('Days')); ?></span>
                            <?php elseif($dbColumn == 'holiday_date'): ?>
                                <span><?php echo e(showDateTime($row->date, 'd M Y')); ?></span>
                            <?php elseif(Str::contains($dbColumn, "crypto")): ?>
                                <?php if($dbColumn == 'crypto_price_change_24h'): ?>
                                    <span><?php echo e(getArrayFromValue($row->meta, Str::replaceFirst('crypto_', '', $dbColumn))); ?></span>
                                <?php else: ?>
                                    <span><?php echo e(getCurrencySymbol()); ?><?php echo e(getArrayFromValue($row->meta, Str::replaceFirst('crypto_', '', $dbColumn))); ?></span>
                                <?php endif; ?>
                            <?php elseif($dbColumn == 'user_id'): ?>
                                <a href="<?php echo e(route('admin.user.details', $row->user_id)); ?>"><?php echo e($row->user->email); ?></a>
                            <?php elseif($dbColumn == 'payment_gateway_id'): ?>
                                <span><?php echo e($row->gateway->name ?? 'N/A'); ?></span>
                            <?php elseif($dbColumn == 'set_user_id'): ?>
                                <span><?php echo $user; ?></span>
                            <?php elseif($dbColumn == 'from_user_id'): ?>
                                <a href="<?php echo e(route('admin.user.details', $row->from_user_id)); ?>"><?php echo e($fromUser); ?></a>
                            <?php elseif($dbColumn == 'user_wallet'): ?>
                                <button type="button"
                                        class="badge badge--success-outline wallets"
                                        data-bs-toggle="modal" data-id="<?php echo e($row->wallet); ?>"
                                        data-bs-target="#list-wallet"><?php echo e(__('Wallet')); ?>

                                </button>
                            <?php elseif($dbColumn == 'user_identity_information'): ?>
                                <button type="button" class="badge badge--primary-outline identity-info"
                                        data-bs-toggle="modal"
                                        data-meta='<?php echo json_encode($row->meta['identity'] ?? [], 15, 512) ?>'
                                        data-bs-target="#identity-information">
                                    <?php echo e(__('Information')); ?>

                                </button>
                            <?php elseif($dbColumn == 'user_add_subtract'): ?>
                                <button type="button"
                                        class="badge badge--primary-outline created-update"
                                        data-bs-toggle="modal" data-id="<?php echo e($row->id); ?>"
                                        data-bs-target="#credit-add-return"><?php echo e(__('Add / Subtract')); ?>

                                </button>
                            <?php elseif($dbColumn == 'agent_action'): ?>
                                <a href="javascript:void(0)" class="badge badge--primary-transparent agentUpdate"
                                   data-toggle="modal"
                                   data-target="#agentUpdateModal"
                                   data-id="<?php echo e($row->id); ?>"
                                   data-name="<?php echo e($row->email); ?>"
                                   data-status="<?php echo e($row->status); ?>"><?php echo e(__('Edit')); ?></a>
                            <?php elseif($dbColumn == 'agent_primary_balance'): ?>
                                <span><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->balance ?? 0)); ?></span>
                            <?php elseif($dbColumn == 'transaction_charge'): ?>
                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->charge)); ?>

                            <?php elseif($dbColumn == 'transaction_post_balance'): ?>
                                <?php if($row->is_ico_wallet): ?>
                                    <?php echo e($row->icoWallet->token->name .' wallet'); ?> : <?php echo e(shortAmount($row->post_balance)); ?> <?php echo e($row->icoWallet->token->symbol ?? ''); ?>

                                <?php else: ?>
                                    <?php echo e(\App\Enums\Transaction\WalletType::getName((int)$row->wallet_type)); ?> : <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->post_balance)); ?>

                                <?php endif; ?>
                            <?php elseif($dbColumn == 'transaction_amount'): ?>
                                <span class="text--<?php echo e(\App\Enums\Transaction\Type::getTextColor((int)$row->type)); ?>">
                                          <?php echo e(shortAmount($row->amount)); ?> <?php echo e($row->is_ico_wallet ? $row->icoWallet->token->symbol ?? '' : getCurrencyName()); ?>

                                    </span>
                            <?php elseif($dbColumn == 'transaction_wallet_type'): ?>
                                <span class="badge <?php echo e(\App\Enums\Transaction\WalletType::getColor((int)$row->wallet_type)); ?>">
                                        <?php echo e(\App\Enums\Transaction\WalletType::getWalletName((int)$row->wallet_type)); ?>

                                    </span>
                            <?php elseif($dbColumn == 'transaction_source'): ?>
                                <span class="badge <?php echo e(\App\Enums\Transaction\Source::getColor((int)$row->source)); ?>">
                                        <?php echo e(\App\Enums\Transaction\Source::getName((int)$row->source)); ?>

                                    </span>
                            <?php elseif($dbColumn == 'phase_timeline'): ?>
                                <div class="text-sm">
                                    Start: <?php echo e($row->start_time->format('M d, Y H:i')); ?><br>
                                    End: <?php echo e($row->end_time->format('M d, Y H:i')); ?>

                                </div>
                            <?php elseif($dbColumn == 'phase_price'): ?>
                                <?php echo e(number_format($row->token_price, 6)); ?>

                                <?php if($row->dynamic_pricing_rules): ?>
                                    <span class="text-xs text-gray-500">(Dynamic)</span>
                                <?php endif; ?>
                            <?php elseif($dbColumn == 'withdraw_method_id'): ?>
                                <span><?php echo e($withdrawGateway); ?></span>
                            <?php elseif($dbColumn == 'withdraw_amount'): ?>
                                <span><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->amount)); ?></span>
                            <?php elseif($dbColumn == 'withdraw_charge'): ?>
                                <span><?php echo e(getCurrencySymbol().shortAmount($row->charge)); ?></span>
                            <?php elseif($dbColumn == 'time_table'): ?>
                                <span><?php echo e($row->time ?? ''); ?> <?php echo e(__('Hours')); ?></span>
                            <?php elseif($dbColumn == 'withdraw_conversion'): ?>
                                <span><?php echo e($withdrawConversion); ?></span>
                            <?php elseif($dbColumn == 'withdraw_rate'): ?>
                                <span><?php echo e($withdrawRate); ?></span>
                            <?php elseif($dbColumn == 'rate'): ?>
                                <span><?php echo e(getCurrencySymbol()); ?>1 = <?php echo e(shortAmount($row->$dbColumn)); ?> <?php echo e($row->currency); ?></span>
                            <?php elseif($dbColumn == 'withdraw_limit'): ?>
                                <span><?php echo e($withdrawLimit); ?></span>
                            <?php elseif($dbColumn == 'phase_type'): ?>
                                <span><?php echo e(\App\Enums\Phase\PhaseType::getName($row->type)); ?></span>
                            <?php elseif($dbColumn == 'withdraw_charges'): ?>
                                <span><?php echo $withdrawCharges; ?></span>
                            <?php elseif($dbColumn == 'withdraw_ico_token'): ?>
                                <span><?php echo e($row->is_ico_wallet ? shortAmount($row->ico_token).' '.$row->icoWallet->token->symbol ?? '' : 'N/A'); ?></span>
                            <?php elseif($dbColumn == 'withdraw_final_amount'): ?>
                                <span><?php echo e(shortAmount($row->final_amount)); ?> <?php echo e($row?->currency); ?></span>
                            <?php elseif($dbColumn == 'deposit_final_amount'): ?>
                                <span><?php echo e(shortAmount($row?->final_amount * $row?->rate )); ?> <?php echo e($row->currency ?? ''); ?></span>
                            <?php elseif($dbColumn == 'amount' || $dbColumn == 'token_price' || $dbColumn == 'reward' || $dbColumn == 'referral_reward' || $dbColumn == 'profit' || $dbColumn == 'minimum' || $dbColumn == 'maximum'
                                || $dbColumn == 'daily_profit' || $dbColumn == 'post_balance' || $dbColumn == 'charge' || $dbColumn == 'final_amount' || $dbColumn == 'after_charge' || $dbColumn == 'price' || $dbColumn == 'referral_commissions' || $dbColumn == 'level_commissions'): ?>
                                <span><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->$dbColumn)); ?></span>
                            <?php elseif($dbColumn == 'invest' || $dbColumn == 'team_invest' || $dbColumn == 'deposit' || $dbColumn == 'referral_count'): ?>
                                <?php if(\App\Enums\PageIdentifier::REWARD->value == $page_identifier): ?>
                                    <span><?php echo e($dbColumn == 'referral_count' ? '' : getCurrencySymbol()); ?><?php echo e(shortAmount($row->$dbColumn)); ?></span>
                                <?php endif; ?>
                            <?php elseif($dbColumn == 'trade_outcome_amount'): ?>
                                <?php if($row->outcome == \App\Enums\Trade\TradeOutcome::WIN->value): ?>
                                    <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->amount)); ?>

                                    +
                                    <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->winning_amount)); ?>

                                    =
                                    <span class="text--success">
                                            <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->amount + $row->winning_amount)); ?>

                                        </span>
                                <?php elseif($row->outcome == \App\Enums\Trade\TradeOutcome::LOSE->value): ?>
                                    <span class="text--danger"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->amount)); ?></span>
                                <?php else: ?>
                                    <span class="text--primary"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->amount)); ?></span>
                                <?php endif; ?>
                            <?php elseif($dbColumn == 'return_percentage' || $dbColumn == 'interest_rate' || $dbColumn == 'percent_charge'): ?>
                                <span><?php echo e(shortAmount($row->$dbColumn)); ?>%</span>
                            <?php elseif($dbColumn == 'staking_amount'): ?>
                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->minimum_amount)); ?> - <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->maximum_amount)); ?>

                            <?php elseif($dbColumn == 'invest_limit'): ?>
                                <?php if($row->type == \App\Enums\Investment\InvestmentRage::RANGE->value): ?>
                                    <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->minimum)); ?> - <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->maximum)); ?>

                                <?php else: ?>
                                    <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->amount)); ?>

                                <?php endif; ?>
                            <?php elseif($dbColumn == 'payment_limit'): ?>
                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->minimum)); ?> - <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->maximum)); ?>

                            <?php elseif($dbColumn == 'investment_interest_rate'): ?>
                                <?php if(@$row->interest_type == \App\Enums\Investment\InterestType::PERCENT->value): ?>
                                    <?php echo e(shortAmount($row->interest_rate)); ?> %
                                <?php else: ?>
                                    <?php echo e(shortAmount($row->interest_rate)); ?> <?php echo e(getCurrencyName()); ?>

                                <?php endif; ?>
                            <?php elseif($dbColumn == 'investment_interest'): ?>
                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->interest_rate)); ?>

                            <?php elseif($dbColumn == 'should_pay'): ?>
                                <?php echo e($row->should_pay != -1 ? getCurrencySymbol(). shortAmount($row->should_pay) : '****'); ?>

                            <?php elseif($dbColumn == 'investment_time'): ?>
                                <?php echo e($row->timeTable->time ?? 'N/A'); ?> <?php echo e(__('Hours')); ?>

                            <?php elseif($dbColumn == 'investment_return_type'): ?>
                                <?php echo e(\App\Enums\Investment\ReturnType::getName(@$row->interest_return_type)); ?>

                            <?php elseif($dbColumn == 'investment_recommend'): ?>
                                <?php echo e($row->is_recommend ? 'Yes' : 'No'); ?>

                            <?php elseif($dbColumn == 'invest_type'): ?>
                                <span class="badge <?php echo e(\App\Enums\Investment\InvestmentRage::getColor($row->type)); ?>"><?php echo e(\App\Enums\Investment\InvestmentRage::getName($row->type)); ?></span>
                            <?php elseif($dbColumn == 'plan_profit_loss'): ?>
                                <?php if($row->amount > $totalAmount): ?>
                                    <span class="text-success"><?php echo app('translator')->get('Admin Profit'); ?> <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($calculateAmount)); ?></span>
                                <?php else: ?>
                                    <span class="text-danger"><?php echo app('translator')->get('Admin Loss'); ?> <?php echo e(getCurrencySymbol()); ?><?php echo e(abs(shortAmount($calculateAmount))); ?></span>
                                <?php endif; ?>
                            <?php elseif($dbColumn == 'is_reinvest'): ?>
                                <?php if($row->is_reinvest): ?>
                                    <span class="badge badge--primary"><?php echo e(__('Yes')); ?></span>
                                <?php else: ?>
                                    <span class="badge badge--danger"><?php echo e(__('No')); ?></span>
                                <?php endif; ?>
                            <?php elseif($dbColumn == 'trade_currency_id'): ?>
                                <span><?php echo e($row->cryptoCurrency->name ?? 'N/A'); ?></span>
                            <?php elseif($dbColumn == 'trade_original_price'): ?>
                                <span>$<?php echo e(shortAmount($row->original_price)); ?></span>
                            <?php elseif($dbColumn == 'trade_volume'): ?>
                                <span class="badge <?php echo e(\App\Enums\Trade\TradeVolume::getColor($row->volume)); ?>"><?php echo e(\App\Enums\Trade\TradeVolume::getName($row->volume)); ?></span>
                            <?php elseif($dbColumn == 'trade_outcome'): ?>
                                <span class="badge <?php echo e(\App\Enums\Trade\TradeOutcome::getColor($row->outcome)); ?>"><?php echo e(\App\Enums\Trade\TradeOutcome::getName($row->outcome)); ?></span>
                            <?php elseif($dbColumn == 'status'): ?>
                                <span class="badge <?php echo e($color); ?>"><?php echo e($name); ?></span>
                            <?php elseif($dbColumn == 'symbol'): ?>
                                <?php echo e(strtoupper($row->symbol)); ?>

                            <?php elseif($dbColumn == 'priority'): ?>
                                <span class="badge <?php echo e(\App\Enums\TicketPriorityStatus::getColor($row->$dbColumn)); ?>"><?php echo e(\App\Enums\TicketPriorityStatus::getName($row->$dbColumn)); ?></span>
                            <?php elseif($dbColumn == 'menu_parent_id'): ?>
                                <span><?php echo e(optional($row->parent)->name ?? __('N/A')); ?></span>
                            <?php elseif($dbColumn == 'language_action'): ?>
                                <div class="d-flex align-items-center justify-content-md-start justify-content-end gap-1">
                                    <a href="javascript:void(0)" class="badge badge--primary-transparent languageUpdateBtn"
                                       data-toggle="modal"
                                       data-target="#languageUpdateModal"
                                       data-id="<?php echo e($row->id); ?>"
                                       data-name="<?php echo e($row->name); ?>"
                                       data-is_default="<?php echo e($row->is_default); ?>"><?php echo e(__('Edit')); ?></a>
                                    <?php if($row->is_default != \App\Enums\Status::ACTIVE->value): ?>
                                        <a href="javascript:void(0)" class="badge badge--warning-transparent languageDeleteBtn"
                                           data-toggle="modal"
                                           data-target="#languageDeleteModal"
                                           data-id="<?php echo e($row->id); ?>"><?php echo e(__('Delete')); ?></a>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('admin.language.edit', $row->id)); ?>"
                                       class="badge badge--success-transparent menuDeleteBtn"><?php echo e(__('Translate')); ?></a>
                                </div>
                            <?php elseif($dbColumn == 'language_is_default'): ?>
                                <span class="badge <?php echo e(\App\Enums\Status::getColor($row->is_default)); ?>"><?php echo e(\App\Enums\Status::getName($row->is_default, true)); ?></span>
                            <?php elseif($dbColumn == 'menu_action'): ?>
                                <div class="d-flex align-items-center justify-content-md-start justify-content-end gap-1">
                                    <?php if(!$row->is_default): ?>
                                        <a href="<?php echo e(route('admin.pages.section.sortable', $row->url)); ?>" class="badge badge--info-transparent"><?php echo e(__('Sections')); ?></a>
                                        <a href="javascript:void(0)" class="badge badge--primary-transparent menuUpdateBtn"
                                           data-toggle="modal"
                                           data-target="#menuUpdateModal"
                                           data-id="<?php echo e($row->id); ?>"
                                           data-name="<?php echo e($row->name); ?>"
                                           data-url="<?php echo e($row->url); ?>"
                                           data-parent_id="<?php echo e($row->parent_id); ?>"
                                           data-status="<?php echo e($row->status); ?>"><?php echo e(__('Edit')); ?></a>
                                        <a href="javascript:void(0)"
                                           data-id="<?php echo e($row->id); ?>"
                                           class="badge badge--danger-transparent menuDeleteBtn"><?php echo e(__('Delete')); ?></a>
                                    <?php else: ?>
                                        <span><?php echo e(__('N/A')); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php elseif($dbColumn == 'action'): ?>
                                <?php echo $route; ?>

                            <?php elseif($dbColumn == 'phase_action'): ?>
                                <?php echo $phaseRoute; ?>

                            <?php elseif($dbColumn == 'url'): ?>
                                <?php echo e($row->url); ?>

                            <?php elseif($dbColumn == 'blocked'): ?>
                                <span class="badge <?php echo e(\App\Enums\Status::getColor($row->blocked)); ?>"><?php echo e(\App\Enums\Status::getName($row->blocked, true)); ?></span>
                            <?php elseif($dbColumn == 'staking_interest'): ?>
                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->interest)); ?>

                            <?php elseif($dbColumn == 'staking_total_return'): ?>
                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($row->amount + $row->interest)); ?>

                            <?php elseif($dbColumn == 'upcoming_investment_payment'): ?>
                                <?php if($row->status == \App\Enums\Investment\Status::INITIATED->value): ?>
                                    <div data-profit-time="<?php echo e($row->profit_time); ?>" class="payment_time"></div>
                                <?php else: ?>
                                    <span class="badge <?php echo e(\App\Enums\Status::getColor($row->status)); ?>"><?php echo e(\App\Enums\Status::getName($row->status)); ?></span>
                                <?php endif; ?>
                            <?php elseif($dbColumn == 'user_kyc_status'): ?>
                                <span class="badge badge--info"><?php echo e(ucfirst($row->kyc_status)); ?></span>
                            <?php elseif($dbColumn == 'pin_number'): ?>
                                <?php echo e($row->pin_number); ?> <span class="reference-copy" data-pin="<?php echo e($row->pin_number); ?>"><i class="las la-copy"></i></span>
                            <?php else: ?>
                                <span><?php echo e($row->$dbColumn); ?></span>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td class="text-muted text-center" colspan="100%"><?php echo e(__('No Data Found')); ?></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">
    <?php echo e($rows->appends(request()->all())->links()); ?>

</div>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/partials/table.blade.php ENDPATH**/ ?>