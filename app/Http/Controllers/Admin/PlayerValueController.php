<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlayerProfile;
use App\Models\PlayerValue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\CloudinaryUploader;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PlayerValueController extends Controller
{
    /**
     * @var array<int, string>
     */
    private const VALUE_CHANGES = ['increase', 'decrease', 'stable'];

    public function index(): View
    {
        $playerValues = PlayerValue::query()
            ->with('playerProfile')
            ->orderByDesc('assessed_at')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.values.index', [
            'pageTitle' => 'Manage Player Values',
            'playerValues' => $playerValues,
        ]);
    }

    public function create(): View
    {
        $playerProfiles = PlayerProfile::query()
            ->orderBy('full_name')
            ->get(['id', 'full_name']);

        return view('admin.values.create', [
            'pageTitle' => 'Create Player Value',
            'playerValue' => new PlayerValue([
                'is_published' => true,
                'assessed_at' => now()->toDateString(),
                'value_change' => 'stable',
            ]),
            'playerProfiles' => $playerProfiles,
            'valueChanges' => self::VALUE_CHANGES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, null);

        $playerValue = new PlayerValue();
        $this->savePlayerValue($playerValue, $validated, $request);

        return redirect()
            ->route('admin.player-values.index')
            ->with('status', 'Player value created successfully.');
    }

    public function edit(PlayerValue $playerValue): View
    {
        $playerProfiles = PlayerProfile::query()
            ->orderBy('full_name')
            ->get(['id', 'full_name']);

        return view('admin.values.edit', [
            'pageTitle' => 'Edit Player Value',
            'playerValue' => $playerValue,
            'playerProfiles' => $playerProfiles,
            'valueChanges' => self::VALUE_CHANGES,
        ]);
    }

    public function update(Request $request, PlayerValue $playerValue): RedirectResponse
    {
        $validated = $this->validatePayload($request, $playerValue->id);

        $this->savePlayerValue($playerValue, $validated, $request);

        return redirect()
            ->route('admin.player-values.index')
            ->with('status', 'Player value updated successfully.');
    }

    public function destroy(PlayerValue $playerValue): RedirectResponse
    {
        if ($playerValue->player_image) {
            Storage::disk('public')->delete($playerValue->player_image);
        }

        $playerValue->delete();

        return redirect()
            ->route('admin.player-values.index')
            ->with('status', 'Player value deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePayload(Request $request, ?int $valueId): array
    {
        return $request->validate([
            'player_profile_id' => ['nullable', 'integer', 'exists:player_profiles,id'],
            'player_name_snapshot' => ['required', 'string', 'max:140'],
            'player_image' => ['nullable', 'image', 'max:4096'],
            'slug' => [
                'nullable',
                'string',
                'max:180',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('player_values', 'slug')->ignore($valueId),
            ],
            'value_ngn' => ['required', 'integer', 'min:1', 'max:10000000000'],
            'previous_value_ngn' => ['nullable', 'integer', 'min:1', 'max:10000000000'],
            'value_change' => ['required', Rule::in(self::VALUE_CHANGES)],
            'assessment_note' => ['nullable', 'string', 'max:3000'],
            'assessed_at' => ['required', 'date'],
            'assessor_name' => ['nullable', 'string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'between:0,9999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * @param array<string, mixed> $validated
     */
    private function savePlayerValue(PlayerValue $playerValue, array $validated, Request $request): void
    {
        $playerProfileId = $validated['player_profile_id'] ?? null;

        if ($playerProfileId) {
            $profile = PlayerProfile::query()->find($playerProfileId);
            if ($profile && empty($validated['player_name_snapshot'])) {
                $validated['player_name_snapshot'] = $profile->full_name;
            }
        }

        $playerValue->player_profile_id = $playerProfileId;
        $playerValue->player_name_snapshot = $validated['player_name_snapshot'];
        if ($request->hasFile('player_image')) {
            if ($playerValue->player_image) {
                CloudinaryUploader::deleteImage($playerValue->player_image);
            }

            $playerValue->player_image = CloudinaryUploader::uploadImage($request->file('player_image'), 'player-values');
        }
        $playerValue->slug = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['player_name_snapshot'] . '-value',
            $playerValue->id
        );
        $playerValue->value_ngn = $validated['value_ngn'];
        $playerValue->previous_value_ngn = $validated['previous_value_ngn'] ?? null;
        $playerValue->value_change = $validated['value_change'];
        $playerValue->assessment_note = $validated['assessment_note'] ?? null;
        $playerValue->assessed_at = $validated['assessed_at'];
        $playerValue->assessor_name = $validated['assessor_name'] ?? null;
        $playerValue->sort_order = $validated['sort_order'] ?? 0;
        $playerValue->is_featured = $request->boolean('is_featured');
        $playerValue->is_published = $request->boolean('is_published');
        $playerValue->save();
    }

    private function generateUniqueSlug(?string $manualSlug, string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($manualSlug ?: $title);
        $baseSlug = $baseSlug ?: 'player-value';
        $slug = $baseSlug;
        $counter = 1;

        while (
            PlayerValue::query()
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
