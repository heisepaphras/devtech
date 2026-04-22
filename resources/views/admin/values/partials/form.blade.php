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

    <div class="col-md-6">
        <label class="form-label fw-semibold">Linked Player Profile</label>
        <select name="player_profile_id" class="form-select">
            <option value="">No linked profile</option>
            @foreach ($playerProfiles as $profile)
                <option value="{{ $profile->id }}" {{ (string) old('player_profile_id', $playerValue->player_profile_id) === (string) $profile->id ? 'selected' : '' }}>
                    {{ $profile->full_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Player Name Snapshot *</label>
        <input type="text" name="player_name_snapshot" value="{{ old('player_name_snapshot', $playerValue->player_name_snapshot) }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Player Image</label>
        <input type="file" name="player_image" accept="image/*" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $playerValue->slug) }}" class="form-control" placeholder="auto-generated-from-player-name">
        <div class="form-text">Lowercase letters, numbers, and hyphens only.</div>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Current Value (NGN) *</label>
        <input type="number" min="1" max="10000000000" name="value_ngn" value="{{ old('value_ngn', $playerValue->value_ngn) }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Previous Value (NGN)</label>
        <input type="number" min="1" max="10000000000" name="previous_value_ngn" value="{{ old('previous_value_ngn', $playerValue->previous_value_ngn) }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Change *</label>
        <select name="value_change" class="form-select" required>
            @foreach ($valueChanges as $change)
                <option value="{{ $change }}" {{ old('value_change', $playerValue->value_change) === $change ? 'selected' : '' }}>
                    {{ ucfirst($change) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Assessed At *</label>
        <input type="date" name="assessed_at" value="{{ old('assessed_at', optional($playerValue->assessed_at)->format('Y-m-d')) }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Assessor Name</label>
        <input type="text" name="assessor_name" value="{{ old('assessor_name', $playerValue->assessor_name) }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Sort Order</label>
        <input type="number" min="0" max="9999" name="sort_order" value="{{ old('sort_order', $playerValue->sort_order ?? 0) }}" class="form-control">
    </div>

    @if ($playerValue->player_image)
        <div class="col-12">
            <span class="fw-semibold d-block mb-2">Current image:</span>
            <img src="{{ $playerValue->player_image }}" alt="Current player value image" class="img-thumbnail image-preview">
        </div>
    @endif

    <div class="col-md-3">
        <label class="form-label fw-semibold">Featured</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured" {{ old('is_featured', $playerValue->is_featured) ? 'checked' : '' }}>
            <label class="form-check-label" for="isFeatured">Yes</label>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Publication</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_published" value="1" class="form-check-input" id="isPublished" {{ old('is_published', $playerValue->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="isPublished">Mark as published</label>
        </div>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Assessment Notes</label>
        <textarea name="assessment_note" rows="6" maxlength="3000" class="form-control">{{ old('assessment_note', $playerValue->assessment_note) }}</textarea>
    </div>

    <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-brand" type="submit">{{ $submitLabel }}</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.player-values.index') }}">Cancel</a>
    </div>
</form>
