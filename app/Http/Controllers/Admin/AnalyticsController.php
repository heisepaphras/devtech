<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Show the analytics dashboard.
     */
    public function index(Request $request): View
    {
        $range = $request->query('range', '30days');

        // Determine start and end date based on filter range
        $endDate = Carbon::today()->endOfDay();
        $startDate = match ($range) {
            'today' => Carbon::today()->startOfDay(),
            '7days' => Carbon::today()->subDays(7)->startOfDay(),
            default => Carbon::today()->subDays(30)->startOfDay(), // 30days as default
        };

        $overview = $this->analyticsService->getOverviewStats($startDate, $endDate);
        $topPages = $this->analyticsService->getTopPages($startDate, $endDate);
        $topCountries = $this->analyticsService->getTopCountries($startDate, $endDate);
        $topReferrers = $this->analyticsService->getTopReferrers($startDate, $endDate);
        $deviceBreakdown = $this->analyticsService->getDeviceBreakdown($startDate, $endDate);
        $browserBreakdown = $this->analyticsService->getBrowserBreakdown($startDate, $endDate);
        $dailyTrend = $this->analyticsService->getDailyTrend($startDate, $endDate);

        return view('admin.analytics.index', [
            'pageTitle'        => 'Website Analytics',
            'currentRange'     => $range,
            'overview'         => $overview,
            'topPages'         => $topPages,
            'topCountries'     => $topCountries,
            'topReferrers'     => $topReferrers,
            'deviceBreakdown'  => $deviceBreakdown,
            'browserBreakdown' => $browserBreakdown,
            'dailyTrend'       => $dailyTrend,
        ]);
    }
}
