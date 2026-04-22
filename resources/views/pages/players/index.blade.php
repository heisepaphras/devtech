@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <div>
            <span class="kicker">Academy Talents</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">CV Players Profile</h1>
        </div>
    </div>
</section>

@if ($featuredPlayers->isNotEmpty())
<section class="py-5">
    <div class="container">
        <h2 class="section-title mb-3">Featured Players</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
            @foreach ($featuredPlayers as $player)
                <div class="col">
                    <article class="card border-0 shadow-sm h-100 overflow-hidden">
                        @if ($player->profile_image)
                            <img src="{{ $player->profile_image }}" alt="{{ $player->full_name }}" class="card-img-top news-card-img">
                        @endif
                        <div class="card-body">
                            <h3 class="h6 text-brand mb-1">{{ $player->full_name }}</h3>
                            <p class="small text-secondary mb-2">
                                {{ $player->primary_position ?: 'Player' }}
                                @if ($player->jersey_number)
                                    | #{{ $player->jersey_number }}
                                @endif
                            </p>
                            <a class="btn btn-sm btn-outline-brand" href="{{ route('player.profiles.show', $player->slug) }}">View CV</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-5 {{ $featuredPlayers->isNotEmpty() ? 'soft-surface border-top' : '' }}">
    <div class="container">
        <h2 class="section-title mb-3">All Player Profiles</h2>

        @if ($playerProfiles->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <p class="text-secondary mb-0">No player profiles published yet.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($playerProfiles as $player)
                    <div class="col">
                        <article class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between gap-2">
                                    <h3 class="h5 text-brand mb-0">{{ $player->full_name }}</h3>
                                    @if ($player->jersey_number)
                                        <span class="badge text-bg-primary">#{{ $player->jersey_number }}</span>
                                    @endif
                                </div>
                                <p class="small text-secondary mt-2 mb-1">{{ $player->primary_position ?: 'N/A' }}</p>
                                <p class="small text-secondary mb-2">{{ $player->current_team ?: 'Abuja Kings Football Academy' }}</p>
                                @if ($player->summary)
                                    <p class="text-secondary mb-3">{{ $player->summary }}</p>
                                @endif
                                <a class="btn btn-sm btn-outline-brand mt-auto" href="{{ route('player.profiles.show', $player->slug) }}">Open Profile</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $playerProfiles->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
