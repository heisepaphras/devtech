<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="row g-3">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    @if ($errors->any())
        <div class="col-12">
            <div class="alert alert-danger mb-0">
                <strong>There are validation errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="col-md-8">
        <label class="form-label fw-semibold">Title *</label>
        <input type="text" name="title" value="{{ old('title', $eventItem->title) }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Event Type</label>
        <input type="text" name="event_type" value="{{ old('event_type', $eventItem->event_type) }}" class="form-control" placeholder="Trials, Match, Training...">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $eventItem->slug) }}" class="form-control" placeholder="auto-generated-from-title">
        <div class="form-text">Lowercase letters, numbers, and hyphens only.</div>
    </div>

    <div class="col-md-7">
        <label class="form-label fw-semibold">Venue</label>
        <input type="text" name="venue" value="{{ old('venue', $eventItem->venue) }}" class="form-control" placeholder="Stadium or location">
    </div>

    <div class="col-md-5">
        <label class="form-label fw-semibold">Registration Link</label>
        <input type="url" name="registration_link" value="{{ old('registration_link', $eventItem->registration_link) }}" class="form-control" placeholder="https://...">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Featured Image</label>
        <input type="file" name="featured_image" accept="image/*" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Starts At *</label>
        <input type="datetime-local" name="starts_at" value="{{ old('starts_at', optional($eventItem->starts_at)->format('Y-m-d\TH:i')) }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Ends At</label>
        <input type="datetime-local" name="ends_at" value="{{ old('ends_at', optional($eventItem->ends_at)->format('Y-m-d\TH:i')) }}" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Summary</label>
        <textarea name="summary" rows="2" maxlength="320" class="form-control">{{ old('summary', $eventItem->summary) }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Description</label>
        <textarea name="description" rows="7" maxlength="3000" class="form-control">{{ old('description', $eventItem->description) }}</textarea>
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Sort Order</label>
        <input type="number" min="0" max="9999" name="sort_order" value="{{ old('sort_order', $eventItem->sort_order ?? 0) }}" class="form-control">
    </div>

    @if ($eventItem->featured_image)
        <div class="col-12">
            <span class="fw-semibold d-block mb-2">Current image:</span>
            <img src="{{ asset('storage/' . $eventItem->featured_image) }}" alt="Current event image" class="img-thumbnail image-preview">
        </div>
    @endif

    <div class="col-md-3">
        <label class="form-label fw-semibold">Featured</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured" {{ old('is_featured', $eventItem->is_featured) ? 'checked' : '' }}>
            <label class="form-check-label" for="isFeatured">Yes</label>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Publication</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_published" value="1" class="form-check-input" id="isPublished" {{ old('is_published', $eventItem->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="isPublished">Mark as published</label>
        </div>
    </div>

    <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-brand" type="submit">{{ $submitLabel }}</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.events.index') }}">Cancel</a>
    </div>
</form>
