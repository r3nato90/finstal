<?php

namespace App\Services;

use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\User\Status;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class EmailVerificationService
{
    public static function sendVerificationEmail(User $user): bool
    {
        if (!Setting::get('require_email_verification', true)) {
            return true;
        }

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addHours(24),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        return EmailSmsTemplateService::sendTemplateEmail(EmailSmsTemplateName::EMAIL_VERIFICATION->value, $user, [
            'user_name' => $user->fullname,
            'verification_link' => $verificationUrl,
        ]);
    }

    /**
     * Check if email verification is required based on system configuration
     * @return bool
     */
    public static function isVerificationRequired(): bool
    {
        return (bool)Setting::get('module_email_verification', true);
    }

    public static function markEmailAsVerified(User $user): bool
    {
        return $user->update(['email_verified_at' => now(), 'status' => Status::ACTIVE->value]);
    }
}
