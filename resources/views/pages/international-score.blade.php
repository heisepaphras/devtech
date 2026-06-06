@extends('layouts.app')

@section('content')
<style>
    .live-dot-pulse {
        display: inline-block;
        width: 8px;
        height: 8px;
        background-color: #ff3333;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(255, 51, 51, 0.7);
        animation: livePulse 1.5s infinite;
        vertical-align: middle;
    }

    @keyframes livePulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(255, 51, 51, 0.7);
        }
        70% {
            transform: scale(1);
            box-shadow: 0 0 0 6px rgba(255, 51, 51, 0);
        }
        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(255, 51, 51, 0);
        }
    }

    .league-header-card {
        background: linear-gradient(135deg, var(--kfa-navy-700) 0%, var(--kfa-navy-600) 100%);
        border-bottom: 2px solid var(--kfa-gold-500);
        color: #fff;
    }

    .match-fixture-row {
        background-color: #fffdf9;
        border: 1px solid #e8d5ab;
        transition: transform 0.22s ease, box-shadow 0.22s ease;
    }

    .match-fixture-row:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(10, 29, 65, 0.08);
        border-color: var(--kfa-gold-500);
    }

    .team-logo-crest {
        width: 32px;
        height: 32px;
        object-fit: contain;
    }

    .league-logo-badge {
        width: 26px;
        height: 26px;
        object-fit: contain;
    }

    .event-log-pill {
        background: rgba(23, 57, 122, 0.04);
        border: 1px solid rgba(23, 57, 122, 0.08);
        font-size: 0.78rem;
    }
</style>

<section class="page-shell py-5">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <span class="kicker">Real-Time Matchday</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">International Live Scores</h1>
        </div>
        <div>
            <a href="{{ route('international.score') }}" class="btn btn-brand">
                <i class="fa-solid fa-rotate me-1"></i> Refresh Scores
            </a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if ($isMock)
            <div class="alert alert-warning border-warning-subtle shadow-sm mb-5 p-4 rounded-3" role="alert">
                <div class="d-flex gap-3">
                    <div class="fs-4 text-warning">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                    <div>
                        <h4 class="alert-heading h6 fw-bold text-brand mb-1">Live Simulation Mode</h4>
                        <p class="small text-secondary mb-0">
                            Currently showing realistic simulated live matches. Add your <code>APIFOOTBALL_KEY</code> credential to the <code>.env</code> file to fetch live streams directly from API-Football.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if ($groupedMatches->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5 text-center">
                    <h3 class="h4 text-brand mb-2">No Live Matches Right Now</h3>
                    <p class="text-secondary mb-0">There are currently no active international live fixtures recorded. Please check back later during match hours.</p>
                </div>
            </div>
        @else
            <div class="d-flex flex-column gap-5">
                @foreach ($groupedMatches as $leagueName => $matches)
                    <div class="league-group">
                        <!-- League Header -->
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body p-3 league-header-card d-flex align-items-center justify-content-between rounded-3">
                                <div class="d-flex align-items-center gap-2">
                                    @if (!empty($matches[0]['league']['logo']))
                                        <img src="{{ $matches[0]['league']['logo'] }}" alt="{{ $leagueName }}" class="league-logo-badge bg-white p-0.5 rounded-circle">
                                    @endif
                                    <h2 class="h6 mb-0 fw-bold font-monospace text-uppercase tracking-wider text-warning">{{ $leagueName }}</h2>
                                </div>
                                <span class="small text-warning-subtle fw-semibold">{{ $matches[0]['league']['country'] ?? 'Global' }}</span>
                            </div>
                        </div>

                        <!-- Match Fixtures List -->
                        <div class="d-flex flex-column gap-3">
                            @foreach ($matches as $match)
                                <div class="card border-0 shadow-sm rounded-3 match-fixture-row">
                                    <div class="card-body p-4">
                                        <div class="row align-items-center g-3 text-center text-md-start">
                                            <!-- Home Team -->
                                            <div class="col-md-4 d-flex align-items-center justify-content-center justify-content-md-end gap-3 order-1">
                                                <span class="fw-bold text-brand text-end d-none d-md-inline">{{ $match['teams']['home']['name'] }}</span>
                                                <span class="fw-bold text-brand d-inline d-md-none text-center">{{ $match['teams']['home']['name'] }}</span>
                                                @if (!empty($match['teams']['home']['logo']))
                                                    <img src="{{ $match['teams']['home']['logo'] }}" alt="{{ $match['teams']['home']['name'] }}" class="team-logo-crest">
                                                @endif
                                            </div>

                                            <!-- Live Score & Match Minutes -->
                                            <div class="col-md-4 text-center order-2 py-2 py-md-0 border-start border-end border-warning-subtle">
                                                <div class="d-flex align-items-center justify-content-center gap-3">
                                                    <span class="fs-3 fw-extrabold text-brand">{{ $match['goals']['home'] ?? 0 }}</span>
                                                    <span class="text-secondary small fw-bold font-monospace px-2 py-1 rounded bg-body-secondary">
                                                        @if (in_array($match['fixture']['status']['short'], ['1H', '2H']))
                                                            <span class="live-dot-pulse me-1"></span>
                                                            <span class="text-danger">{{ $match['fixture']['status']['elapsed'] }}'</span>
                                                        @elseif ($match['fixture']['status']['short'] === 'HT')
                                                            <span class="text-warning">HT</span>
                                                        @elseif ($match['fixture']['status']['short'] === 'FT')
                                                            <span class="text-secondary">FT</span>
                                                        | @else
                                                            {{ $match['fixture']['status']['short'] }}
                                                        @endif
                                                    </span>
                                                    <span class="fs-3 fw-extrabold text-brand">{{ $match['goals']['away'] ?? 0 }}</span>
                                                </div>
                                                <span class="small text-secondary mt-1 d-block font-monospace">{{ $match['fixture']['status']['long'] }}</span>
                                            </div>

                                            <!-- Away Team -->
                                            <div class="col-md-4 d-flex align-items-center justify-content-center justify-content-md-start gap-3 order-3">
                                                @if (!empty($match['teams']['away']['logo']))
                                                    <img src="{{ $match['teams']['away']['logo'] }}" alt="{{ $match['teams']['away']['name'] }}" class="team-logo-crest">
                                                @endif
                                                <span class="fw-bold text-brand text-start d-none d-md-inline">{{ $match['teams']['away']['name'] }}</span>
                                                <span class="fw-bold text-brand d-inline d-md-none text-center">{{ $match['teams']['away']['name'] }}</span>
                                            </div>
                                        </div>

                                        <!-- Match Events (Scorers etc) -->
                                        @if (!empty($match['events']))
                                            <div class="mt-4 pt-3 border-top border-warning-subtle d-flex flex-wrap gap-2 justify-content-center">
                                                @foreach ($match['events'] as $event)
                                                    @if ($event['type'] === 'Goal')
                                                        <div class="badge rounded-pill px-3 py-1.5 event-log-pill text-dark d-flex align-items-center gap-1.5">
                                                            <i class="fa-solid fa-futbol text-success"></i>
                                                            <span class="fw-semibold text-brand">{{ $event['player']['name'] ?? 'Player' }}</span> 
                                                            <span class="text-secondary font-monospace">({{ $event['time']['elapsed'] }}')</span>
                                                            @if (!empty($event['detail']) && $event['detail'] !== 'Normal Goal')
                                                                <span class="small text-muted font-monospace text-xs">[{{ $event['detail'] }}]</span>
                                                            @endif
                                                            <span class="text-muted small fs-xs ms-1">({{ $event['team']['name'] }})</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
