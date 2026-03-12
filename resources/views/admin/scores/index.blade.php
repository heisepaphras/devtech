@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <span class="kicker">Admin</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Manage Live Scores</h1>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-brand" href="{{ route('admin.live-scores.create') }}">Create Match Entry</a>
            <a class="btn btn-outline-light" href="{{ route('live.score') }}">View Public Live Score</a>
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
                            <th>Logos</th>
                            <th>Match</th>
                            <th>Status</th>
                            <th>Score</th>
                            <th>Kickoff</th>
                            <th>Competition</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($liveScores as $item)
                            <tr>
                                <td>
                                    <div class="d-flex gap-2">
                                        <img
                                            src="{{ $item->home_logo ? asset('storage/' . $item->home_logo) : asset('images/kings-logo.svg') }}"
                                            alt="{{ $item->home_team }}"
                                            class="img-thumbnail"
                                            style="width: 40px; height: 40px; object-fit: cover;"
                                        >
                                        <img
                                            src="{{ $item->away_logo ? asset('storage/' . $item->away_logo) : asset('images/kings-logo.svg') }}"
                                            alt="{{ $item->away_team }}"
                                            class="img-thumbnail"
                                            style="width: 40px; height: 40px; object-fit: cover;"
                                        >
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $item->home_team }} vs {{ $item->away_team }}</strong>
                                    <div class="small text-secondary">/{{ $item->slug }}</div>
                                    @if ($item->is_featured)
                                        <span class="badge text-bg-primary mt-1">Featured</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge text-bg-secondary">{{ ucfirst($item->match_status) }}</span>
                                    @if ($item->match_status === 'live' && $item->live_minute)
                                        <div class="small text-secondary mt-1">{{ $item->live_minute }}'</div>
                                    @endif
                                </td>
                                <td>{{ $item->home_score ?? '-' }} - {{ $item->away_score ?? '-' }}</td>
                                <td>{{ optional($item->kickoff_at)->format('M d, Y h:i A') }}</td>
                                <td>{{ $item->competition ?: '-' }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2 align-items-center">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.live-scores.edit', $item) }}">Edit</a>
                                        <form action="{{ route('admin.live-scores.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this match entry?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No match entries found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $liveScores->onEachSide(1)->links() }}
        </div>
    </div>
</section>
@endsection
