<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'logo_dark',
                'value' => 'dark_logo.png',
                'type' => 'file',
                'group' => 'appearance',
                'label' => 'Dark Logo',
                'description' => 'Logo file for dark theme'
            ],
            [
                'key' => 'logo_white',
                'value' => 'white_logo.png',
                'type' => 'file',
                'group' => 'appearance',
                'label' => 'White Logo',
                'description' => 'Logo file for white theme'
            ],
            [
                'key' => 'logo_favicon',
                'value' => 'favicon.png',
                'type' => 'file',
                'group' => 'appearance',
                'label' => 'Favicon Logo',
                'description' => 'Logo file for favicon theme'
            ],
            [
                'key' => 'email',
                'value' => 'demo@example.com',
                'type' => 'email',
                'group' => 'appearance',
                'label' => 'Email',
                'description' => 'Application email setting'
            ],
            [
                'key' => 'phone',
                'value' => '1234567890',
                'type' => 'text',
                'group' => 'appearance',
                'label' => 'Phone',
                'description' => 'Application phone setting'
            ],
            [
                'key' => 'address',
                'value' => '3971 Roden Dr NE',
                'type' => 'text',
                'group' => 'appearance',
                'label' => 'Address',
                'description' => 'Application address setting'
            ],
            [
                'key' => 'paginate',
                'value' => '20',
                'type' => 'number',
                'group' => 'appearance',
                'label' => 'Paginate',
                'description' => 'Application paginate setting'
            ],
            [
                'key' => 'timezone',
                'value' => 'UTC',
                'type' => 'text',
                'group' => 'appearance',
                'label' => 'Timezone',
                'description' => 'Application timezone setting'
            ],
            [
                'key' => 'site_title',
                'value' => 'FinFunder',
                'type' => 'text',
                'group' => 'appearance',
                'label' => 'Site title',
                'description' => 'Application site_title setting'
            ],
            [
                'key' => 'currency_code',
                'value' => 'USD',
                'type' => 'text',
                'group' => 'appearance',
                'label' => 'Currency code',
                'description' => 'Application currency_code setting'
            ],
            [
                'key' => 'currency_symbol',
                'value' => '$',
                'type' => 'text',
                'group' => 'appearance',
                'label' => 'Currency symbol',
                'description' => 'Application currency_symbol setting'
            ],
            [
                'key' => 'module_e_pin',
                'value' => '1',
                'type' => 'select',
                'group' => 'system',
                'label' => 'E pin Module',
                'description' => 'If you disable this module, users won\'t be able to recharge E-pins on this system.'
            ],
            [
                'key' => 'module_language',
                'value' => '1',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Language Module',
                'description' => 'If you disable this module, users won\'t be able to change the system language.'
            ],
            [
                'key' => 'module_binary_trade',
                'value' => '1',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Binary trade Module',
                'description' => 'If you deactivate the binary trade option, the binary trading feature will be turned off.'
            ],
            [
                'key' => 'module_practice_trade',
                'value' => '1',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Practice trade Module',
                'description' => 'If you deactivate the practice trade option, the practice trading feature will be turned off.'
            ],
            [
                'key' => 'module_balance_transfer',
                'value' => '1',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Balance transfer Module',
                'description' => 'Enabling this module allows users to initiate balance transfers within the system.'
            ],
            [
                'key' => 'module_kyc_verification',
                'value' => '1',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Kyc verification Module',
                'description' => 'If you disable this module, users won\'t undergo KYC verification in this system.'
            ],
            [
                'key' => 'module_sms_notification',
                'value' => '2',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Sms notification Module',
                'description' => 'If you disable this module, users won\'t receive SMS notifications in this system.'
            ],
            [
                'key' => 'module_withdraw_request',
                'value' => '1',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Withdraw request Module',
                'description' => 'If you disable this module, users won\'t be able to submit withdrawal requests in this system.'
            ],
            [
                'key' => 'module_cookie_activation',
                'value' => '1',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Cookie activation Module',
                'description' => 'If you disable this module, users won\'t be able to activate cookies in this system.'
            ],
            [
                'key' => 'module_investment_reward',
                'value' => '1',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Investment reward Module',
                'description' => 'Enabling this module allows users to receive rewards for their investments within the system.'
            ],
            [
                'key' => 'module_email_notification',
                'value' => '1',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Email notification Module',
                'description' => 'If you disable this module, users won\'t receive email notifications in this system.'
            ],
            [
                'key' => 'module_email_verification',
                'value' => '1',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Email verification Module',
                'description' => 'If you deactivate the email verification module, users won\'t be able to verify their email addresses in this system.'
            ],
            [
                'key' => 'module_registration_status',
                'value' => '1',
                'type' => 'select',
                'group' => 'system',
                'label' => 'Registration status Module',
                'description' => 'If you disable this module, new users won\'t be able to register on this system.'
            ],
            [
                'key' => 'primary_color',
                'value' => '#fe710d',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Primary color',
                'description' => 'Theme primary_color configuration'
            ],
            [
                'key' => 'secondary_color',
                'value' => '#fe710d',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Secondary color',
                'description' => 'Theme secondary_color configuration'
            ],
            [
                'key' => 'primary_text_color',
                'value' => '#150801',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Primary text color',
                'description' => 'Theme primary_text_color configuration'
            ],
            [
                'key' => 'secondary_text_color',
                'value' => '#6a6a6a',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Secondary text color',
                'description' => 'Theme secondary_text_color configuration'
            ],
            [
                'key' => 'mail_host',
                'value' => 'mail.smtp2go.com',
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail Host',
                'description' => 'Email host configuration'
            ],
            [
                'key' => 'mail_port',
                'value' => '465',
                'type' => 'number',
                'group' => 'mail',
                'label' => 'Mail Port',
                'description' => 'Email port configuration'
            ],
            [
                'key' => 'mail_password',
                'value' => 'demo',
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail Password',
                'description' => 'Email password configuration'
            ],
            [
                'key' => 'mail_username',
                'value' => 'demo',
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail Username',
                'description' => 'Email username configuration'
            ],
            [
                'key' => 'mail_from_name',
                'value' => 'FinFunder',
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail From name',
                'description' => 'Email from_name configuration'
            ],
            [
                'key' => 'mail_encryption',
                'value' => 'tls',
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail Encryption',
                'description' => 'Email encryption configuration'
            ],
            [
                'key' => 'mail_from_email',
                'value' => 'noreply@kloudinnovation.com',
                'type' => 'text',
                'group' => 'mail',
                'label' => 'Mail From email',
                'description' => 'Email from_email configuration'
            ],
            [
                'key' => 'mail_template',
                'value' => 'Hello Dear,',
                'type' => 'textarea',
                'group' => 'mail',
                'label' => 'Mail Template',
                'description' => 'Mail Template configuration'
            ],
            [
                'key' => 'investment_matrix',
                'value' => '1',
                'type' => 'select',
                'group' => 'investment',
                'label' => 'Matrix Investment',
                'description' => 'Enable/disable matrix investment feature'
            ],
            [
                'key' => 'investment_ico_token',
                'value' => '1',
                'type' => 'select',
                'group' => 'investment',
                'label' => 'Ico token Investment',
                'description' => 'Enable/disable ico_token investment feature'
            ],
            [
                'key' => 'investment_investment',
                'value' => '1',
                'type' => 'select',
                'group' => 'investment',
                'label' => 'Investment Investment',
                'description' => 'Enable/disable investment investment feature'
            ],
            [
                'key' => 'investment_trade_prediction',
                'value' => '1',
                'type' => 'select',
                'group' => 'investment',
                'label' => 'Trade prediction Investment',
                'description' => 'Enable/disable trade_prediction investment feature'
            ],
            [
                'key' => 'investment_staking_investment',
                'value' => '1',
                'type' => 'select',
                'group' => 'investment',
                'label' => 'Staking investment Investment',
                'description' => 'Enable/disable staking_investment investment feature'
            ],
            [
                'key' => 'e_pin_charge',
                'value' => '2',
                'type' => 'number',
                'group' => 'finance',
                'label' => 'E pin charge',
                'description' => 'Commission/charge for e_pin_charge'
            ],
            [
                'key' => 'balance_transfer_charge',
                'value' => '1',
                'type' => 'number',
                'group' => 'finance',
                'label' => 'Balance transfer charge',
                'description' => 'Commission/charge for balance_transfer_charge'
            ],
            [
                'key' => 'investment_cancel_charge',
                'value' => '1',
                'type' => 'number',
                'group' => 'finance',
                'label' => 'Investment cancel charge',
                'description' => 'Commission/charge for investment_cancel_charge'
            ],
            [
                'key' => 'investment_transfer_charge',
                'value' => '1',
                'type' => 'number',
                'group' => 'finance',
                'label' => 'Investment transfer charge',
                'description' => 'Commission/charge for investment_transfer_charge'
            ],

            [
                'key' => 'seo_image',
                'value' => null,
                'type' => 'file',
                'group' => 'seo',
                'label' => 'SEO Image',
                'description' => 'SEO image configuration'
            ],
            [
                'key' => 'seo_title',
                'value' => '-',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'SEO Title',
                'description' => 'SEO title configuration'
            ],
            [
                'key' => 'seo_keywords',
                'value' => '["crypto","trade"]',
                'type' => 'json',
                'group' => 'seo',
                'label' => 'SEO Keywords',
                'description' => 'SEO keywords configuration'
            ],
            [
                'key' => 'seo_description',
                'value' => 'FinFunder',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'SEO Description',
                'description' => 'SEO description configuration'
            ],
            [
                'key' => 'version',
                'value' => '1.0',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Application Version',
                'description' => 'Application Version configuration'
            ],
            [
                'key' => 'height',
                'value' => '1',
                'type' => 'text',
                'group' => 'matrix_parameters',
                'label' => 'Matrix Height',
                'description' => 'Set the height dimension for matrix calculations'
            ],
            [
                'key' => 'width',
                'value' => '2',
                'type' => 'text',
                'group' => 'matrix_parameters',
                'label' => 'Matrix Width',
                'description' => 'Set the width dimension for matrix calculations'
            ],
            [
                'key' => 'holiday_setting',
                'value' => '["saturday","sunday"]',
                'type' => 'json',
                'group' => 'investment',
                'label' => 'Holiday Setting',
                'description' => 'Days when investment profit calculations should be skipped (non-working days)'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
