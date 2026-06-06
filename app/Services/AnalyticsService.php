<?php

namespace App\Services;

use App\Models\VisitorLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Get aggregate statistics for a given date range.
     */
    public function getOverviewStats(Carbon $startDate, Carbon $endDate): array
    {
        $baseQuery = VisitorLog::query()
            ->whereBetween('created_at', [$startDate, $endDate]);

        $totalViews = $baseQuery->count();
        $uniqueVisitors = $baseQuery->distinct('session_id')->count('session_id');

        // Calculate bounce rate (sessions with only 1 page view / total sessions)
        $sessionHits = VisitorLog::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('session_id', DB::raw('count(*) as hits'))
            ->groupBy('session_id')
            ->get();

        $totalSessions = $sessionHits->count();
        $bounces = $sessionHits->where('hits', 1)->count();

        $bounceRate = $totalSessions > 0 ? round(($bounces / $totalSessions) * 100, 1) : 0;
        $avgViewsPerSession = $uniqueVisitors > 0 ? round($totalViews / $uniqueVisitors, 1) : 0;

        return [
            'total_views'           => $totalViews,
            'unique_visitors'       => $uniqueVisitors,
            'avg_views_per_session' => $avgViewsPerSession,
            'bounce_rate'           => $bounceRate,
        ];
    }

    /**
     * Get page popularity metrics.
     */
    public function getTopPages(Carbon $startDate, Carbon $endDate, int $limit = 10): array
    {
        return VisitorLog::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('url', DB::raw('count(*) as views'), DB::raw('count(distinct session_id) as visitors'))
            ->groupBy('url')
            ->orderByDesc('views')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get country distribution.
     */
    public function getTopCountries(Carbon $startDate, Carbon $endDate, int $limit = 10): array
    {
        return VisitorLog::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('country', DB::raw('count(*) as views'), DB::raw('count(distinct session_id) as visitors'))
            ->groupBy('country')
            ->orderByDesc('visitors')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get referrer distribution.
     */
    public function getTopReferrers(Carbon $startDate, Carbon $endDate, int $limit = 10): array
    {
        return VisitorLog::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('COALESCE(referrer, "Direct / None") as referrer_domain'), DB::raw('count(*) as count'))
            ->groupBy('referrer_domain')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get device distribution breakdown.
     */
    public function getDeviceBreakdown(Carbon $startDate, Carbon $endDate): array
    {
        return VisitorLog::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('device_type', DB::raw('count(*) as count'))
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'device_type')
            ->toArray();
    }

    /**
     * Get browser distribution breakdown.
     */
    public function getBrowserBreakdown(Carbon $startDate, Carbon $endDate): array
    {
        return VisitorLog::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('browser', DB::raw('count(*) as count'))
            ->groupBy('browser')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'browser')
            ->toArray();
    }

    /**
     * Get visitor trend grouped daily for charting.
     */
    public function getDailyTrend(Carbon $startDate, Carbon $endDate): array
    {
        // Query daily views and unique visitors
        $results = VisitorLog::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as views'),
                DB::raw('count(distinct session_id) as visitors')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        // Populate days that might have 0 hits to ensure smooth chart rendering
        $trend = [];
        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            $dateString = $current->toDateString();
            $trend[] = [
                'date'      => $current->format('M d'),
                'views'     => $results[$dateString]['views'] ?? 0,
                'visitors'  => $results[$dateString]['visitors'] ?? 0,
            ];
            $current->addDay();
        }

        return $trend;
    }
}
