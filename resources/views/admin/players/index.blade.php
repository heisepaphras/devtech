@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <span class="kicker">Admin</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Manage Player Profiles</h1>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-brand" href="{{ route('admin.player-profiles.create') }}">Create Player Profile</a>
            <a class="btn btn-outline-light" href="{{ route('player.profiles') }}">View Public Profiles</a>
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
                            <th>Player</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Team</th>
                            <th>Sort</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($playerProfiles as $player)
                            <tr>
                                <td>
                                    <strong>{{ $player->full_name }}</strong>
                                    <div class="small text-secondary">/{{ $player->slug }}</div>
                                    @if ($player->jersey_number)
                                        <div class="small text-secondary">#{{ $player->jersey_number }}</div>
                                    @endif
                                    @if ($player->is_featured)
                                        <span class="badge text-bg-primary mt-1">Featured</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $player->primary_position ?: 'N/A' }}</div>
                                    <small class="text-secondary">{{ $player->secondary_position ?: '' }}</small>
                                </td>
                                <td>
                                    @if ($player->is_published)
                                        <span class="badge text-bg-success">Published</span>
                                    @else
                                        <span class="badge text-bg-warning">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $player->current_team ?: 'Abuja Kings Football Academy' }}</td>
                                <td>{{ $player->sort_order }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2 align-items-center">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.player-profiles.edit', $player) }}">Edit</a>
                                        <form action="{{ route('admin.player-profiles.destroy', $player) }}" method="POST" onsubmit="return confirm('Delete this player profile?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No player profiles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $playerProfiles->onEachSide(1)->links() }}
        </div>
    </div>
</section>
@endsection
