@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Live Score</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-1">{{ $liveScore->title }}</h1>
        <p class="text-light mb-0">{{ $liveScore->competition ?: 'Friendly Match' }}</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 p-lg-5">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $liveScore->home_logo ? asset('storage/' . $liveScore->home_logo) : asset('images/kings-logo.svg') }}" alt="{{ $liveScore->home_team }}" class="img-thumbnail p-1" style="width: 54px; height: 54px; object-fit: cover;">
                            <img src="{{ $liveScore->away_logo ? asset('storage/' . $liveScore->away_logo) : asset('images/kings-logo.svg') }}" alt="{{ $liveScore->away_team }}" class="img-thumbnail p-1" style="width: 54px; height: 54px; object-fit: cover;">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="h5 mb-0">{{ $liveScore->home_team }} vs {{ $liveScore->away_team }}</h2>
                            <span class="badge text-bg-secondary">{{ ucfirst($liveScore->match_status) }}</span>
                        </div>

                        <p class="h2 text-brand mb-3">{{ $liveScore->home_score ?? '-' }} - {{ $liveScore->away_score ?? '-' }}</p>

                        <p class="small text-secondary mb-2">Kickoff: {{ optional($liveScore->kickoff_at)->format('M d, Y h:i A') }}</p>
                        <p class="small text-secondary mb-3">Venue: {{ $liveScore->venue ?: 'Venue not specified' }}</p>

                        @if ($liveScore->match_report)
                            <h3 class="h5 section-title">Match Report</h3>
                            <div class="article-content mb-4">{!! nl2br(e($liveScore->match_report)) !!}</div>
                        @endif

                        <a class="btn btn-outline-brand" href="{{ route('live.score') }}">Back to Live Score</a>
                    </div>
                </article>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h2 class="h5 section-title mb-3">Match Snapshot</h2>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2"><strong>Status:</strong> {{ ucfirst($liveScore->match_status) }}</li>
                            <li class="mb-2"><strong>Live Minute:</strong> {{ $liveScore->live_minute ? $liveScore->live_minute . "'" : 'N/A' }}</li>
                            <li class="mb-2"><strong>Home Team:</strong> {{ $liveScore->home_team }}</li>
                            <li class="mb-2"><strong>Away Team:</strong> {{ $liveScore->away_team }}</li>
                            <li class="mb-0"><strong>Competition:</strong> {{ $liveScore->competition ?: 'Friendly Match' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if ($relatedMatches->isNotEmpty())
<section class="py-5 soft-surface">
    <div class="container">
        <h2 class="section-title mb-4">Related Matches</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($relatedMatches as $item)
                <div class="col">
                    <article class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <img src="{{ $item->home_logo ? asset('storage/' . $item->home_logo) : asset('images/kings-logo.svg') }}" alt="{{ $item->home_team }}" class="img-thumbnail p-1" style="width: 34px; height: 34px; object-fit: cover;">
                                <img src="{{ $item->away_logo ? asset('storage/' . $item->away_logo) : asset('images/kings-logo.svg') }}" alt="{{ $item->away_team }}" class="img-thumbnail p-1" style="width: 34px; height: 34px; object-fit: cover;">
                            </div>
                            <p class="small text-secondary mb-2">{{ optional($item->kickoff_at)->format('M d, Y h:i A') }}</p>
                            <h3 class="h6 mb-2 text-brand">{{ $item->home_team }} vs {{ $item->away_team }}</h3>
                            <p class="mb-3">{{ $item->home_score ?? '-' }} - {{ $item->away_score ?? '-' }}</p>
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('live.score.show', $item->slug) }}">View</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
