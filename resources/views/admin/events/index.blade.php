@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <span class="kicker">Admin</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Manage Events</h1>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-brand" href="{{ route('admin.events.create') }}">Create Event</a>
            <a class="btn btn-outline-light" href="{{ route('events') }}">View Public Events</a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Schedule</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Sort</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($eventItems as $eventItem)
                            <tr>
                                <td>
                                    <img
                                        src="{{ $eventItem->featured_image ? asset('storage/' . $eventItem->featured_image) : asset('images/gallery-placeholder.svg') }}"
                                        alt="{{ $eventItem->title }}"
                                        class="img-thumbnail"
                                        style="width: 64px; height: 64px; object-fit: cover;"
                                    >
                                </td>
                                <td>
                                    <strong>{{ $eventItem->title }}</strong>
                                    <div class="small text-secondary">/{{ $eventItem->slug }}</div>
                                    @if ($eventItem->is_featured)
                                        <span class="badge text-bg-primary mt-1">Featured</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $eventItem->starts_at->format('M d, Y h:i A') }}</div>
                                    @if ($eventItem->ends_at)
                                        <small class="text-secondary">to {{ $eventItem->ends_at->format('M d, Y h:i A') }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if ($eventItem->is_published)
                                        <span class="badge text-bg-success">Published</span>
                                    @else
                                        <span class="badge text-bg-warning">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $eventItem->event_type ?: '-' }}</td>
                                <td>{{ $eventItem->sort_order }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2 align-items-center">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.events.edit', $eventItem) }}">Edit</a>
                                        <form action="{{ route('admin.events.destroy', $eventItem) }}" method="POST" onsubmit="return confirm('Delete this event?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No events found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $eventItems->onEachSide(1)->links() }}
        </div>
    </div>
</section>
@endsection
