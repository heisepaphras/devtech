<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\CloudinaryUploader;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $eventItems = EventItem::query()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('starts_at')
            ->paginate(20);

        return view('admin.events.index', [
            'pageTitle' => 'Manage Events',
            'eventItems' => $eventItems,
        ]);
    }

    public function create(): View
    {
        return view('admin.events.create', [
            'pageTitle' => 'Create Event',
            'eventItem' => new EventItem([
                'is_published' => true,
                'starts_at' => now()->addWeek(),
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request, null);

        $eventItem = new EventItem();
        $this->saveEventItem($eventItem, $validated, $request);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event created successfully.');
    }

    public function edit(EventItem $eventItem): View
    {
        return view('admin.events.edit', [
            'pageTitle' => 'Edit Event',
            'eventItem' => $eventItem,
        ]);
    }

    public function update(Request $request, EventItem $eventItem): RedirectResponse
    {
        $validated = $this->validatePayload($request, $eventItem->id);

        $this->saveEventItem($eventItem, $validated, $request);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event updated successfully.');
    }

    public function destroy(EventItem $eventItem): RedirectResponse
    {
        if ($eventItem->featured_image) {
            CloudinaryUploader::deleteImage($eventItem->featured_image);
        }

        $eventItem->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePayload(Request $request, ?int $eventId): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'slug' => [
                'nullable',
                'string',
                'max:180',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('event_items', 'slug')->ignore($eventId),
            ],
            'event_type' => ['nullable', 'string', 'max:80'],
            'venue' => ['nullable', 'string', 'max:180'],
            'summary' => ['nullable', 'string', 'max:320'],
            'description' => ['nullable', 'string', 'max:3000'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'registration_link' => ['nullable', 'url', 'max:255'],
            'featured_image' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'between:0,9999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * @param array<string, mixed> $validated
     */
    private function saveEventItem(EventItem $eventItem, array $validated, Request $request): void
    {
        $eventItem->title = $validated['title'];
        $eventItem->slug = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title'],
            $eventItem->id
        );
        $eventItem->event_type = $validated['event_type'] ?? null;
        $eventItem->venue = $validated['venue'] ?? null;
        $eventItem->summary = $validated['summary'] ?? null;
        $eventItem->description = $validated['description'] ?? null;
        $eventItem->starts_at = $validated['starts_at'];
        $eventItem->ends_at = $validated['ends_at'] ?? null;
        $eventItem->registration_link = $validated['registration_link'] ?? null;
        if ($request->hasFile('featured_image')) {
            if ($eventItem->featured_image) {
                CloudinaryUploader::deleteImage($eventItem->featured_image);
            }

            $eventItem->featured_image = CloudinaryUploader::uploadImage($request->file('featured_image'), 'events');
        }
        $eventItem->sort_order = $validated['sort_order'] ?? 0;
        $eventItem->is_featured = $request->boolean('is_featured');
        $eventItem->is_published = $request->boolean('is_published');
        $eventItem->save();
    }

    private function generateUniqueSlug(?string $manualSlug, string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($manualSlug ?: $title);
        $baseSlug = $baseSlug ?: 'event-item';
        $slug = $baseSlug;
        $counter = 1;

        while (
            EventItem::query()
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
