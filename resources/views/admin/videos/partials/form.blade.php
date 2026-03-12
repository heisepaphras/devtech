<form action="{{ $action }}" method="POST" class="row g-3">
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
        <input type="text" name="title" value="{{ old('title', $videoClip->title) }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Category</label>
        <input type="text" name="category" value="{{ old('category', $videoClip->category) }}" class="form-control" placeholder="Training, Matchday...">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $videoClip->slug) }}" class="form-control" placeholder="auto-generated-from-title">
        <div class="form-text">Lowercase letters, numbers, and hyphens only.</div>
    </div>

    <div class="col-md-8">
        <label class="form-label fw-semibold">Video URL *</label>
        <input type="url" name="source_url" value="{{ old('source_url', $videoClip->source_url) }}" class="form-control" placeholder="https://..." required>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Thumbnail URL</label>
        <input type="url" name="thumbnail_url" value="{{ old('thumbnail_url', $videoClip->thumbnail_url) }}" class="form-control" placeholder="https://...">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Duration (seconds)</label>
        <input type="number" min="1" max="5400" name="duration_seconds" value="{{ old('duration_seconds', $videoClip->duration_seconds) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Recorded At</label>
        <input type="date" name="recorded_at" value="{{ old('recorded_at', optional($videoClip->recorded_at)->format('Y-m-d')) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Sort Order</label>
        <input type="number" min="0" max="9999" name="sort_order" value="{{ old('sort_order', $videoClip->sort_order ?? 0) }}" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Description</label>
        <textarea name="description" rows="6" maxlength="3000" class="form-control">{{ old('description', $videoClip->description) }}</textarea>
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Featured</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured" {{ old('is_featured', $videoClip->is_featured) ? 'checked' : '' }}>
            <label class="form-check-label" for="isFeatured">Yes</label>
        </div>
    </div>

    <div class="col-md-9">
        <label class="form-label fw-semibold">Publication</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_published" value="1" class="form-check-input" id="isPublished" {{ old('is_published', $videoClip->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="isPublished">Mark as published</label>
        </div>
    </div>

    <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-brand" type="submit">{{ $submitLabel }}</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.videos.index') }}">Cancel</a>
    </div>
</form>
