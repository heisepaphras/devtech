<?php

namespace App\Http\Controllers;

use App\Models\PlayerValue;
use Illuminate\View\View;

class PlayerValueController extends Controller
{
    public function index(): View
    {
        $featuredValues = PlayerValue::query()
            ->with('playerProfile')
            ->published()
            ->where('is_featured', true)
            ->orderByDesc('assessed_at')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        $playerValues = PlayerValue::query()
            ->with('playerProfile')
            ->published()
            ->orderByDesc('assessed_at')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->paginate(12);

        return view('pages.values.index', [
            'pageTitle' => 'Players Value',
            'featuredValues' => $featuredValues,
            'playerValues' => $playerValues,
        ]);
    }

    public function show(string $slug): View
    {
        $playerValue = PlayerValue::query()
            ->with('playerProfile')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedValues = PlayerValue::query()
            ->with('playerProfile')
            ->published()
            ->where('id', '!=', $playerValue->id)
            ->where(function ($query) use ($playerValue) {
                $query->where('value_change', $playerValue->value_change)
                    ->orWhere('player_profile_id', $playerValue->player_profile_id);
            })
            ->orderByDesc('assessed_at')
            ->limit(3)
            ->get();

        return view('pages.values.show', [
            'pageTitle' => $playerValue->player_name_snapshot . ' Value',
            'playerValue' => $playerValue,
            'relatedValues' => $relatedValues,
        ]);
    }
}
