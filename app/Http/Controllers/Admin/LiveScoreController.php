<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveScore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\CloudinaryUploader;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LiveScoreController extends Controller
{
    /**
     * @var array<int, string>
     */
    private const MATCH_STATUSES = ['upcoming', 'live', 'completed', 'postponed', 'cancelled'];

    public function index(): View
    {
        $liveScores = LiveScore::query()
            ->orderByRaw("CASE match_status WHEN 'live' THEN 0 WHEN 'upcoming' THEN 1 WHEN 'completed' THEN 2 ELSE 3 END")
            ->orderByDesc('kickoff_at')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.scores.index', [
            'pageTitle' => 'Manage Live Scores',
            'liveScores' => $liveScores,
        ]);
    }

    public function create(): View
    {
        return view('admin.scores.create', [
            'pageTitle' => 'Create Match Entry',
            'liveScore' => new LiveScore([
                'is_published' => true,
                'match_status' => 'upcoming',
                'kickoff_at' => now()->addDay(),
            ]),
            'matchStatuses' => self::MATCH_STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, null);

        $liveScore = new LiveScore();
        $this->saveLiveScore($liveScore, $validated, $request);

        return redirect()
            ->route('admin.live-scores.index')
            ->with('status', 'Match entry created successfully.');
    }

    public function edit(LiveScore $liveScore): View
    {
        return view('admin.scores.edit', [
            'pageTitle' => 'Edit Match Entry',
            'liveScore' => $liveScore,
            'matchStatuses' => self::MATCH_STATUSES,
        ]);
    }

    public function update(Request $request, LiveScore $liveScore): RedirectResponse
    {
        $validated = $this->validatePayload($request, $liveScore->id);

        $this->saveLiveScore($liveScore, $validated, $request);

        return redirect()
            ->route('admin.live-scores.index')
            ->with('status', 'Match entry updated successfully.');
    }

    public function destroy(LiveScore $liveScore): RedirectResponse
    {
        if ($liveScore->home_logo) {
            CloudinaryUploader::deleteImage($liveScore->home_logo);
        }

        if ($liveScore->away_logo) {
            CloudinaryUploader::deleteImage($liveScore->away_logo);
        }

        $liveScore->delete();

        return redirect()
            ->route('admin.live-scores.index')
            ->with('status', 'Match entry deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePayload(Request $request, ?int $scoreId): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => [
                'nullable',
                'string',
                'max:200',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('live_scores', 'slug')->ignore($scoreId),
            ],
            'competition' => ['nullable', 'string', 'max:120'],
            'home_team' => ['required', 'string', 'max:120'],
            'home_logo' => ['nullable', 'image', 'max:4096'],
            'away_team' => ['required', 'string', 'max:120'],
            'away_logo' => ['nullable', 'image', 'max:4096'],
            'venue' => ['nullable', 'string', 'max:180'],
            'kickoff_at' => ['required', 'date'],
            'home_score' => ['nullable', 'integer', 'between:0,30'],
            'away_score' => ['nullable', 'integer', 'between:0,30'],
            'match_status' => ['required', Rule::in(self::MATCH_STATUSES)],
            'live_minute' => ['nullable', 'integer', 'between:1,130'],
            'match_report' => ['nullable', 'string', 'max:3000'],
            'sort_order' => ['nullable', 'integer', 'between:0,9999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * @param array<string, mixed> $validated
     */
    private function saveLiveScore(LiveScore $liveScore, array $validated, Request $request): void
    {
        $liveScore->title = $validated['title'];
        $liveScore->slug = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title'],
            $liveScore->id
        );
        $liveScore->competition = $validated['competition'] ?? null;
        $liveScore->home_team = $validated['home_team'];
        if ($request->hasFile('home_logo')) {
            if ($liveScore->home_logo) {
                CloudinaryUploader::deleteImage($liveScore->home_logo);
            }

            $liveScore->home_logo = CloudinaryUploader::uploadImage($request->file('home_logo'), 'live-scores');
        }
        $liveScore->away_team = $validated['away_team'];
        if ($request->hasFile('away_logo')) {
            if ($liveScore->away_logo) {
                CloudinaryUploader::deleteImage($liveScore->away_logo);
            }

            $liveScore->away_logo = CloudinaryUploader::uploadImage($request->file('away_logo'), 'live-scores');
        }
        $liveScore->venue = $validated['venue'] ?? null;
        $liveScore->kickoff_at = $validated['kickoff_at'];
        $liveScore->home_score = $validated['home_score'] ?? null;
        $liveScore->away_score = $validated['away_score'] ?? null;
        $liveScore->match_status = $validated['match_status'];
        $liveScore->live_minute = $validated['live_minute'] ?? null;
        $liveScore->match_report = $validated['match_report'] ?? null;
        $liveScore->sort_order = $validated['sort_order'] ?? 0;
        $liveScore->is_featured = $request->boolean('is_featured');
        $liveScore->is_published = $request->boolean('is_published');
        $liveScore->save();
    }

    private function generateUniqueSlug(?string $manualSlug, string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($manualSlug ?: $title);
        $baseSlug = $baseSlug ?: 'live-score';
        $slug = $baseSlug;
        $counter = 1;

        while (
            LiveScore::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
