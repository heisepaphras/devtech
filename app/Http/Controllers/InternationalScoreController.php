<?php

namespace App\Http\Controllers;

use App\Services\ApiFootballService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternationalScoreController extends Controller
{
    protected $apiFootballService;

    public function __construct(ApiFootballService $apiFootballService)
    {
        $this->apiFootballService = $apiFootballService;
    }

    /**
     * Display live scores from international football leagues.
     */
    public function index(Request $request): View
    {
        $fixtures = $this->apiFootballService->getLiveScores();

        // Group live matches by league name
        $groupedMatches = collect($fixtures)->groupBy(function ($match) {
            return $match['league']['name'] ?? 'Other Competitions';
        });

        // Determine if we are running on mock data
        $isMock = empty(config('services.api_football.key'));

        return view('pages.international-score', [
            'pageTitle'      => 'International Live Scores',
            'groupedMatches' => $groupedMatches,
            'isMock'         => $isMock,
        ]);
    }
}
