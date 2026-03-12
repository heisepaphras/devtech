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
        <input type="text" name="title" value="{{ old('title', $liveScore->title) }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Competition</label>
        <input type="text" name="competition" value="{{ old('competition', $liveScore->competition) }}" class="form-control" placeholder="League or Tournament">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $liveScore->slug) }}" class="form-control" placeholder="auto-generated-from-title">
        <div class="form-text">Lowercase letters, numbers, and hyphens only.</div>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Home Team *</label>
        <input type="text" name="home_team" value="{{ old('home_team', $liveScore->home_team) }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Away Team *</label>
        <input type="text" name="away_team" value="{{ old('away_team', $liveScore->away_team) }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Home Club Logo</label>
        <input type="file" name="home_logo" accept="image/*" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Away Club Logo</label>
        <input type="file" name="away_logo" accept="image/*" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Kickoff At *</label>
        <input type="datetime-local" name="kickoff_at" value="{{ old('kickoff_at', optional($liveScore->kickoff_at)->format('Y-m-d\TH:i')) }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Venue</label>
        <input type="text" name="venue" value="{{ old('venue', $liveScore->venue) }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Home Score</label>
        <input type="number" min="0" max="30" name="home_score" value="{{ old('home_score', $liveScore->home_score) }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Away Score</label>
        <input type="number" min="0" max="30" name="away_score" value="{{ old('away_score', $liveScore->away_score) }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Status *</label>
        <select name="match_status" class="form-select" required>
            @foreach ($matchStatuses as $status)
                <option value="{{ $status }}" {{ old('match_status', $liveScore->match_status) === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Live Minute</label>
        <input type="number" min="1" max="130" name="live_minute" value="{{ old('live_minute', $liveScore->live_minute) }}" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Match Report</label>
        <textarea name="match_report" rows="6" maxlength="3000" class="form-control">{{ old('match_report', $liveScore->match_report) }}</textarea>
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Sort Order</label>
        <input type="number" min="0" max="9999" name="sort_order" value="{{ old('sort_order', $liveScore->sort_order ?? 0) }}" class="form-control">
    </div>

    @if ($liveScore->home_logo || $liveScore->away_logo)
        <div class="col-12">
            <div class="row g-3">
                @if ($liveScore->home_logo)
                    <div class="col-md-6">
                        <span class="fw-semibold d-block mb-2">Current home logo:</span>
                        <img src="{{ asset('storage/' . $liveScore->home_logo) }}" alt="Current home club logo" class="img-thumbnail image-preview">
                    </div>
                @endif
                @if ($liveScore->away_logo)
                    <div class="col-md-6">
                        <span class="fw-semibold d-block mb-2">Current away logo:</span>
                        <img src="{{ asset('storage/' . $liveScore->away_logo) }}" alt="Current away club logo" class="img-thumbnail image-preview">
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="col-md-3">
        <label class="form-label fw-semibold">Featured</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured" {{ old('is_featured', $liveScore->is_featured) ? 'checked' : '' }}>
            <label class="form-check-label" for="isFeatured">Yes</label>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Publication</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_published" value="1" class="form-check-input" id="isPublished" {{ old('is_published', $liveScore->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="isPublished">Mark as published</label>
        </div>
    </div>

    <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-brand" type="submit">{{ $submitLabel }}</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.live-scores.index') }}">Cancel</a>
    </div>
</form>
