@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <span class="kicker">Admin</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Manage Video Clips</h1>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-brand" href="{{ route('admin.videos.create') }}">Create Video Clip</a>
            <a class="btn btn-outline-light" href="{{ route('videos') }}">View Public Videos</a>
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
                            <th>Title</th>
                            <th>Category</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Sort</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($videoClips as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->title }}</strong>
                                    <div class="small text-secondary">/{{ $item->slug }}</div>
                                    @if ($item->is_featured)
                                        <span class="badge text-bg-primary mt-1">Featured</span>
                                    @endif
                                </td>
                                <td>{{ $item->category ?: 'General' }}</td>
                                <td>{{ $item->duration_seconds ? gmdate('i:s', $item->duration_seconds) : '-' }}</td>
                                <td>
                                    @if ($item->is_published)
                                        <span class="badge text-bg-success">Published</span>
                                    @else
                                        <span class="badge text-bg-warning">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $item->sort_order }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2 align-items-center">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.videos.edit', $item) }}">Edit</a>
                                        <form action="{{ route('admin.videos.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this video clip?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No video clips found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $videoClips->onEachSide(1)->links() }}
        </div>
    </div>
</section>
@endsection
