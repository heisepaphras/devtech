<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoClip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class VideoClipController extends Controller
{
    public function index(): View
    {
        $videoClips = VideoClip::query()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('recorded_at')
            ->paginate(20);

        return view('admin.videos.index', [
            'pageTitle' => 'Manage Video Clips',
            'videoClips' => $videoClips,
        ]);
    }

    public function create(): View
    {
        return view('admin.videos.create', [
            'pageTitle' => 'Create Video Clip',
            'videoClip' => new VideoClip([
                'is_published' => true,
                'recorded_at' => now()->toDateString(),
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, null);

        $videoClip = new VideoClip();
        $this->saveVideoClip($videoClip, $validated, $request);

        return redirect()
            ->route('admin.videos.index')
            ->with('status', 'Video clip created successfully.');
    }

    public function edit(VideoClip $videoClip): View
    {
        return view('admin.videos.edit', [
            'pageTitle' => 'Edit Video Clip',
            'videoClip' => $videoClip,
        ]);
    }

    public function update(Request $request, VideoClip $videoClip): RedirectResponse
    {
        $validated = $this->validatePayload($request, $videoClip->id);

        $this->saveVideoClip($videoClip, $validated, $request);

        return redirect()
            ->route('admin.videos.index')
            ->with('status', 'Video clip updated successfully.');
    }

    public function destroy(VideoClip $videoClip): RedirectResponse
    {
        $videoClip->delete();

        return redirect()
            ->route('admin.videos.index')
            ->with('status', 'Video clip deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePayload(Request $request, ?int $videoId): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => [
                'nullable',
                'string',
                'max:200',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('video_clips', 'slug')->ignore($videoId),
            ],
            'category' => ['nullable', 'string', 'max:80'],
            'source_url' => ['required', 'url', 'max:255'],
            'thumbnail_url' => ['nullable', 'url', 'max:255'],
            'duration_seconds' => ['nullable', 'integer', 'between:1,5400'],
            'recorded_at' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:3000'],
            'sort_order' => ['nullable', 'integer', 'between:0,9999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * @param array<string, mixed> $validated
     */
    private function saveVideoClip(VideoClip $videoClip, array $validated, Request $request): void
    {
        $videoClip->title = $validated['title'];
        $videoClip->slug = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title'],
            $videoClip->id
        );
        $videoClip->category = $validated['category'] ?? null;
        $videoClip->source_url = $validated['source_url'];
        $videoClip->thumbnail_url = $validated['thumbnail_url'] ?? null;
        $videoClip->duration_seconds = $validated['duration_seconds'] ?? null;
        $videoClip->recorded_at = $validated['recorded_at'] ?? null;
        $videoClip->description = $validated['description'] ?? null;
        $videoClip->sort_order = $validated['sort_order'] ?? 0;
        $videoClip->is_featured = $request->boolean('is_featured');
        $videoClip->is_published = $request->boolean('is_published');
        $videoClip->save();
    }

    private function generateUniqueSlug(?string $manualSlug, string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($manualSlug ?: $title);
        $baseSlug = $baseSlug ?: 'video-clip';
        $slug = $baseSlug;
        $counter = 1;

        while (
            VideoClip::query()
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
