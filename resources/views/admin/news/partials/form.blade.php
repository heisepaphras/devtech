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

    <div class="col-12">
        <label class="form-label fw-semibold">Title *</label>
        <input type="text" name="title" value="{{ old('title', $news->title) }}" class="form-control" required>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $news->slug) }}" placeholder="auto-generated-from-title" class="form-control">
        <div class="form-text">Lowercase letters, numbers, and hyphens only.</div>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Excerpt (optional)</label>
        <textarea name="excerpt" rows="3" maxlength="320" class="form-control">{{ old('excerpt', $news->excerpt) }}</textarea>
        <div class="form-text">If left empty, excerpt is auto-generated from content.</div>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Content *</label>
        <textarea name="content" rows="12" class="form-control" required>{{ old('content', $news->content) }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Cover Image</label>
        <input type="file" name="cover_image" accept="image/*" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Published At</label>
        <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($news->published_at)->format('Y-m-d\TH:i')) }}" class="form-control">
    </div>

    @if ($news->cover_image)
        <div class="col-12">
            <div class="d-flex flex-column gap-2">
                <span class="fw-semibold">Current image:</span>
                <img src="{{ asset('storage/' . $news->cover_image) }}" alt="Current cover image" class="img-thumbnail image-preview">
            </div>
        </div>
    @endif

    <div class="col-12">
        <div class="form-check">
            <input type="checkbox" name="is_published" value="1" class="form-check-input" id="isPublished" {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="isPublished">Mark as published</label>
        </div>
    </div>

    <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-brand" type="submit">{{ $submitLabel }}</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.news.index') }}">Cancel</a>
    </div>
</form>
