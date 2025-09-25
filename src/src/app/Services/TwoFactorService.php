<?php

namespace App\Services;

class TwoFactorService
{
    const TOTP_PERIOD = 30;
    const TOTP_DIGITS = 6;
    const TOTP_ALGORITHM = 'sha1';

    public function generateSecretKey(): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        for ($i = 0; $i < 32; $i++) {
            $secret .= $chars[random_int(0, 31)];
        }
        return $secret;
    }

    public function generateQRCodeUrl(string $companyName, string $email, string $secret): string
    {
        $otpUrl = sprintf(
            'otpauth://totp/%s:%s?secret=%s&issuer=%s&algorithm=SHA1&digits=6&period=30',
            rawurlencode($companyName),
            rawurlencode($email),
            $secret,
            rawurlencode($companyName)
        );



        return 'https://quickchart.io/qr?text=' . urlencode($otpUrl) . '&size=200';
    }

    public function verifyCode(string $secret, string $code): bool
    {
        $code = trim($code);

        if (strlen($code) !== 6 || !ctype_digit($code)) {
            \Log::info('2FA code validation failed: invalid format', ['code' => $code]);
            return false;
        }

        $timeStamp = time();
        $window = 2;

        for ($i = -$window; $i <= $window; $i++) {
            $time = $timeStamp + ($i * self::TOTP_PERIOD);
            $expectedCode = $this->getTOTP($secret, $time);

            \Log::info('2FA verification attempt', [
                'window' => $i,
                'time' => $time,
                'expected' => $expectedCode,
                'provided' => $code
            ]);

            if (hash_equals($expectedCode, $code)) {
                \Log::info('2FA code matched at window: ' . $i);
                return true;
            }
        }

        \Log::info('2FA code verification failed: no match found');
        return false;
    }

    private function getTOTP(string $secret, int $time): string
    {
        $timeCounter = floor($time / self::TOTP_PERIOD);
        return $this->generateHOTP($secret, $timeCounter);
    }

    private function generateHOTP(string $secret, int $counter): string
    {
        $binarySecret = $this->base32Decode($secret);

        if ($binarySecret === false) {
            throw new \InvalidArgumentException('Invalid base32 secret');
        }

        $counterBytes = pack('N*', 0) . pack('N*', $counter);
        $hash = hash_hmac('sha1', $counterBytes, $binarySecret, true);
        $offset = ord($hash[19]) & 0x0f;

        $truncatedHash = (
            ((ord($hash[$offset]) & 0x7f) << 24) |
            ((ord($hash[$offset + 1]) & 0xff) << 16) |
            ((ord($hash[$offset + 2]) & 0xff) << 8) |
            (ord($hash[$offset + 3]) & 0xff)
        );

        $otp = $truncatedHash % (10 ** self::TOTP_DIGITS);
        return str_pad((string)$otp, self::TOTP_DIGITS, '0', STR_PAD_LEFT);
    }

    private function base32Decode(string $secret): string|false
    {
        $secret = strtoupper($secret);
        $secret = preg_replace('/[^A-Z2-7]/', '', $secret);

        if (empty($secret)) {
            return false;
        }

        $base32Alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $output = '';
        $v = 0;
        $vbits = 0;

        for ($i = 0, $j = strlen($secret); $i < $j; $i++) {
            $v <<= 5;
            $v += strpos($base32Alphabet, $secret[$i]);
            $vbits += 5;

            while ($vbits >= 8) {
                $vbits -= 8;
                $output .= chr($v >> $vbits);
                $v &= ((1 << $vbits) - 1);
            }
        }

        return $output;
    }

    public function generateRecoveryCodes(): array
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = sprintf('%04d-%04d', random_int(0, 9999), random_int(0, 9999));
        }
        return $codes;
    }

    public function validateSecret(string $secret): bool
    {
        $secret = strtoupper(str_replace(' ', '', $secret));
        return preg_match('/^[A-Z2-7]+$/', $secret) && strlen($secret) >= 16;
    }
}
