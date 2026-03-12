<form action="{{ route('admin.registrations.update', $application) }}" method="POST" class="row g-3">
    @csrf
    @method('PUT')

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
        <label class="form-label fw-semibold">Status *</label>
        <select name="status" class="form-select" required>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" {{ old('status', $application->status) === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Review Notes</label>
        <textarea name="review_notes" rows="7" maxlength="3000" class="form-control">{{ old('review_notes', $application->review_notes) }}</textarea>
    </div>

    <div class="col-12">
        <div class="form-check">
            <input type="checkbox" name="mark_contacted" value="1" class="form-check-input" id="markContacted" {{ old('mark_contacted', $application->contacted_at) ? 'checked' : '' }}>
            <label class="form-check-label" for="markContacted">Mark as contacted</label>
        </div>
    </div>

    <div class="col-12 d-flex gap-2 flex-wrap">
        <button class="btn btn-brand" type="submit">Save Review</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.registrations.index') }}">Back to List</a>
    </div>
</form>
