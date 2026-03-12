@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <div>
            <span class="kicker">Academy Team</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Academy Players & Management</h1>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-3">
            <h2 class="section-title mb-0">Featured Players</h2>
            <a class="btn btn-outline-brand btn-sm" href="{{ route('player.profiles') }}">View All Player CVs</a>
        </div>

        @if ($featuredPlayers->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <p class="text-secondary mb-0">No featured players available right now.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($featuredPlayers as $player)
                    <div class="col">
                        <article class="card border-0 shadow-sm h-100 overflow-hidden">
                            @if ($player->profile_image)
                                <img src="{{ asset('storage/' . $player->profile_image) }}" alt="{{ $player->full_name }}" class="card-img-top news-card-img">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h3 class="h6 text-brand mb-1">{{ $player->full_name }}</h3>
                                <p class="small text-secondary mb-2">
                                    {{ $player->primary_position ?: 'Player' }}
                                    @if ($player->jersey_number)
                                        | #{{ $player->jersey_number }}
                                    @endif
                                </p>
                                @if ($player->summary)
                                    <p class="text-secondary mb-3">{{ \Illuminate\Support\Str::limit($player->summary, 120) }}</p>
                                @endif
                                <a class="btn btn-sm btn-outline-brand mt-auto" href="{{ route('player.profiles.show', $player->slug) }}">View Player CV</a>
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
        <h2 class="section-title mb-3">Management & Technical Team</h2>

        @if ($managementMembers->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <p class="text-secondary mb-0">No management profiles published yet.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($managementMembers as $member)
                    <div class="col">
                        <article class="card border-0 shadow-sm h-100 overflow-hidden">
                            @if ($member->image_path)
                                <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->full_name }}" class="card-img-top news-card-img">
                            @endif
                            <div class="card-body">
                                <h3 class="h6 text-brand mb-1">{{ $member->full_name }}</h3>
                                <p class="small fw-semibold mb-1">{{ $member->role_title }}</p>
                                <p class="small text-secondary mb-2">
                                    {{ $member->department ?: 'Management' }}
                                    @if (!is_null($member->experience_years))
                                        | {{ $member->experience_years }} yrs experience
                                    @endif
                                </p>
                                @if ($member->bio)
                                    <p class="text-secondary mb-2">{{ \Illuminate\Support\Str::limit($member->bio, 130) }}</p>
                                @endif
                                @if ($member->email || $member->phone)
                                    <p class="small mb-0">
                                        @if ($member->email)
                                            <span class="d-block">{{ $member->email }}</span>
                                        @endif
                                        @if ($member->phone)
                                            <span class="d-block">{{ $member->phone }}</span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
