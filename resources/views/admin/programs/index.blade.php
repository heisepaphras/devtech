@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <span class="kicker">Admin</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Manage Scouting Programs</h1>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-brand" href="{{ route('admin.programs.create') }}">Create Program</a>
            <a class="btn btn-outline-light" href="{{ route('scouting.trials') }}">View Public Programs</a>
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
                            <th>Age Group</th>
                            <th>Status</th>
                            <th>Schedule</th>
                            <th>Sort</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($programs as $program)
                            <tr>
                                <td>
                                    <img
                                        src="{{ $program->featured_image ? $program->featured_image : asset('images/gallery-placeholder.svg') }}"
                                        alt="{{ $program->title }}"
                                        class="img-thumbnail"
                                        style="width: 64px; height: 64px; object-fit: cover;"
                                    >
                                </td>
                                <td>
                                    <strong>{{ $program->title }}</strong>
                                    <div class="small text-secondary">/{{ $program->slug }}</div>
                                    @if ($program->is_featured)
                                        <span class="badge text-bg-primary mt-1">Featured</span>
                                    @endif
                                </td>
                                <td>{{ $program->age_group ?: '-' }}</td>
                                <td>
                                    @if ($program->is_published)
                                        <span class="badge text-bg-success">Published</span>
                                    @else
                                        <span class="badge text-bg-warning">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $program->schedule ?: '-' }}</td>
                                <td>{{ $program->sort_order }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2 align-items-center">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.programs.edit', $program) }}">Edit</a>
                                        <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Delete this program?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No programs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $programs->onEachSide(1)->links() }}
        </div>
    </div>
</section>
@endsection
