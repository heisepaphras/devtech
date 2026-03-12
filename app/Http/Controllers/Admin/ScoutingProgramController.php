<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScoutingProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ScoutingProgramController extends Controller
{
    public function index(): View
    {
        $programs = ScoutingProgram::query()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(20);

        return view('admin.programs.index', [
            'pageTitle' => 'Manage Scouting Programs',
            'programs' => $programs,
        ]);
    }

    public function create(): View
    {
        return view('admin.programs.create', [
            'pageTitle' => 'Create Program',
            'program' => new ScoutingProgram(['is_published' => true]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, null);

        $program = new ScoutingProgram();
        $this->saveProgram($program, $validated, $request);

        return redirect()
            ->route('admin.programs.index')
            ->with('status', 'Program created successfully.');
    }

    public function edit(ScoutingProgram $scoutingProgram): View
    {
        return view('admin.programs.edit', [
            'pageTitle' => 'Edit Program',
            'program' => $scoutingProgram,
        ]);
    }

    public function update(Request $request, ScoutingProgram $scoutingProgram): RedirectResponse
    {
        $validated = $this->validatePayload($request, $scoutingProgram->id);

        $this->saveProgram($scoutingProgram, $validated, $request);

        return redirect()
            ->route('admin.programs.index')
            ->with('status', 'Program updated successfully.');
    }

    public function destroy(ScoutingProgram $scoutingProgram): RedirectResponse
    {
        if ($scoutingProgram->featured_image) {
            Storage::disk('public')->delete($scoutingProgram->featured_image);
        }

        $scoutingProgram->delete();

        return redirect()
            ->route('admin.programs.index')
            ->with('status', 'Program deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePayload(Request $request, ?int $programId): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => [
                'nullable',
                'string',
                'max:180',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('scouting_programs', 'slug')->ignore($programId),
            ],
            'age_group' => ['nullable', 'string', 'max:50'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'duration_weeks' => ['nullable', 'integer', 'between:1,520'],
            'capacity' => ['nullable', 'integer', 'between:1,500'],
            'registration_link' => ['nullable', 'url', 'max:255'],
            'featured_image' => ['nullable', 'image', 'max:4096'],
            'fee' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:3000'],
            'highlights' => ['nullable', 'string', 'max:3000'],
            'requirements' => ['nullable', 'string', 'max:3000'],
            'sort_order' => ['nullable', 'integer', 'between:0,9999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * @param array<string, mixed> $validated
     */
    private function saveProgram(ScoutingProgram $program, array $validated, Request $request): void
    {
        $program->title = $validated['title'];
        $program->slug = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title'],
            $program->id
        );
        $program->age_group = $validated['age_group'] ?? null;
        $program->schedule = $validated['schedule'] ?? null;
        $program->duration_weeks = $validated['duration_weeks'] ?? null;
        $program->capacity = $validated['capacity'] ?? null;
        $program->registration_link = $validated['registration_link'] ?? null;
        if ($request->hasFile('featured_image')) {
            if ($program->featured_image) {
                Storage::disk('public')->delete($program->featured_image);
            }

            $program->featured_image = $request->file('featured_image')->store('programs', 'public');
        }
        $program->fee = $validated['fee'] ?? null;
        $program->description = $validated['description'] ?? null;
        $program->highlights = $validated['highlights'] ?? null;
        $program->requirements = $validated['requirements'] ?? null;
        $program->sort_order = $validated['sort_order'] ?? 0;
        $program->is_featured = $request->boolean('is_featured');
        $program->is_published = $request->boolean('is_published');
        $program->save();
    }

    private function generateUniqueSlug(?string $manualSlug, string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($manualSlug ?: $title);
        $baseSlug = $baseSlug ?: 'program-item';
        $slug = $baseSlug;
        $counter = 1;

        while (
            ScoutingProgram::query()
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
