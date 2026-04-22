<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\CloudinaryUploader;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $newsItems = News::query()
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.news.index', [
            'pageTitle' => 'Manage News',
            'newsItems' => $newsItems,
        ]);
    }

    public function create(): View
    {
        return view('admin.news.create', [
            'pageTitle' => 'Create News',
            'news' => new News(['is_published' => true]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request);

        $news = new News();
        $this->saveNews($news, $validated, $request);

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'News article created successfully.');
    }

    public function edit(News $news): View
    {
        return view('admin.news.edit', [
            'pageTitle' => 'Edit News',
            'news' => $news,
        ]);
    }

    public function update(Request $request, News $news): RedirectResponse
    {
        $validated = $this->validatePayload($request, $news->id);

        $this->saveNews($news, $validated, $request);

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'News article updated successfully.');
    }

    public function destroy(News $news): RedirectResponse
    {
        if ($news->cover_image) {
            CloudinaryUploader::deleteImage($news->cover_image);
        }

        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'News article deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePayload(Request $request, ?int $newsId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => [
                'nullable',
                'string',
                'max:200',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('news', 'slug')->ignore($newsId),
            ],
            'excerpt' => ['nullable', 'string', 'max:320'],
            'content' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    /**
     * @param array<string, mixed> $validated
     */
    private function saveNews(News $news, array $validated, Request $request): void
    {
        $isPublished = $request->boolean('is_published');

        $news->title = $validated['title'];
        $news->slug = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title'],
            $news->id
        );
        $news->excerpt = $validated['excerpt'] ?: Str::limit(strip_tags($validated['content']), 220);
        $news->content = $validated['content'];
        $news->is_published = $isPublished;
        $news->published_at = $isPublished
            ? ($validated['published_at'] ?? $news->published_at ?? now())
            : null;

        if ($request->hasFile('cover_image')) {
            if ($news->cover_image) {
                CloudinaryUploader::deleteImage($news->cover_image);
            }

            $news->cover_image = CloudinaryUploader::uploadImage($request->file('cover_image'), 'news');
        }

        $news->save();
    }

    private function generateUniqueSlug(?string $manualSlug, string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($manualSlug ?: $title);
        $baseSlug = $baseSlug ?: 'news-item';
        $slug = $baseSlug;
        $counter = 1;

        while (
            News::query()
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
