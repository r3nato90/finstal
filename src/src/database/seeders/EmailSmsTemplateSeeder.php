<?php

namespace Database\Seeders;

use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\Status;
use App\Models\EmailSmsTemplate;
use Illuminate\Database\Seeder;

class EmailSmsTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $emailSmsTemplates = [
            [
                'code' => EmailSmsTemplateName::EMAIL_VERIFICATION->value,
                'name' => "Email Verification",
                'subject' => "Verify Your Email - [site_name]",
                'from_email' => "demo@gmail.com",
                'mail_template' => '<h1>Email Verification</h1><p>Hi [user_name],</p><p>Please click the link below to verify your email address:</p><p><a href="[verification_link]">Verify Email</a></p><p>This link will expire in 24 hours.</p><p>Best regards,<br>The [site_name] Team</p>',
                'sms_template' => "",
                'short_key' => [
                    'user_name' => "user_name",
                    'site_name' => "site_name",
                    'verification_link' => "verification_link",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::PASSWORD_RESET_CODE->value,
                'name' => "Password Reset for User",
                'subject' => "Password Reset mail",
                'from_email' => "demo@gmail.com",
                'mail_template' => '<h1>Password Reset</h1><p>Hi [user_name],</p><p>We received a request to reset your password. Please click the link below to reset your password:</p><p><a href="[reset_link]">Reset Password</a></p><p>If you didn\'t request this password reset, please ignore this email.</p><p>This link will expire in a limited time for security reasons.</p><p>Best regards,<br>The [site_name] Team</p>',
                'sms_template' => "Your account recovery code is: [reset_link]",
                'short_key' => [
                    'user_name' => "user_name",
                    'reset_link' => "reset_link",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::PASSWORD_RESET_CODE_API->value,
                'name' => "Password Reset for User Api",
                'subject' => "Password Reset mail",
                'from_email' => "demo@gmail.com",
                'mail_template' => '<h1>Password Reset</h1><p>Hi [user_name],</p><p>We received a request to reset your password. reset your password token:</p><p><p>[token]</p></p><p>If you didn\'t request this password reset, please ignore this email.</p><p>This link will expire in a limited time for security reasons.</p><p>Best regards,<br>The [site_name] Team</p>',
                'sms_template' => "Your account recovery code is: [token]",
                'short_key' => [
                    'user_name' => "user_name",
                    'token' => "token",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::BALANCE_ADD->value,
                'name' => "Balance Add by Admin",
                'subject' => "Your Account has been credited",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Your account has been credited with [currency][amount]. Your new balance is [currency][post_balance].",
                'sms_template' => "Your account has been credited with [currency][amount]. Your new balance is [currency][post_balance].",
                'short_key' => [
                    'amount' => "Amount added by admin",
                    'wallet_name' => "Wallet Name",
                    'currency' => "Currency",
                    'post_balance' => "Balance after this operation",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::BALANCE_SUBTRACT->value,
                'name' => "Balance Subtract by Admin",
                'subject' => "Your Account has been debited",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Your account has been debited with [currency][amount]. Your new balance is [currency][post_balance].",
                'sms_template' => "Your account has been debited with [currency][amount]. Your new balance is [currency][post_balance].",
                'short_key' => [
                    'amount' => "Amount subtracted by admin",
                    'wallet_type' => "Wallet Type",
                    'currency' => "Currency",
                    'post_balance' => "Balance after this operation",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::WITHDRAW_REQUEST->value,
                'name' => "Withdraw Request",
                'subject' => "Withdraw Request",
                'from_email' => "demo@gmail.com",
                'mail_template' => "We have received your withdrawal request for [currency][amount]. Your request is under review.",
                'sms_template' => "Withdrawal request of [currency][amount] received. It's under review.",
                'short_key' => [
                    'amount' => "Amount requested",
                    'charge' => "Charges",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::WITHDRAW_APPROVED->value,
                'name' => "Withdraw Approved",
                'subject' => "Withdraw Approved",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Your withdrawal request for [currency][amount] has been approved. The amount has been processed.",
                'sms_template' => "Your withdrawal of [currency][amount] has been approved and processed.",
                'short_key' => [
                    'amount' => "Amount",
                    'charge' => "Charges",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::WITHDRAW_REJECTED->value,
                'name' => "Withdraw Rejected",
                'subject' => "Withdraw Rejected",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Your withdrawal request for [currency][amount] has been rejected. Please check your account for details.",
                'sms_template' => "Your withdrawal of [currency][amount] has been rejected.",
                'short_key' => [
                    'amount' => "Amount",
                    'charge' => "Charges",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::DEPOSIT_APPROVED->value,
                'name' => "Deposit Approved",
                'subject' => "Deposit Approved",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Your deposit of [currency][amount] has been approved and credited to your account.",
                'sms_template' => "Your deposit of [currency][amount] has been approved and credited.",
                'short_key' => [
                    'amount' => "Amount",
                    'charge' => "Charges",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::TRADITIONAL_DEPOSIT->value,
                'name' => "Traditional Deposit",
                'subject' => "Traditional Deposit",
                'from_email' => "demo@gmail.com",
                'mail_template' => "A traditional deposit of [currency][amount] has been made to your account.",
                'sms_template' => "Traditional deposit of [currency][amount] has been made.",
                'short_key' => [
                    'amount' => "Amount",
                    'charge' => "Charges",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::DEPOSIT_REJECTED->value,
                'name' => "Deposit Rejected",
                'subject' => "Deposit Rejected",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Your deposit of [currency][amount] has been rejected. Please check your account for details.",
                'sms_template' => "Your deposit of [currency][amount] has been rejected.",
                'short_key' => [
                    'amount' => "Amount",
                    'charge' => "Charges",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::PIN_RECHARGE->value,
                'name' => "Pin Recharge",
                'subject' => "Pin Recharge",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Your pin recharge for [currency][amount] is successful. Your pin number is [pin_number].",
                'sms_template' => "Pin recharge of [currency][amount] successful. Pin: [pin_number]",
                'short_key' => [
                    'currency' => "Currency Symbol",
                    'amount' => "Amount",
                    'pin_number' => "Pin Number",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::REFERRAL_COMMISSION->value,
                'name' => "Referral Commission",
                'subject' => "Referral Commission",
                'from_email' => "demo@gmail.com",
                'mail_template' => "You have earned a referral commission of [currency][amount].",
                'sms_template' => "Referral commission of [currency][amount] earned.",
                'short_key' => [
                    'amount' => "Commission Amount",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::LEVEL_COMMISSION->value,
                'name' => "Level Commission",
                'subject' => "Level Commission",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Hello, please find your Level Commission details below:\nAmount: [currency][amount]\nIf you encounter any issues or need further assistance, feel free to reach out.",
                'sms_template' => "Level Commission: Amount: [currency][amount]",
                'short_key' => [
                    'amount' => "Amount",
                    'currency' => "Currency",
                ],
                'status' => Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::INVESTMENT_SCHEME_PURCHASE->value,
                'name' => "Investment Scheme purchase",
                'subject' => "Invest Scheme",
                'from_email' => "demo@gmail.com",
                'mail_template' => "You have successfully purchased the following investment scheme:\nPlan Name: [plan_name]\nAmount: [currency][amount]\nInterest Rate: [interest_rate]%\nDuration: [duration] days.\nFor more details, feel free to contact us.",
                'sms_template' => "Invest Scheme Purchase: Plan: [plan_name], Amount: [currency][amount]",
                'short_key' => [
                    'amount' => "Amount",
                    'interest_rate' => "Interest Rate",
                    'plan_name' => "Plan Name",
                    'currency' => "Currency",
                    'duration' => "Duration",
                ],
                'status' => Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::INVESTMENT_COMPLETE->value,
                'name' => "Investment Complete",
                'subject' => "Investment Complete",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Your investment has been successfully completed.\nPlan Name: [plan_name]\nAmount: [currency][amount]\nInterest Rate: [interest_rate]%.\nThank you for your trust in our services.",
                'sms_template' => "Investment Complete: [plan_name], Amount: [currency][amount]",
                'short_key' => [
                    'amount' => "Amount",
                    'interest_rate' => "Interest Rate",
                    'plan_name' => "Plan Name",
                    'currency' => "Currency",
                ],
                'status' => Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::RE_INVESTMENT->value,
                'name' => "Re Investment",
                'subject' => "Re Investment",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Your re-investment has been successfully processed.\nPlan Name: [plan_name]\nAmount: [currency][amount]\nInterest Rate: [interest_rate]%\nDuration: [duration] days.\nFor more details, please reach out.",
                'sms_template' => "Re Invest: [plan_name], Amount: [currency][amount]",
                'short_key' => [
                    'amount' => "Amount",
                    'interest_rate' => "Interest Rate",
                    'plan_name' => "Plan Name",
                    'currency' => "Currency",
                    'duration' => "Duration",
                ],
                'status' => Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::INVESTMENT_CANCEL->value,
                'name' => "Investment Cancel",
                'subject' => "Investment Cancel",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Your investment has been canceled.\nPlan Name: [plan_name]\nAmount: [currency][amount]\nInterest Rate: [interest_rate]%.\nIf you have any questions, feel free to contact us.",
                'sms_template' => "Investment Cancel: [plan_name], Amount: [currency][amount]",
                'short_key' => [
                    'amount' => "Amount",
                    'interest_rate' => "Interest Rate",
                    'plan_name' => "Plan Name",
                    'currency' => "Currency",
                ],
                'status' => Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::MATRIX_ENROLLED->value,
                'name' => "Matrix Enrolled",
                'subject' => "Matrix Enrolled",
                'from_email' => "demo@gmail.com",
                'mail_template' => "You have been successfully enrolled in the matrix.\nAmount: [currency][amount]\nReferral Commission: [currency][referral_commission]\nPlan Name: [plan_name].\nThank you for joining us!",
                'sms_template' => "Matrix Enrolled: Amount: [currency][amount], Referral Commission: [currency][referral_commission]",
                'short_key' => [
                    'amount' => "Amount",
                    'referral_commission' => "Referral Commission",
                    'plan_name' => "Plan Name",
                    'currency' => "Currency",
                ],
                'status' => Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::BALANCE_TRANSFER_RECEIVE->value,
                'name' => "Balance transfer receive",
                'subject' => "Balance transfer received",
                'from_email' => "demo@gmail.com",
                'mail_template' => "You have received a balance transfer.\nAmount: [currency][amount].\nThank you for using our services.",
                'sms_template' => "Balance Transfer Receive: Amount: [currency][amount]",
                'short_key' => [
                    'amount' => "Amount",
                    'currency' => "Currency",
                ],
                'status' => Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::INVESTMENT_PLAN_NOTIFY->value,
                'name' => "Investment Plan create notify",
                'subject' => "Investment Plan Notify",
                'from_email' => "demo@gmail.com",
                'mail_template' => "We have created a new investment plan:\nPlan Name: [name]\nAmount: [currency][amount]\nMinimum Amount: [currency][minimum]\nMaximum Amount: [currency][maximum]\nInterest Rate: [interest_rate]%\nDuration: [duration] days.\nFor more details, please contact us.",
                'sms_template' => "New Investment Plan: [name], Amount: [currency][amount]",
                'short_key' => [
                    'name' => "Plan Name",
                    'amount' => "Amount",
                    'minimum' => "Minimum Amount",
                    'maximum' => "Maximum Amount",
                    'interest_rate' => "Interest Rate",
                    'currency' => 'Currency',
                    'duration' => "Duration",
                ],
                'status' => Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::STAKING_INVESTMENT_NOTIFY->value,
                'name' => "Staking Investment Notify",
                'subject' => "Staking Invest",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Your staking investment has been successfully made.\nAmount: [currency][amount]\nInterest: [currency][interest]\nExpiration Date: [expiration_date].\nFor more information, feel free to contact us.",
                'sms_template' => "Staking Investment: Amount: [currency][amount], Interest: [currency][interest], Expiration Date: [expiration_date]",
                'short_key' => [
                    'amount' => "Amount",
                    'interest' => "Interest",
                    'expiration_date' => "Expiration Date",
                    'currency' => "Currency",
                ],
                'status' => Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::WELCOME->value,
                'name' => 'Welcome Email',
                'subject' => 'Welcome to [site_name]!',
                'from_email' => "demo@gmail.com",
                'mail_template' => '<h1>Welcome [user_name]!</h1><p>Thank you for joining [site_name]. We are excited to have you on board.</p><p>Your account has been successfully created and you can now start trading.</p><p>Best regards,<br>The [site_name] Team</p>',
                'sms_template' => 'Welcome [user_name]! Thank you for joining [site_name]. We are excited to have you on board',
                'short_key' => [
                    'user_name' => 'user_name',
                    'site_name' => 'site_name',
                ],
                'status' => Status::ACTIVE->value,
            ],
        ];

        EmailSmsTemplate::truncate();
        collect($emailSmsTemplates)->each(fn($emailSmsTemplate) => EmailSmsTemplate::create($emailSmsTemplate));
    }
}

