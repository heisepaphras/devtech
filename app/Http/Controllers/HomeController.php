<?php

namespace App\Http\Controllers;

use App\Models\EventItem;
use App\Models\GalleryItem;
use App\Models\LiveScore;
use App\Models\News;
use App\Models\VideoClip;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $newsItems = $this->queryIfTableExists('news', function () {
            return News::query()
                ->published()
                ->orderByDesc('published_at')
                ->limit(3)
                ->get();
        });

        $galleryItems = $this->queryIfTableExists('gallery_items', function () {
            return GalleryItem::query()
                ->published()
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->orderByDesc('captured_at')
                ->orderByDesc('created_at')
                ->limit(6)
                ->get();
        });

        $videoItems = $this->queryIfTableExists('video_clips', function () {
            return VideoClip::query()
                ->published()
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->orderByDesc('recorded_at')
                ->orderByDesc('created_at')
                ->limit(3)
                ->get();
        });

        $liveScores = $this->queryIfTableExists('live_scores', function () {
            return LiveScore::query()
                ->published()
                ->whereIn('match_status', ['live', 'upcoming'])
                ->orderByRaw("CASE match_status WHEN 'live' THEN 0 ELSE 1 END")
                ->orderBy('kickoff_at')
                ->limit(4)
                ->get();
        });

        $eventItems = $this->queryIfTableExists('event_items', function () {
            return EventItem::query()
                ->published()
                ->where('starts_at', '>=', now()->subDay())
                ->orderBy('starts_at')
                ->limit(3)
                ->get();
        });

        return view('pages.home', [
            'pageTitle' => 'Home',
            'newsItems' => $newsItems,
            'galleryItems' => $galleryItems,
            'videoItems' => $videoItems,
            'liveScores' => $liveScores,
            'eventItems' => $eventItems,
        ]);
    }

    /**
     * @param  callable(): Collection<int, mixed>  $callback
     */
    private function queryIfTableExists(string $tableName, callable $callback): Collection
    {
        if (! Schema::hasTable($tableName)) {
            return collect();
        }

        return $callback();
    }
}
