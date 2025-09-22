<?php

namespace App\Services;

use App\Mail\GlobalMail;
use App\Models\EmailSmsTemplate;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailSmsTemplateService
{
    public static function sendTemplateEmail(string $templateSlug, User $user, array $variables = []): bool
    {

        try {
            MailConfigService::configure();

            $template = EmailSmsTemplate::where('code', $templateSlug)->where('status', 1)->first();

            if (!$template) {
                Log::error("Email template not found: {$templateSlug}");
                return false;
            }

            $variables = array_merge([
                'site_name' => Setting::get('site_title', 'MineInvest'),
                'currency_symbol' => Setting::get('currency_symbol', '$'),
            ], $variables);

            $subject = self::replaceVariables($template->subject, $variables);
            $body = self::replaceVariables($template->mail_template, $variables);

            Mail::send(new GlobalMail($user, $subject, $body));

            return true;
        } catch (\Exception $e) {
            Log::error('Email send failed: ' . $e->getMessage());
            return false;
        }
    }

    private static function replaceVariables(string $content, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $content = str_replace('[' . $key . ']', $value, $content);
        }
        return $content;
    }
}
