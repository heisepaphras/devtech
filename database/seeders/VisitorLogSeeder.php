<?php

namespace Database\Seeders;

use App\Models\VisitorLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class VisitorLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate existing visitor logs to start fresh
        VisitorLog::truncate();

        $urls = [
            '/',
            '/about',
            '/news',
            '/news/open-trials-schedule-released-april-2026',
            '/news/u17-development-squad-wins-friendly-3-1',
            '/gallery',
            '/events',
            '/player-profiles',
            '/scouting-trials-programs',
            '/register',
            '/support',
        ];

        $countries = [
            'Nigeria', 'Nigeria', 'Nigeria', 'Nigeria', 'Nigeria', 'Nigeria',
            'United Kingdom', 'United Kingdom',
            'United States',
            'South Africa',
            'Ghana',
            'Kenya',
            'Germany',
        ];

        $referrers = [
            'google.com', 'google.com', 'google.com',
            'facebook.com', 'facebook.com',
            'instagram.com', 'instagram.com',
            'x.com',
            'whatsapp.com',
            null, // Direct
        ];

        $browsers = ['Chrome', 'Chrome', 'Chrome', 'Safari', 'Safari', 'Firefox', 'Edge', 'Opera'];
        $devices = ['Mobile', 'Mobile', 'Mobile', 'Desktop', 'Desktop', 'Tablet'];

        $startDate = now()->subDays(30);
        $endDate = now();

        $logs = [];

        // Generate logs for each of the last 30 days
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Determine daily volume with slight weekend drops and random variance
            $isWeekend = $date->isWeekend();
            $baseSessionsCount = $isWeekend ? rand(15, 35) : rand(40, 85);

            for ($s = 0; $s < $baseSessionsCount; $s++) {
                $sessionId = Str::random(40);
                $ip = rand(41, 197) . '.' . rand(2, 254) . '.' . rand(2, 254) . '.' . rand(2, 254);
                $country = $countries[array_rand($countries)];
                $referrer = $referrers[array_rand($referrers)];
                $browser = $browsers[array_rand($browsers)];
                $deviceType = $devices[array_rand($devices)];

                // Set user agent mock
                $userAgent = match ($browser) {
                    'Chrome' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Safari' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Mobile/15E148 Safari/604.1',
                    'Firefox' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/119.0',
                    'Edge' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 Edg/120.0.0.0',
                    'Opera' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 OPR/106.0.0.0',
                    default => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                };

                // Device / UA logic match
                if ($deviceType === 'Mobile' && $browser === 'Chrome') {
                    $userAgent = 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36';
                }

                // Simulate session path flow: visits 1 to 5 pages
                $pageHits = rand(1, 5);
                $sessionTime = $date->copy()->setTime(rand(0, 23), rand(0, 59), rand(0, 59));

                $visitedUrls = [];
                for ($p = 0; $s_hit = $p < $pageHits; $p++) {
                    // Pick URL. First page is usually home '/' or trials, next pages are deeper
                    if ($p === 0) {
                        $url = rand(0, 100) < 50 ? '/' : $urls[array_rand($urls)];
                    } else {
                        // Deeper URL, not repeating the exact last page
                        do {
                            $url = $urls[array_rand($urls)];
                        } while ($url === ($visitedUrls[$p - 1] ?? null));
                    }

                    $visitedUrls[] = $url;
                    $hitTime = $sessionTime->copy()->addMinutes($p * rand(1, 12));

                    $logs[] = [
                        'ip_address'   => $ip,
                        'session_id'   => $sessionId,
                        'url'          => $url,
                        'referrer'     => $p === 0 ? $referrer : 'kingsfootballacademyabuja.com', // Subsequent hits are internal
                        'country'      => $country,
                        'browser'      => $browser,
                        'device_type'  => $deviceType,
                        'user_agent'   => $userAgent,
                        'created_at'   => $hitTime,
                        'updated_at'   => $hitTime,
                    ];
                }
            }
        }

        // Chunk insert to be highly efficient
        $chunks = array_chunk($logs, 500);
        foreach ($chunks as $chunk) {
            VisitorLog::insert($chunk);
        }
    }
}
