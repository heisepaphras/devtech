<?php

namespace App\Http\Controllers;

use App\Models\LiveScore;
use Illuminate\View\View;

class LiveScoreController extends Controller
{
    public function index(): View
    {
        $liveMatches = LiveScore::query()
            ->published()
            ->where('match_status', 'live')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('kickoff_at')
            ->get();

        $upcomingMatches = LiveScore::query()
            ->published()
            ->where('match_status', 'upcoming')
            ->orderBy('kickoff_at')
            ->orderBy('sort_order')
            ->limit(12)
            ->get();

        $completedMatches = LiveScore::query()
            ->published()
            ->where('match_status', 'completed')
            ->orderByDesc('kickoff_at')
            ->orderBy('sort_order')
            ->paginate(12);

        return view('pages.scores.index', [
            'pageTitle' => 'Live Score',
            'liveMatches' => $liveMatches,
            'upcomingMatches' => $upcomingMatches,
            'completedMatches' => $completedMatches,
        ]);
    }

    public function show(string $slug): View
    {
        $liveScore = LiveScore::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedMatches = LiveScore::query()
            ->published()
            ->where('id', '!=', $liveScore->id)
            ->where('competition', $liveScore->competition)
            ->orderByDesc('kickoff_at')
            ->limit(3)
            ->get();

        return view('pages.scores.show', [
            'pageTitle' => $liveScore->title,
            'liveScore' => $liveScore,
            'relatedMatches' => $relatedMatches,
        ]);
    }
}
