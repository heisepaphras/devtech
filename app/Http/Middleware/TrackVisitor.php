<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Log GET requests that are successful HTML page visits and not admin/API/ajax/prefetch calls.
        if ($request->isMethod('GET')
            && !$request->ajax()
            && !$request->prefetch()
            && !$request->is('admin*')
            && !$request->is('api*')
            && $response->getStatusCode() === 200) {

            try {
                $this->logRequest($request);
            } catch (\Throwable $e) {
                logger()->error('TrackVisitor Middleware Error: ' . $e->getMessage());
            }
        }

        return $response;
    }

    protected function logRequest(Request $request): void
    {
        $ip = $request->ip();
        $sessionId = session()->getId();
        $userAgent = $request->userAgent() ?? '';
        $deviceType = $this->parseDeviceType($userAgent);
        $browser = $this->parseBrowser($userAgent);
        $country = $this->resolveCountry($ip);

        // Normalize referrer host
        $referrer = $request->headers->get('referer');
        if ($referrer) {
            $referrerHost = parse_url($referrer, PHP_URL_HOST);
            $referrer = $referrerHost ? Str::lower($referrerHost) : null;
        }

        VisitorLog::create([
            'ip_address'   => $ip,
            'session_id'   => $sessionId,
            'url'          => $request->getPathInfo() ?: '/',
            'referrer'     => $referrer,
            'country'      => $country,
            'browser'      => $browser,
            'device_type'  => $deviceType,
            'user_agent'   => Str::limit($userAgent, 500),
        ]);
    }

    protected function resolveCountry(?string $ip): string
    {
        if (!$ip || $ip === '127.0.0.1' || $ip === '::1') {
            return 'Localhost';
        }

        // 1. Check Cloudflare country header
        if (isset($_SERVER['HTTP_CF_IPCOUNTRY'])) {
            return strtoupper($_SERVER['HTTP_CF_IPCOUNTRY']);
        }

        // 2. Fetch from IP geolocation API and cache the result
        return Cache::remember('geoip:' . $ip, now()->addDays(7), function () use ($ip) {
            try {
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}");
                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['status']) && $data['status'] === 'success' && !empty($data['country'])) {
                        return $data['country'];
                    }
                }
            } catch (\Throwable $e) {
                // Suppress exception and let it return Unknown
            }
            return 'Unknown';
        });
    }

    protected function parseDeviceType(string $userAgent): string
    {
        $userAgent = strtolower($userAgent);
        if (str_contains($userAgent, 'ipad') || str_contains($userAgent, 'tablet') || (str_contains($userAgent, 'android') && !str_contains($userAgent, 'mobile'))) {
            return 'Tablet';
        }
        if (str_contains($userAgent, 'mobile') || str_contains($userAgent, 'iphone') || str_contains($userAgent, 'ipod') || str_contains($userAgent, 'android') || str_contains($userAgent, 'opera mini')) {
            return 'Mobile';
        }
        return 'Desktop';
    }

    protected function parseBrowser(string $userAgent): string
    {
        $userAgent = strtolower($userAgent);
        if (str_contains($userAgent, 'chrome') && !str_contains($userAgent, 'chromium') && !str_contains($userAgent, 'edg') && !str_contains($userAgent, 'opr')) {
            return 'Chrome';
        }
        if (str_contains($userAgent, 'safari') && !str_contains($userAgent, 'chrome')) {
            return 'Safari';
        }
        if (str_contains($userAgent, 'firefox')) {
            return 'Firefox';
        }
        if (str_contains($userAgent, 'edg') || str_contains($userAgent, 'edge')) {
            return 'Edge';
        }
        if (str_contains($userAgent, 'opr') || str_contains($userAgent, 'opera')) {
            return 'Opera';
        }
        return 'Other';
    }
}
