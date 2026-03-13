<?php

namespace App\Http\Controllers;

use App\Models\EventItem;
use App\Models\GalleryItem;
use App\Models\LiveScore;
use App\Models\News;
use App\Models\PlayerProfile;
use App\Models\PlayerValue;
use App\Models\ScoutingProgram;
use App\Models\TransferItem;
use App\Models\VideoClip;
use Illuminate\Http\Response;
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

    public function sitemap(): Response
    {
        $staticUrls = collect([
            ['loc' => route('home'), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => route('about'), 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => route('privacy'), 'changefreq' => 'yearly', 'priority' => '0.3'],
            ['loc' => route('terms'), 'changefreq' => 'yearly', 'priority' => '0.3'],
            ['loc' => route('support'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => route('news'), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => route('gallery'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => route('events'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => route('transfer.market'), 'changefreq' => 'daily', 'priority' => '0.8'],
            ['loc' => route('player.profiles'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => route('players.management'), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => route('players.value'), 'changefreq' => 'daily', 'priority' => '0.8'],
            ['loc' => route('live.score'), 'changefreq' => 'hourly', 'priority' => '0.9'],
            ['loc' => route('videos'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => route('scouting.trials'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => route('register'), 'changefreq' => 'weekly', 'priority' => '0.9'],
        ]);

        $dynamicUrls = collect()
            ->merge($this->querySlugSitemapUrls('news', function () {
                return News::query()->published()->select(['slug', 'updated_at'])->get();
            }, 'news.show', 'daily', '0.8'))
            ->merge($this->querySlugSitemapUrls('event_items', function () {
                return EventItem::query()->published()->select(['slug', 'updated_at'])->get();
            }, 'events.show', 'weekly', '0.7'))
            ->merge($this->querySlugSitemapUrls('transfer_items', function () {
                return TransferItem::query()->published()->select(['slug', 'updated_at'])->get();
            }, 'transfer.market.show', 'daily', '0.7'))
            ->merge($this->querySlugSitemapUrls('player_profiles', function () {
                return PlayerProfile::query()->published()->select(['slug', 'updated_at'])->get();
            }, 'player.profiles.show', 'weekly', '0.7'))
            ->merge($this->querySlugSitemapUrls('player_values', function () {
                return PlayerValue::query()->published()->select(['slug', 'updated_at'])->get();
            }, 'players.value.show', 'daily', '0.7'))
            ->merge($this->querySlugSitemapUrls('live_scores', function () {
                return LiveScore::query()->published()->select(['slug', 'updated_at'])->get();
            }, 'live.score.show', 'hourly', '0.8'))
            ->merge($this->querySlugSitemapUrls('video_clips', function () {
                return VideoClip::query()->published()->select(['slug', 'updated_at'])->get();
            }, 'videos.show', 'weekly', '0.7'))
            ->merge($this->querySlugSitemapUrls('scouting_programs', function () {
                return ScoutingProgram::query()->published()->select(['slug', 'updated_at'])->get();
            }, 'scouting.trials.show', 'weekly', '0.7'));

        $urls = $staticUrls
            ->merge($dynamicUrls)
            ->unique('loc')
            ->values();

        $xml = view('sitemap.index', [
            'urls' => $urls,
        ])->render();

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
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

    /**
     * @param  callable(): Collection<int, mixed>  $callback
     */
    private function querySlugSitemapUrls(
        string $tableName,
        callable $callback,
        string $routeName,
        string $changefreq,
        string $priority,
    ): Collection {
        if (! Schema::hasTable($tableName)) {
            return collect();
        }

        return $callback()
            ->filter(fn ($item) => filled($item->slug))
            ->map(function ($item) use ($routeName, $changefreq, $priority) {
                return [
                    'loc' => route($routeName, ['slug' => $item->slug]),
                    'lastmod' => $item->updated_at?->toDateString(),
                    'changefreq' => $changefreq,
                    'priority' => $priority,
                ];
            });
    }
}
