@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <div>
            <span class="kicker">Match Center</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Live Score</h1>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="section-title mb-3">Live Matches</h2>

        @if ($liveMatches->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <p class="text-secondary mb-0">No live matches currently.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($liveMatches as $match)
                    <div class="col">
                        <article class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge text-bg-danger">LIVE</span>
                                    <span class="small text-secondary">{{ $match->live_minute ? $match->live_minute . "'" : '' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ $match->home_logo ? asset('storage/' . $match->home_logo) : asset('images/kings-logo.svg') }}" alt="{{ $match->home_team }}" class="img-thumbnail p-1" style="width: 34px; height: 34px; object-fit: cover;">
                                    <img src="{{ $match->away_logo ? asset('storage/' . $match->away_logo) : asset('images/kings-logo.svg') }}" alt="{{ $match->away_team }}" class="img-thumbnail p-1" style="width: 34px; height: 34px; object-fit: cover;">
                                </div>
                                <p class="small text-secondary mb-2">{{ $match->competition ?: 'Friendly Match' }}</p>
                                <h3 class="h6 mb-1">{{ $match->home_team }}</h3>
                                <h3 class="h6 mb-2">{{ $match->away_team }}</h3>
                                <p class="h4 text-brand mb-3">{{ $match->home_score ?? 0 }} - {{ $match->away_score ?? 0 }}</p>
                                <a class="btn btn-sm btn-outline-brand" href="{{ route('live.score.show', $match->slug) }}">Match Details</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="py-5 soft-surface border-top">
    <div class="container">
        <h2 class="section-title mb-3">Upcoming Matches</h2>

        @if ($upcomingMatches->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <p class="text-secondary mb-0">No upcoming matches published yet.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($upcomingMatches as $match)
                    <div class="col">
                        <article class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <span class="badge text-bg-primary mb-2">Upcoming</span>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ $match->home_logo ? asset('storage/' . $match->home_logo) : asset('images/kings-logo.svg') }}" alt="{{ $match->home_team }}" class="img-thumbnail p-1" style="width: 34px; height: 34px; object-fit: cover;">
                                    <img src="{{ $match->away_logo ? asset('storage/' . $match->away_logo) : asset('images/kings-logo.svg') }}" alt="{{ $match->away_team }}" class="img-thumbnail p-1" style="width: 34px; height: 34px; object-fit: cover;">
                                </div>
                                <p class="small text-secondary mb-2">{{ optional($match->kickoff_at)->format('M d, Y h:i A') }}</p>
                                <p class="small text-secondary mb-2">{{ $match->competition ?: 'Friendly Match' }}</p>
                                <h3 class="h6 mb-1">{{ $match->home_team }}</h3>
                                <h3 class="h6 mb-2">{{ $match->away_team }}</h3>
                                <p class="small text-secondary mb-3">{{ $match->venue ?: 'Venue to be announced' }}</p>
                                <a class="btn btn-sm btn-outline-brand" href="{{ route('live.score.show', $match->slug) }}">Preview</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="section-title mb-3">Completed Matches</h2>

        @if ($completedMatches->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <p class="text-secondary mb-0">Completed matches will appear here.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($completedMatches as $match)
                    <div class="col">
                        <article class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <span class="badge text-bg-success mb-2">Completed</span>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ $match->home_logo ? asset('storage/' . $match->home_logo) : asset('images/kings-logo.svg') }}" alt="{{ $match->home_team }}" class="img-thumbnail p-1" style="width: 34px; height: 34px; object-fit: cover;">
                                    <img src="{{ $match->away_logo ? asset('storage/' . $match->away_logo) : asset('images/kings-logo.svg') }}" alt="{{ $match->away_team }}" class="img-thumbnail p-1" style="width: 34px; height: 34px; object-fit: cover;">
                                </div>
                                <p class="small text-secondary mb-2">{{ optional($match->kickoff_at)->format('M d, Y h:i A') }}</p>
                                <p class="small text-secondary mb-2">{{ $match->competition ?: 'Friendly Match' }}</p>
                                <h3 class="h6 mb-1">{{ $match->home_team }}</h3>
                                <h3 class="h6 mb-2">{{ $match->away_team }}</h3>
                                <p class="h5 text-brand mb-3">{{ $match->home_score ?? '-' }} - {{ $match->away_score ?? '-' }}</p>
                                <a class="btn btn-sm btn-outline-brand" href="{{ route('live.score.show', $match->slug) }}">Recap</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $completedMatches->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
