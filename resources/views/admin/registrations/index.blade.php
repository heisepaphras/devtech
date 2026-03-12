@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <span class="kicker">Admin</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Manage Registrations</h1>
        </div>
        <a class="btn btn-outline-light" href="{{ route('register') }}">Open Public Registration Form</a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.registrations.index') }}" class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold mb-1">Filter by status</label>
                        <select name="status" class="form-select">
                            <option value="">All statuses</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" {{ $statusFilter === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8 d-flex gap-2">
                        <button class="btn btn-brand" type="submit">Apply Filter</button>
                        <a class="btn btn-outline-secondary" href="{{ route('admin.registrations.index') }}">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Applicant</th>
                            <th>Reference</th>
                            <th>Status</th>
                            <th>Contact</th>
                            <th>Submitted</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->full_name }}</strong>
                                    <div class="small text-secondary">{{ $item->age_group ?: 'No age group' }}</div>
                                </td>
                                <td>
                                    <span class="small fw-semibold">{{ $item->reference_code }}</span>
                                </td>
                                <td>
                                    <span class="badge text-bg-secondary">{{ ucfirst($item->status) }}</span>
                                </td>
                                <td>
                                    <div class="small">{{ $item->phone }}</div>
                                    <div class="small text-secondary">{{ $item->email ?: '-' }}</div>
                                </td>
                                <td>{{ optional($item->submitted_at)->format('M d, Y h:i A') }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2 align-items-center">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.registrations.edit', $item) }}">Review</a>
                                        <form action="{{ route('admin.registrations.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this registration?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No registrations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $applications->onEachSide(1)->links() }}
        </div>
    </div>
</section>
@endsection
