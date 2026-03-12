<?php

namespace App\Http\Controllers;

use App\Models\PlayerProfile;
use Illuminate\View\View;

class PlayerProfileController extends Controller
{
    public function index(): View
    {
        $featuredPlayers = PlayerProfile::query()
            ->published()
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->orderBy('full_name')
            ->limit(4)
            ->get();

        $playerProfiles = PlayerProfile::query()
            ->published()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('full_name')
            ->paginate(12);

        return view('pages.players.index', [
            'pageTitle' => 'CV Players Profile',
            'featuredPlayers' => $featuredPlayers,
            'playerProfiles' => $playerProfiles,
        ]);
    }

    public function show(string $slug): View
    {
        $playerProfile = PlayerProfile::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPlayers = PlayerProfile::query()
            ->published()
            ->where('id', '!=', $playerProfile->id)
            ->where(function ($query) use ($playerProfile) {
                $query->where('primary_position', $playerProfile->primary_position)
                    ->orWhere('secondary_position', $playerProfile->secondary_position);
            })
            ->orderByDesc('is_featured')
            ->orderBy('full_name')
            ->limit(3)
            ->get();

        return view('pages.players.show', [
            'pageTitle' => $playerProfile->full_name,
            'playerProfile' => $playerProfile,
            'relatedPlayers' => $relatedPlayers,
        ]);
    }
}
