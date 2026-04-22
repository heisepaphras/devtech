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
        <label class="form-label fw-semibold">Full Name *</label>
        <input type="text" name="full_name" value="{{ old('full_name', $managementMember->full_name) }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Role Title *</label>
        <input type="text" name="role_title" value="{{ old('role_title', $managementMember->role_title) }}" class="form-control" placeholder="Head Coach" required>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $managementMember->slug) }}" class="form-control" placeholder="auto-generated-from-name">
        <div class="form-text">Lowercase letters, numbers, and hyphens only.</div>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Department</label>
        <input type="text" name="department" value="{{ old('department', $managementMember->department) }}" class="form-control" placeholder="Technical, Management...">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email" value="{{ old('email', $managementMember->email) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $managementMember->phone) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Experience (years)</label>
        <input type="number" min="0" max="60" name="experience_years" value="{{ old('experience_years', $managementMember->experience_years) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Profile Image</label>
        <input type="file" name="image" accept="image/*" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Sort Order</label>
        <input type="number" min="0" max="9999" name="sort_order" value="{{ old('sort_order', $managementMember->sort_order ?? 0) }}" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Bio</label>
        <textarea name="bio" rows="6" maxlength="3000" class="form-control">{{ old('bio', $managementMember->bio) }}</textarea>
    </div>

    @if ($managementMember->image_path)
        <div class="col-12">
            <span class="fw-semibold d-block mb-2">Current image:</span>
            <img src="{{ $managementMember->image_path }}" alt="Current management image" class="img-thumbnail image-preview">
        </div>
    @endif

    <div class="col-md-3">
        <label class="form-label fw-semibold">Featured</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured" {{ old('is_featured', $managementMember->is_featured) ? 'checked' : '' }}>
            <label class="form-check-label" for="isFeatured">Yes</label>
        </div>
    </div>

    <div class="col-md-9">
        <label class="form-label fw-semibold">Publication</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_published" value="1" class="form-check-input" id="isPublished" {{ old('is_published', $managementMember->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="isPublished">Mark as published</label>
        </div>
    </div>

    <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-brand" type="submit">{{ $submitLabel }}</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.management.index') }}">Cancel</a>
    </div>
</form>
