<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XSSProtection
{
    /**
     * Allowed HTML tags and their attributes
     */
    private array $allowedTags = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 'ul', 'ol', 'li',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote', 'code', 'pre', 'a'
    ];

    /**
     * Allowed attributes for specific tags
     */
    private array $allowedAttributes = [
        'a' => ['href', 'title'],
        'img' => ['src', 'alt', 'title', 'width', 'height'],
    ];

    /**
     * Fields that should allow HTML content
     */
    private array $htmlFields = [
        'content', 'description', 'body', 'message', 'comment', 'bio', 'mail_template'
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isJson() || $request->wantsJson()) {
            return $next($request);
        }

        if ($this->shouldSkipRequest($request)) {
            return $next($request);
        }

        $skipRoutes = [
            'api/*',
            'webhook/*',
        ];

        foreach ($skipRoutes as $pattern) {
            if ($request->is($pattern)) {
                return $next($request);
            }
        }

        $input = $request->all();
        $this->sanitizeInput($input);
        $request->merge($input);

        return $next($request);
    }

    /**
     * Recursively sanitize input data
     */
    private function sanitizeInput(array &$input, string $parentKey = ''): void
    {
        array_walk($input, function (&$value, $key) use ($parentKey) {
            $fullKey = $parentKey ? "{$parentKey}.{$key}" : $key;

            if (is_array($value)) {
                $this->sanitizeInput($value, $fullKey);
            } elseif (is_string($value)) {
                $value = $this->sanitizeString($value, $fullKey);
            }
        });
    }

    /**
     * Sanitize a string value
     */
    private function sanitizeString(string $input, string $fieldName): string
    {
        if (empty($input)) {
            return $input;
        }

        if ($this->looksLikeJson($input) || $this->isSerializedData($input)) {
            return $input;
        }

        $input = str_replace(chr(0), '', $input);
        if ($this->shouldAllowHtml($fieldName)) {
            return $this->sanitizeHtml($input);
        } else {
            $input = strip_tags($input);
            $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
            $input = $this->removeJavaScriptProtocols($input);
            return $input;
        }
    }

    /**
     * Check if field should allow HTML
     */
    private function shouldAllowHtml(string $fieldName): bool
    {
        foreach ($this->htmlFields as $htmlField) {
            if (str_contains($fieldName, $htmlField)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Sanitize HTML content while preserving safe tags
     */
    private function sanitizeHtml(string $input): string
    {
        $allowedTagsString = '<' . implode('><', $this->allowedTags) . '>';
        $input = strip_tags($input, $allowedTagsString);
        $input = $this->removeDangerousAttributes($input);
        $input = $this->removeJavaScriptProtocols($input);
        $input = $this->removeXssPatterns($input);

        return $input;
    }

    /**
     * Remove dangerous attributes from HTML
     */
    private function removeDangerousAttributes(string $input): string
    {
        $dangerousAttributes = [
            'onload', 'onclick', 'onmouseover', 'onerror', 'onfocus', 'onblur',
            'onchange', 'onsubmit', 'onreset', 'onselect', 'onkeydown', 'onkeyup',
            'onkeypress', 'onmousedown', 'onmouseup', 'onmousemove', 'onmouseout',
            'style'
        ];

        foreach ($dangerousAttributes as $attr) {
            $input = preg_replace('/' . $attr . '\s*=\s*["\'][^"\']*["\']/i', '', $input);
            $input = preg_replace('/' . $attr . '\s*=\s*[^>\s]*/i', '', $input);
        }

        return $input;
    }

    /**
     * Remove JavaScript protocols and other dangerous patterns
     */
    private function removeJavaScriptProtocols(string $input): string
    {
        $patterns = [
            '/(javascript:|vbscript:|data:|about:|mocha:|livescript:)/i',
            '/expression\s*\(/i',
            '/binding\s*:/i',
            '/behaviour\s*:/i',
            '/@import/i',
        ];

        foreach ($patterns as $pattern) {
            $input = preg_replace($pattern, '', $input);
        }

        return $input;
    }

    /**
     * Remove additional XSS patterns
     */
    private function removeXssPatterns(string $input): string
    {
        $patterns = [
            '/<script[^>]*>.*?<\/script>/is',
            '/<iframe[^>]*>.*?<\/iframe>/is',
            '/<object[^>]*>.*?<\/object>/is',
            '/<embed[^>]*>/i',
            '/<applet[^>]*>.*?<\/applet>/is',
            '/<meta[^>]*>/i',
            '/<link[^>]*>/i',
        ];

        foreach ($patterns as $pattern) {
            $input = preg_replace($pattern, '', $input);
        }

        return $input;
    }

    /**
     * Check if string looks like JSON
     */
    private function looksLikeJson(string $string): bool
    {
        if (empty($string)) {
            return false;
        }

        $trimmed = trim($string);
        $hasJsonStructure = (
            (str_starts_with($trimmed, '{') && str_ends_with($trimmed, '}')) ||
            (str_starts_with($trimmed, '[') && str_ends_with($trimmed, ']'))
        );

        if (!$hasJsonStructure) {
            return false;
        }

        json_decode($trimmed);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Check if string is serialized data
     */
    private function isSerializedData(string $string): bool
    {
        $trimmed = trim($string);
        return preg_match('/^[aObis]:\d+:/', $trimmed) === 1;
    }

    /**
     * Check if request should be completely skipped
     */
    private function shouldSkipRequest(Request $request): bool
    {
        $contentType = $request->header('Content-Type', '');
        $skipContentTypes = [
            'application/json',
            'text/json',
            'multipart/form-data',
            'application/xml',
            'text/xml'
        ];

        foreach ($skipContentTypes as $type) {
            if (str_contains($contentType, $type)) {
                return true;
            }
        }

        return false;
    }
}
