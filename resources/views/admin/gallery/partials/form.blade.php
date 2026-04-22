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
        <input type="text" name="title" value="{{ old('title', $galleryItem->title) }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Category</label>
        <input type="text" name="category" value="{{ old('category', $galleryItem->category) }}" class="form-control" placeholder="Matchday, Training...">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $galleryItem->slug) }}" class="form-control" placeholder="auto-generated-from-title">
        <div class="form-text">Lowercase letters, numbers, and hyphens only.</div>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Description</label>
        <textarea name="description" rows="5" class="form-control">{{ old('description', $galleryItem->description) }}</textarea>
    </div>

    <div class="col-md-5">
        <label class="form-label fw-semibold">Image {{ $method === 'POST' ? '*' : '' }}</label>
        <input type="file" name="image" accept="image/*" class="form-control" {{ $method === 'POST' ? 'required' : '' }}>
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Captured At</label>
        <input type="date" name="captured_at" value="{{ old('captured_at', optional($galleryItem->captured_at)->format('Y-m-d')) }}" class="form-control">
    </div>

    <div class="col-md-2">
        <label class="form-label fw-semibold">Sort Order</label>
        <input type="number" min="0" max="9999" name="sort_order" value="{{ old('sort_order', $galleryItem->sort_order ?? 0) }}" class="form-control">
    </div>

    <div class="col-md-2">
        <label class="form-label fw-semibold">Featured</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured" {{ old('is_featured', $galleryItem->is_featured) ? 'checked' : '' }}>
            <label class="form-check-label" for="isFeatured">Yes</label>
        </div>
    </div>

    <div class="col-12">
        <div class="form-check">
            <input type="checkbox" name="is_published" value="1" class="form-check-input" id="isPublished" {{ old('is_published', $galleryItem->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="isPublished">Mark as published</label>
        </div>
    </div>

    @if ($galleryItem->image_path)
        <div class="col-12">
            <span class="fw-semibold d-block mb-2">Current image:</span>
            <img src="{{ $galleryItem->image_path }}" alt="Current gallery image" class="img-thumbnail image-preview">
        </div>
    @endif

    <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-brand" type="submit">{{ $submitLabel }}</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.gallery.index') }}">Cancel</a>
    </div>
</form>
