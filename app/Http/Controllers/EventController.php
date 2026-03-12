<?php

namespace App\Http\Controllers;

use App\Models\EventItem;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $upcomingEvents = EventItem::query()
            ->published()
            ->where('starts_at', '>=', now())
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('starts_at')
            ->get();

        $pastEvents = EventItem::query()
            ->published()
            ->where('starts_at', '<', now())
            ->orderByDesc('starts_at')
            ->limit(12)
            ->get();

        return view('pages.events.index', [
            'pageTitle' => 'Events',
            'upcomingEvents' => $upcomingEvents,
            'pastEvents' => $pastEvents,
        ]);
    }

    public function show(string $slug): View
    {
        $eventItem = EventItem::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedEvents = EventItem::query()
            ->published()
            ->where('id', '!=', $eventItem->id)
            ->where('starts_at', '>=', now()->subDays(30))
            ->orderBy('starts_at')
            ->limit(3)
            ->get();

        return view('pages.events.show', [
            'pageTitle' => $eventItem->title,
            'eventItem' => $eventItem,
            'relatedEvents' => $relatedEvents,
        ]);
    }
}
