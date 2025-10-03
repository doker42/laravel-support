<?php

namespace App\Services;

use App\Models\Target;
use App\Models\TargetStatus;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TargetHttpStatusChecker
{
    public const CHECK_HEADERS = [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
        'Accept-Language' => 'en-US,en;q=0.9',
        'Referer' => 'https://google.com/',
        'Connection' => 'keep-alive',
        'Upgrade-Insecure-Requests' => '1',
    ];


    public static function checkUrlComplex(string $url)
    {
        $validation = self::validateUrl($url);
        if (!$validation['status']) {
            return $validation;
        }

        return self::checkUrlStatusAlt($url);
    }


    private static function validateUrl(string $url): array
    {
        if (empty($url)) {
            return [
                'status'  => false,
                'message' => "URL can't be empty. Try again",
            ];
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'status'  => false,
                'message' => "Invalid URL. Try again",
            ];
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);
        if (!in_array($scheme, ['http', 'https'])) {
            return [
                'status'  => false,
                'message' => "URL should begin from http:// or https://. Try again",
            ];
        }

        return [
            'status'  => true,
            'message' => "Valid URL",
        ];
    }


    public static function checkUrlStatusAlt(string $url, int $timeout = 10): array
    {
        $isOk = fn ($status) => $status >= 200 && $status < 400;

        // 1) HEAD-запрос
        try {
            $head =  Http::timeout($timeout)
                    ->withHeaders(self::CHECK_HEADERS)
                    ->get($url);
            return [
                'message' => 'HTTP status ' . $head->status(),
                'status'  => $isOk($head->status()),
            ];
        } catch (\Exception $e) {
            // 2) Если HEAD не удался, пробуем GET
            try {
                $get = Http::timeout($timeout)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                        'Accept-Language' => 'en-US,en;q=0.9',
                        'Referer' => parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST) . '/',
                    ])
                    ->get($url);

                return [
                    'message' => 'HTTP status ' . $get->status(),
                    'status'  => $isOk($head->status()),
                ];
            } catch (\Exception $e2) {
                return [
                    'message' => 'Error ' . $e2->getMessage(),
                    'status'  => false,
                ];
            }
        }
    }


    /**
     *  NO USAGE
     *
     * @param string $url
     * @param int $timeout
     * @return array
     */
    public static function checkUrlStatusCurl(string $url, int $timeout = 8)
    {
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_NOBODY        => true,  // HEAD-запрос (только заголовки)
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true, // следовать за редиректами
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; LaravelPingBot/1.0; +https://yourdomain.com)',
        ]);

        curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error  = curl_error($ch);

        curl_close($ch);

        $status = $status ?: null;
        $ok = $status >= 200 && $status < 400;
        $error = $error ?: null;

        return [
            'message' => 'CURL status ' . $status,
            'status'  => $ok,
            'statusHttp' => $status ?: null,
            'ok'     => $ok,
            'error'  => $error ?: null,
        ];
    }


    public static function checkUrlStatus(string $url)  //TODO refactor
    {
        try {
            $response = Http::timeout(15)
                ->withHeaders(self::CHECK_HEADERS)
                ->get($url);

            if ($response->successful()) {
                return "HTTP status " . $response->status();
            } else {
                return "URL come back status " . $response->status();
            }
        } catch (\Exception $e) {
            return "Error URL: " . $e->getMessage();
        }
    }
}