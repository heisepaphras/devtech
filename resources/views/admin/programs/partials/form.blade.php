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
        <input type="text" name="title" value="{{ old('title', $program->title) }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Age Group</label>
        <input type="text" name="age_group" value="{{ old('age_group', $program->age_group) }}" class="form-control" placeholder="U8-U12, U13-U18...">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $program->slug) }}" class="form-control" placeholder="auto-generated-from-title">
        <div class="form-text">Lowercase letters, numbers, and hyphens only.</div>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Schedule</label>
        <input type="text" name="schedule" value="{{ old('schedule', $program->schedule) }}" class="form-control" placeholder="Mon/Wed/Fri - 4:00 PM">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Duration (weeks)</label>
        <input type="number" min="1" max="520" name="duration_weeks" value="{{ old('duration_weeks', $program->duration_weeks) }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Capacity</label>
        <input type="number" min="1" max="500" name="capacity" value="{{ old('capacity', $program->capacity) }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Fee</label>
        <input type="text" name="fee" value="{{ old('fee', $program->fee) }}" class="form-control" placeholder="Free or amount">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Registration Link</label>
        <input type="url" name="registration_link" value="{{ old('registration_link', $program->registration_link) }}" class="form-control" placeholder="https://...">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Featured Image</label>
        <input type="file" name="featured_image" accept="image/*" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Description</label>
        <textarea name="description" rows="5" maxlength="3000" class="form-control">{{ old('description', $program->description) }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Highlights</label>
        <textarea name="highlights" rows="4" maxlength="3000" class="form-control">{{ old('highlights', $program->highlights) }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Requirements</label>
        <textarea name="requirements" rows="4" maxlength="3000" class="form-control">{{ old('requirements', $program->requirements) }}</textarea>
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Sort Order</label>
        <input type="number" min="0" max="9999" name="sort_order" value="{{ old('sort_order', $program->sort_order ?? 0) }}" class="form-control">
    </div>

    @if ($program->featured_image)
        <div class="col-12">
            <span class="fw-semibold d-block mb-2">Current image:</span>
            <img src="{{ $program->featured_image }}" alt="Current program image" class="img-thumbnail image-preview">
        </div>
    @endif

    <div class="col-md-3">
        <label class="form-label fw-semibold">Featured</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured" {{ old('is_featured', $program->is_featured) ? 'checked' : '' }}>
            <label class="form-check-label" for="isFeatured">Yes</label>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Publication</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_published" value="1" class="form-check-input" id="isPublished" {{ old('is_published', $program->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="isPublished">Mark as published</label>
        </div>
    </div>

    <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-brand" type="submit">{{ $submitLabel }}</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.programs.index') }}">Cancel</a>
    </div>
</form>
