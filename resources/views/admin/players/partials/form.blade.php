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
        <input type="text" name="full_name" value="{{ old('full_name', $playerProfile->full_name) }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Jersey Number</label>
        <input type="number" min="1" max="99" name="jersey_number" value="{{ old('jersey_number', $playerProfile->jersey_number) }}" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $playerProfile->slug) }}" class="form-control" placeholder="auto-generated-from-name">
        <div class="form-text">Lowercase letters, numbers, and hyphens only.</div>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Primary Position</label>
        <input type="text" name="primary_position" value="{{ old('primary_position', $playerProfile->primary_position) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Secondary Position</label>
        <input type="text" name="secondary_position" value="{{ old('secondary_position', $playerProfile->secondary_position) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Preferred Foot</label>
        <select name="preferred_foot" class="form-select">
            @php
                $preferredFoot = old('preferred_foot', $playerProfile->preferred_foot);
            @endphp
            <option value="">Select foot</option>
            <option value="Right" {{ $preferredFoot === 'Right' ? 'selected' : '' }}>Right</option>
            <option value="Left" {{ $preferredFoot === 'Left' ? 'selected' : '' }}>Left</option>
            <option value="Both" {{ $preferredFoot === 'Both' ? 'selected' : '' }}>Both</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Date of Birth</label>
        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($playerProfile->date_of_birth)->format('Y-m-d')) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Nationality</label>
        <input type="text" name="nationality" value="{{ old('nationality', $playerProfile->nationality) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Current Team</label>
        <input type="text" name="current_team" value="{{ old('current_team', $playerProfile->current_team) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Height (cm)</label>
        <input type="number" min="100" max="250" name="height_cm" value="{{ old('height_cm', $playerProfile->height_cm) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Weight (kg)</label>
        <input type="number" min="30" max="150" name="weight_kg" value="{{ old('weight_kg', $playerProfile->weight_kg) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Video URL</label>
        <input type="url" name="video_url" value="{{ old('video_url', $playerProfile->video_url) }}" class="form-control" placeholder="https://...">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Summary</label>
        <textarea name="summary" rows="2" maxlength="320" class="form-control">{{ old('summary', $playerProfile->summary) }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Bio</label>
        <textarea name="bio" rows="5" maxlength="3000" class="form-control">{{ old('bio', $playerProfile->bio) }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Strengths</label>
        <textarea name="strengths" rows="4" maxlength="3000" class="form-control">{{ old('strengths', $playerProfile->strengths) }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Achievements</label>
        <textarea name="achievements" rows="4" maxlength="3000" class="form-control">{{ old('achievements', $playerProfile->achievements) }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Profile Image</label>
        <input type="file" name="profile_image" accept="image/*" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">CV Document (PDF)</label>
        <input type="file" name="cv_document" accept="application/pdf,.pdf" class="form-control">
    </div>

    @if ($playerProfile->profile_image)
        <div class="col-md-6">
            <span class="fw-semibold d-block mb-2">Current image:</span>
            <img src="{{ $playerProfile->profile_image }}" alt="Current player image" class="img-thumbnail image-preview">
        </div>
    @endif

    @if ($playerProfile->cv_document)
        <div class="col-md-6">
            <span class="fw-semibold d-block mb-2">Current CV:</span>
            <a href="{{ $playerProfile->cv_document }}" class="btn btn-outline-secondary btn-sm" target="_blank" rel="noopener">Open current CV</a>
        </div>
    @endif

    <div class="col-md-3">
        <label class="form-label fw-semibold">Sort Order</label>
        <input type="number" min="0" max="9999" name="sort_order" value="{{ old('sort_order', $playerProfile->sort_order ?? 0) }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Featured</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured" {{ old('is_featured', $playerProfile->is_featured) ? 'checked' : '' }}>
            <label class="form-check-label" for="isFeatured">Yes</label>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Publication</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_published" value="1" class="form-check-input" id="isPublished" {{ old('is_published', $playerProfile->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="isPublished">Mark as published</label>
        </div>
    </div>

    <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-brand" type="submit">{{ $submitLabel }}</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.player-profiles.index') }}">Cancel</a>
    </div>
</form>
