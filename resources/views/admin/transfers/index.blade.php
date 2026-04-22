@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <span class="kicker">Admin</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Manage Transfer Market</h1>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-brand" href="{{ route('admin.transfers.create') }}">Create Transfer Update</a>
            <a class="btn btn-outline-light" href="{{ route('transfer.market') }}">View Public Transfer Market</a>
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
                            <th>Player</th>
                            <th>Move</th>
                            <th>Status</th>
                            <th>Announced</th>
                            <th>Sort</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transferItems as $item)
                            <tr>
                                <td>
                                    <img
                                        src="{{ $item->player_image ? $item->player_image : asset('images/gallery-placeholder.svg') }}"
                                        alt="{{ $item->player_name }}"
                                        class="img-thumbnail"
                                        style="width: 64px; height: 64px; object-fit: cover;"
                                    >
                                </td>
                                <td>
                                    <strong>{{ $item->player_name }}</strong>
                                    <div class="small text-secondary">{{ $item->title }}</div>
                                    <div class="small text-secondary">/{{ $item->slug }}</div>
                                    @if ($item->is_featured)
                                        <span class="badge text-bg-primary mt-1">Featured</span>
                                    @endif
                                </td>
                                <td>
                                    <div><strong>{{ ucfirst(str_replace('-', ' ', $item->transfer_type)) }}</strong></div>
                                    <small class="text-secondary">{{ $item->from_club ?: 'N/A' }} -> {{ $item->to_club ?: 'N/A' }}</small>
                                </td>
                                <td>
                                    @if ($item->is_published)
                                        <span class="badge text-bg-success">Published</span>
                                    @else
                                        <span class="badge text-bg-warning">Draft</span>
                                    @endif
                                </td>
                                <td>{{ optional($item->announced_at)->format('M d, Y h:i A') }}</td>
                                <td>{{ $item->sort_order }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2 align-items-center">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.transfers.edit', $item) }}">Edit</a>
                                        <form action="{{ route('admin.transfers.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this transfer update?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No transfer updates found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $transferItems->onEachSide(1)->links() }}
        </div>
    </div>
</section>
@endsection
