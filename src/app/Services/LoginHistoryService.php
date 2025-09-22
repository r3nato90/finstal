<?php

namespace App\Services;

use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginHistoryService
{
    /**
     * @param string $email
     * @param bool $successful
     * @param Request $request
     * @param null $userId
     * @return void
     */
    public function logAttempt(string $email, bool $successful, Request $request, $userId = null): void
    {
        $userAgent = $this->getUserAgent($request);
        $ipAddress = $this->getClientIpAddress($request);
        $parsedUserAgent = $this->parseUserAgent($userAgent);
        $location = $this->getLocationFromIp($ipAddress);
        LoginAttempt::create([
            'email' => filter_var($email, FILTER_SANITIZE_EMAIL),
            'user_id' => $successful ? $userId : null,
            'ip_address' => filter_var($ipAddress, FILTER_VALIDATE_IP) ? $ipAddress : '0.0.0.0',
            'user_agent' => $this->sanitizeString($userAgent),
            'location' => $this->sanitizeString($location),
            'device_type' => $this->sanitizeString($parsedUserAgent['device_type']),
            'browser' => $this->sanitizeString($parsedUserAgent['browser']),
            'platform' => $this->sanitizeString($parsedUserAgent['platform']),
            'successful' => $successful,
            'attempted_at' => now(),
        ]);
        $this->cleanupOldRecords($email);
    }

    /**
     * @param string $input
     * @return string
     */
    private function sanitizeString(string $input): string
    {
        $sanitized = strip_tags($input);
        $sanitized = htmlspecialchars($sanitized, ENT_QUOTES, 'UTF-8');
        return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $sanitized);
    }


    /**
     * @param string $ipAddress
     * @return string
     */
    private function getLocationFromIp(string $ipAddress): string
    {
        if ($this->isPrivateIp($ipAddress)) {
            return 'Local Network';
        }

        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5,
                    'method' => 'GET',
                    'header' => [
                        'User-Agent: Laravel-App/1.0',
                        'Accept: application/json'
                    ]
                ]
            ]);

            $response = @file_get_contents("http://ip-api.com/json/{$ipAddress}?fields=status,country,regionName,city", false, $context);
            if ($response !== false) {
                $data = json_decode($response, true);

                if ($data && isset($data['status']) && $data['status'] === 'success') {
                    $location = [];
                    if (!empty($data['city'])) $location[] = $this->sanitizeString($data['city']);
                    if (!empty($data['regionName'])) $location[] = $this->sanitizeString($data['regionName']);
                    if (!empty($data['country'])) $location[] = $this->sanitizeString($data['country']);

                    return !empty($location) ? implode(', ', $location) : 'Unknown';
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to get location for IP: ' . $ipAddress, ['error' => $e->getMessage()]);
        }

        return 'Unknown';
    }

    /**
     * @param string $ip
     * @return bool
     */
    private function isPrivateIp(string $ip): bool
    {
        return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }


    /**
     * @param string $userAgent
     * @return string[]
     */
    private function parseUserAgent(string $userAgent): array
    {
        if (empty($userAgent) || $userAgent === 'Unknown') {
            return [
                'browser' => 'Unknown',
                'device_type' => 'Unknown',
                'platform' => 'Unknown'
            ];
        }

        $userAgent = substr($userAgent, 0, 500);
        $userAgent = preg_replace('/[<>"\']/', '', $userAgent);
        $userAgent = strtolower($userAgent);
        $browser = 'Unknown';
        if (str_contains($userAgent, 'edg/') || str_contains($userAgent, 'edge/')) {
            $browser = 'Microsoft Edge';
        } elseif (str_contains($userAgent, 'chrome/') && !str_contains($userAgent, 'edg/')) {
            if (str_contains($userAgent, 'brave/')) {
                $browser = 'Brave';
            } else {
                $browser = 'Google Chrome';
            }
        } elseif (str_contains($userAgent, 'firefox/')) {
            $browser = 'Mozilla Firefox';
        } elseif (str_contains($userAgent, 'safari/') && !str_contains($userAgent, 'chrome/')) {
            $browser = 'Safari';
        } elseif (str_contains($userAgent, 'opera/') || str_contains($userAgent, 'opr/')) {
            $browser = 'Opera';
        } elseif (str_contains($userAgent, 'trident/') || str_contains($userAgent, 'msie')) {
            $browser = 'Internet Explorer';
        }

        $deviceType = 'Desktop';
        if (str_contains($userAgent, 'mobile') ||
            str_contains($userAgent, 'android') ||
            str_contains($userAgent, 'iphone') ||
            str_contains($userAgent, 'ipod') ||
            str_contains($userAgent, 'blackberry') ||
            str_contains($userAgent, 'webos') ||
            str_contains($userAgent, 'opera mini')) {
            $deviceType = 'Mobile';
        } elseif (str_contains($userAgent, 'tablet') ||
            str_contains($userAgent, 'ipad') ||
            (str_contains($userAgent, 'android') && !str_contains($userAgent, 'mobile'))) {
            $deviceType = 'Tablet';
        }

        $platform = 'Unknown';
        if (str_contains($userAgent, 'windows nt 10')) {
            $platform = 'Windows 10';
        } elseif (str_contains($userAgent, 'windows nt 6.3')) {
            $platform = 'Windows 8.1';
        } elseif (str_contains($userAgent, 'windows nt 6.2')) {
            $platform = 'Windows 8';
        } elseif (str_contains($userAgent, 'windows nt 6.1')) {
            $platform = 'Windows 7';
        } elseif (str_contains($userAgent, 'windows')) {
            $platform = 'Windows';
        } elseif (str_contains($userAgent, 'mac os x') || str_contains($userAgent, 'macos')) {
            $platform = 'macOS';
        } elseif (str_contains($userAgent, 'linux')) {
            if (str_contains($userAgent, 'android')) {
                $platform = 'Android';
            } else {
                $platform = 'Linux';
            }
        } elseif (str_contains($userAgent, 'iphone os') || str_contains($userAgent, 'ios')) {
            $platform = 'iOS';
        } elseif (str_contains($userAgent, 'android')) {
            $platform = 'Android';
        }

        return [
            'browser' => $browser,
            'device_type' => $deviceType,
            'platform' => $platform
        ];
    }

    /**
     * @param Request $request
     * @return string
     */
    private function getUserAgent(Request $request): string
    {
        $userAgent = $request->userAgent();
        if (empty($userAgent)) {
            $userAgent = $request->header('User-Agent');
        }

        if (empty($userAgent) && isset($_SERVER['HTTP_USER_AGENT'])) {
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
        }

        if (empty($userAgent)) {
            $userAgent = 'Unknown';
        }

        $userAgent = strip_tags($userAgent);
        $userAgent = preg_replace('/[<>"\']/', '', $userAgent);
        return substr($userAgent, 0, 500);
    }


    /**
     * @param Request $request
     * @return string
     */
    private function getClientIpAddress(Request $request): string
    {
        $ip = $request->ip();
        $ipKeys = [
            'HTTP_CF_CONNECTING_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_CLIENT_IP',
            'REMOTE_ADDR'
        ];

        foreach ($ipKeys as $key) {
            if (!empty($_SERVER[$key])) {
                $ips = explode(',', $_SERVER[$key]);
                $candidateIp = trim($ips[0]);
                if (filter_var($candidateIp, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $candidateIp;
                }
            }
        }

        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
    }


    /**
     * @param string $email
     * @return void
     */
    private function cleanupOldRecords(string $email): void
    {
        $keepCount = 100;

        $totalRecords = LoginAttempt::where('email', $email)->count();

        if ($totalRecords > $keepCount) {
            $recordsToDelete = $totalRecords - $keepCount;

            LoginAttempt::where('email', $email)
                ->orderBy('attempted_at', 'asc')
                ->limit($recordsToDelete)
                ->delete();
        }
    }


    public function getHistoryForUser(int $userId, int $perPage = 15)
    {
        $user = \App\Models\User::find($userId);
        if (!$user) {
            return collect();
        }

        $history = LoginAttempt::where('email', $user->email)
            ->orderBy('attempted_at', 'desc')
            ->paginate($perPage);

        if ($history && isset($history->items)) {
            $history->getCollection()->transform(function ($item) {
                $item->user_agent = $this->sanitizeString($item->user_agent ?? '');
                $item->location = $this->sanitizeString($item->location ?? '');
                $item->browser = $this->sanitizeString($item->browser ?? '');
                $item->device_type = $this->sanitizeString($item->device_type ?? '');
                $item->platform = $this->sanitizeString($item->platform ?? '');
                return $item;
            });
        }

        return $history;
    }


    /**
     * @param string $email
     * @param int $minutes
     * @return int
     */
    public function getRecentFailedAttempts(string $email, int $minutes = 60): int
    {
        return LoginAttempt::where('email', filter_var($email, FILTER_SANITIZE_EMAIL))
            ->where('successful', false)
            ->where('attempted_at', '>=', now()->subMinutes($minutes))
            ->count();
    }


    /**
     * @param string $email
     * @return array
     */
    public function calculateLoginStats(string $email): array
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $totalAttempts = LoginAttempt::where('email', $email)->count();
        $successfulLogins = LoginAttempt::where('email', $email)->where('successful', true)->count();
        $failedAttempts = LoginAttempt::where('email', $email)->where('successful', false)->count();
        $uniqueIps = LoginAttempt::where('email', $email)->distinct('ip_address')->count('ip_address');

        return [
            'total_attempts' => $totalAttempts,
            'successful_logins' => $successfulLogins,
            'failed_attempts' => $failedAttempts,
            'unique_ips' => $uniqueIps,
        ];
    }
}
