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
        <input type="text" name="title" value="{{ old('title', $transferItem->title) }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Transfer Type *</label>
        <select name="transfer_type" class="form-select" required>
            @foreach ($transferTypes as $type)
                <option value="{{ $type }}" {{ old('transfer_type', $transferItem->transfer_type) === $type ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('-', ' ', $type)) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $transferItem->slug) }}" class="form-control" placeholder="auto-generated-from-title">
        <div class="form-text">Lowercase letters, numbers, and hyphens only.</div>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Player Name *</label>
        <input type="text" name="player_name" value="{{ old('player_name', $transferItem->player_name) }}" class="form-control" required>
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Position</label>
        <input type="text" name="position" value="{{ old('position', $transferItem->position) }}" class="form-control" placeholder="Midfielder">
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Transfer Fee</label>
        <input type="text" name="transfer_fee" value="{{ old('transfer_fee', $transferItem->transfer_fee) }}" class="form-control" placeholder="Undisclosed">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Player Image</label>
        <input type="file" name="player_image" accept="image/*" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">From Club</label>
        <input type="text" name="from_club" value="{{ old('from_club', $transferItem->from_club) }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">To Club</label>
        <input type="text" name="to_club" value="{{ old('to_club', $transferItem->to_club) }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Announced At *</label>
        <input type="datetime-local" name="announced_at" value="{{ old('announced_at', optional($transferItem->announced_at)->format('Y-m-d\TH:i')) }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Contract Until</label>
        <input type="date" name="contract_until" value="{{ old('contract_until', optional($transferItem->contract_until)->format('Y-m-d')) }}" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Summary</label>
        <textarea name="summary" rows="2" maxlength="320" class="form-control">{{ old('summary', $transferItem->summary) }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Details</label>
        <textarea name="details" rows="7" maxlength="3000" class="form-control">{{ old('details', $transferItem->details) }}</textarea>
    </div>

    <div class="col-md-3">
        <label class="form-label fw-semibold">Sort Order</label>
        <input type="number" min="0" max="9999" name="sort_order" value="{{ old('sort_order', $transferItem->sort_order ?? 0) }}" class="form-control">
    </div>

    @if ($transferItem->player_image)
        <div class="col-12">
            <span class="fw-semibold d-block mb-2">Current image:</span>
            <img src="{{ $transferItem->player_image }}" alt="Current transfer player image" class="img-thumbnail image-preview">
        </div>
    @endif

    <div class="col-md-3">
        <label class="form-label fw-semibold">Featured</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured" {{ old('is_featured', $transferItem->is_featured) ? 'checked' : '' }}>
            <label class="form-check-label" for="isFeatured">Yes</label>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Publication</label>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_published" value="1" class="form-check-input" id="isPublished" {{ old('is_published', $transferItem->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="isPublished">Mark as published</label>
        </div>
    </div>

    <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-brand" type="submit">{{ $submitLabel }}</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.transfers.index') }}">Cancel</a>
    </div>
</form>
