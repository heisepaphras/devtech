<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlayerProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PlayerProfileController extends Controller
{
    public function index(): View
    {
        $playerProfiles = PlayerProfile::query()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('full_name')
            ->paginate(20);

        return view('admin.players.index', [
            'pageTitle' => 'Manage Player Profiles',
            'playerProfiles' => $playerProfiles,
        ]);
    }

    public function create(): View
    {
        return view('admin.players.create', [
            'pageTitle' => 'Create Player Profile',
            'playerProfile' => new PlayerProfile([
                'nationality' => 'Nigerian',
                'preferred_foot' => 'Right',
                'current_team' => 'Abuja Kings Football Academy',
                'is_published' => true,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, null);

        $playerProfile = new PlayerProfile();
        $this->savePlayerProfile($playerProfile, $validated, $request);

        return redirect()
            ->route('admin.player-profiles.index')
            ->with('status', 'Player profile created successfully.');
    }

    public function edit(PlayerProfile $playerProfile): View
    {
        return view('admin.players.edit', [
            'pageTitle' => 'Edit Player Profile',
            'playerProfile' => $playerProfile,
        ]);
    }

    public function update(Request $request, PlayerProfile $playerProfile): RedirectResponse
    {
        $validated = $this->validatePayload($request, $playerProfile->id);

        $this->savePlayerProfile($playerProfile, $validated, $request);

        return redirect()
            ->route('admin.player-profiles.index')
            ->with('status', 'Player profile updated successfully.');
    }

    public function destroy(PlayerProfile $playerProfile): RedirectResponse
    {
        if ($playerProfile->profile_image) {
            Storage::disk('public')->delete($playerProfile->profile_image);
        }

        if ($playerProfile->cv_document) {
            Storage::disk('public')->delete($playerProfile->cv_document);
        }

        $playerProfile->delete();

        return redirect()
            ->route('admin.player-profiles.index')
            ->with('status', 'Player profile deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePayload(Request $request, ?int $playerId): array
    {
        return $request->validate([
            'full_name' => ['required', 'string', 'max:140'],
            'slug' => [
                'nullable',
                'string',
                'max:180',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('player_profiles', 'slug')->ignore($playerId),
            ],
            'jersey_number' => ['nullable', 'integer', 'between:1,99'],
            'date_of_birth' => ['nullable', 'date', 'before_or_equal:today'],
            'nationality' => ['nullable', 'string', 'max:80'],
            'preferred_foot' => ['nullable', 'string', 'max:20'],
            'primary_position' => ['nullable', 'string', 'max:80'],
            'secondary_position' => ['nullable', 'string', 'max:80'],
            'height_cm' => ['nullable', 'integer', 'between:100,250'],
            'weight_kg' => ['nullable', 'integer', 'between:30,150'],
            'current_team' => ['nullable', 'string', 'max:160'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'summary' => ['nullable', 'string', 'max:320'],
            'bio' => ['nullable', 'string', 'max:3000'],
            'strengths' => ['nullable', 'string', 'max:3000'],
            'achievements' => ['nullable', 'string', 'max:3000'],
            'profile_image' => ['nullable', 'image', 'max:4096'],
            'cv_document' => ['nullable', 'mimetypes:application/pdf', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'between:0,9999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * @param array<string, mixed> $validated
     */
    private function savePlayerProfile(PlayerProfile $playerProfile, array $validated, Request $request): void
    {
        $playerProfile->full_name = $validated['full_name'];
        $playerProfile->slug = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['full_name'],
            $playerProfile->id
        );
        $playerProfile->jersey_number = $validated['jersey_number'] ?? null;
        $playerProfile->date_of_birth = $validated['date_of_birth'] ?? null;
        $playerProfile->nationality = $validated['nationality'] ?? null;
        $playerProfile->preferred_foot = $validated['preferred_foot'] ?? null;
        $playerProfile->primary_position = $validated['primary_position'] ?? null;
        $playerProfile->secondary_position = $validated['secondary_position'] ?? null;
        $playerProfile->height_cm = $validated['height_cm'] ?? null;
        $playerProfile->weight_kg = $validated['weight_kg'] ?? null;
        $playerProfile->current_team = $validated['current_team'] ?? null;
        $playerProfile->video_url = $validated['video_url'] ?? null;
        $playerProfile->summary = $validated['summary'] ?? null;
        $playerProfile->bio = $validated['bio'] ?? null;
        $playerProfile->strengths = $validated['strengths'] ?? null;
        $playerProfile->achievements = $validated['achievements'] ?? null;
        $playerProfile->sort_order = $validated['sort_order'] ?? 0;
        $playerProfile->is_featured = $request->boolean('is_featured');
        $playerProfile->is_published = $request->boolean('is_published');

        if ($request->hasFile('profile_image')) {
            if ($playerProfile->profile_image) {
                Storage::disk('public')->delete($playerProfile->profile_image);
            }

            $playerProfile->profile_image = $request->file('profile_image')->store('players', 'public');
        }

        if ($request->hasFile('cv_document')) {
            if ($playerProfile->cv_document) {
                Storage::disk('public')->delete($playerProfile->cv_document);
            }

            $playerProfile->cv_document = $request->file('cv_document')->store('players/cv', 'public');
        }

        $playerProfile->save();
    }

    private function generateUniqueSlug(?string $manualSlug, string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($manualSlug ?: $title);
        $baseSlug = $baseSlug ?: 'player-profile';
        $slug = $baseSlug;
        $counter = 1;

        while (
            PlayerProfile::query()
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
