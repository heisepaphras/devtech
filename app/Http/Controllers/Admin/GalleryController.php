<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\CloudinaryUploader;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleryItems = GalleryItem::query()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.gallery.index', [
            'pageTitle' => 'Manage Gallery',
            'galleryItems' => $galleryItems,
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.create', [
            'pageTitle' => 'Create Gallery Section',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSectionPayload($request);
        $sectionName = $validated['section_name'];
        $sectionSlug = Str::slug($validated['section_slug'] ?? $sectionName) ?: 'gallery-section';
        $capturedAt = $validated['captured_at'] ?? null;
        $description = $validated['description'] ?? null;
        $sortOrderBase = (int) ($validated['sort_order'] ?? 0);
        $isPublished = $request->boolean('is_published');

        /** @var array<int, \Illuminate\Http\UploadedFile> $images */
        $images = $request->file('images', []);
        $createdCount = 0;

        foreach ($images as $index => $image) {
            $galleryItem = new GalleryItem();
            $galleryItem->title = Str::limit($sectionName . ' Image ' . ($index + 1), 140, '');
            $galleryItem->slug = $this->generateUniqueSlug(
                null,
                $sectionSlug . '-' . ($index + 1)
            );
            $galleryItem->category = $sectionName;
            $galleryItem->description = $description;
            $galleryItem->captured_at = $capturedAt;
            $galleryItem->sort_order = $sortOrderBase + $index;
            $galleryItem->is_featured = $index === 0;
            $galleryItem->is_published = $isPublished;
            $galleryItem->image_path = CloudinaryUploader::uploadImage($image, 'gallery');
            $galleryItem->save();
            $createdCount++;
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('status', "Gallery section created with {$createdCount} images. The first image is marked as featured.");
    }

    public function edit(GalleryItem $galleryItem): View
    {
        return view('admin.gallery.edit', [
            'pageTitle' => 'Edit Gallery Item',
            'galleryItem' => $galleryItem,
        ]);
    }

    public function update(Request $request, GalleryItem $galleryItem): RedirectResponse
    {
        $validated = $this->validatePayload($request, $galleryItem->id, false);

        $this->saveGalleryItem($galleryItem, $validated, $request);

        return redirect()
            ->route('admin.gallery.index')
            ->with('status', 'Gallery item updated successfully.');
    }

    public function destroy(GalleryItem $galleryItem): RedirectResponse
    {
        if ($galleryItem->image_path) {
            CloudinaryUploader::deleteImage($galleryItem->image_path);
        }

        $galleryItem->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('status', 'Gallery item deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePayload(Request $request, ?int $itemId, bool $requireImage): array
    {
        $imageRules = ['nullable', 'image', 'max:4096'];

        if ($requireImage) {
            $imageRules = ['required', 'image', 'max:4096'];
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:140'],
            'slug' => [
                'nullable',
                'string',
                'max:160',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('gallery_items', 'slug')->ignore($itemId),
            ],
            'category' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:1800'],
            'captured_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'between:0,9999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
            'image' => $imageRules,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validateSectionPayload(Request $request): array
    {
        return $request->validate([
            'section_name' => ['required', 'string', 'max:80'],
            'section_slug' => [
                'nullable',
                'string',
                'max:120',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            ],
            'description' => ['nullable', 'string', 'max:1800'],
            'captured_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'between:0,9999'],
            'is_published' => ['nullable', 'boolean'],
            'images' => ['required', 'array', 'min:1', 'max:30'],
            'images.*' => ['required', 'image', 'max:4096'],
        ]);
    }

    /**
     * @param array<string, mixed> $validated
     */
    private function saveGalleryItem(GalleryItem $galleryItem, array $validated, Request $request): void
    {
        $galleryItem->title = $validated['title'];
        $galleryItem->slug = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title'],
            $galleryItem->id
        );
        $galleryItem->category = $validated['category'] ?? null;
        $galleryItem->description = $validated['description'] ?? null;
        $galleryItem->captured_at = $validated['captured_at'] ?? null;
        $galleryItem->sort_order = $validated['sort_order'] ?? 0;
        $galleryItem->is_featured = $request->boolean('is_featured');
        $galleryItem->is_published = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            if ($galleryItem->image_path) {
                CloudinaryUploader::deleteImage($galleryItem->image_path);
            }

            $galleryItem->image_path = CloudinaryUploader::uploadImage($request->file('image'), 'gallery');
        }

        $galleryItem->save();
    }

    private function generateUniqueSlug(?string $manualSlug, string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($manualSlug ?: $title);
        $baseSlug = $baseSlug ?: 'gallery-item';
        $slug = $baseSlug;
        $counter = 1;

        while (
            GalleryItem::query()
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
