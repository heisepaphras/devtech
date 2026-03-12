<?php

namespace App\Http\Controllers;

use App\Models\ManagementMember;
use App\Models\PlayerProfile;
use Illuminate\View\View;

class PlayersManagementController extends Controller
{
    public function index(): View
    {
        $featuredPlayers = PlayerProfile::query()
            ->published()
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->orderBy('full_name')
            ->limit(6)
            ->get();

        $managementMembers = ManagementMember::query()
            ->published()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('full_name')
            ->get();

        return view('pages.management.index', [
            'pageTitle' => 'Academy Players & Management',
            'featuredPlayers' => $featuredPlayers,
            'managementMembers' => $managementMembers,
        ]);
    }
}
