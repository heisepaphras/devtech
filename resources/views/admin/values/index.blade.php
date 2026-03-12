@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <span class="kicker">Admin</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Manage Player Values</h1>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-brand" href="{{ route('admin.player-values.create') }}">Create Value</a>
            <a class="btn btn-outline-light" href="{{ route('players.value') }}">View Public Values</a>
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
                            <th>Value</th>
                            <th>Change</th>
                            <th>Status</th>
                            <th>Assessed</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($playerValues as $item)
                            <tr>
                                <td>
                                    @php
                                        $valueImage = $item->player_image ?: $item->playerProfile?->profile_image;
                                    @endphp
                                    <img
                                        src="{{ $valueImage ? asset('storage/' . $valueImage) : asset('images/gallery-placeholder.svg') }}"
                                        alt="{{ $item->player_name_snapshot }}"
                                        class="img-thumbnail"
                                        style="width: 64px; height: 64px; object-fit: cover;"
                                    >
                                </td>
                                <td>
                                    <strong>{{ $item->player_name_snapshot }}</strong>
                                    <div class="small text-secondary">/{{ $item->slug }}</div>
                                    @if ($item->is_featured)
                                        <span class="badge text-bg-primary mt-1">Featured</span>
                                    @endif
                                </td>
                                <td>
                                    <div>NGN {{ number_format($item->value_ngn) }}</div>
                                    @if ($item->previous_value_ngn)
                                        <small class="text-secondary">Prev: NGN {{ number_format($item->previous_value_ngn) }}</small>
                                    @endif
                                </td>
                                <td>{{ ucfirst($item->value_change) }}</td>
                                <td>
                                    @if ($item->is_published)
                                        <span class="badge text-bg-success">Published</span>
                                    @else
                                        <span class="badge text-bg-warning">Draft</span>
                                    @endif
                                </td>
                                <td>{{ optional($item->assessed_at)->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2 align-items-center">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.player-values.edit', $item) }}">Edit</a>
                                        <form action="{{ route('admin.player-values.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this player value?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No player values found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $playerValues->onEachSide(1)->links() }}
        </div>
    </div>
</section>
@endsection
