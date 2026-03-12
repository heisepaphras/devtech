@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Player CV</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-1">{{ $playerProfile->full_name }}</h1>
        <p class="text-light mb-0">
            {{ $playerProfile->primary_position ?: 'Player' }}
            @if ($playerProfile->secondary_position)
                | {{ $playerProfile->secondary_position }}
            @endif
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        @if ($playerProfile->profile_image)
                            <img src="{{ asset('storage/' . $playerProfile->profile_image) }}" alt="{{ $playerProfile->full_name }}" class="img-fluid rounded mb-3">
                        @endif

                        <h2 class="h5 section-title mb-3">Player Details</h2>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2"><strong>Name:</strong> {{ $playerProfile->full_name }}</li>
                            <li class="mb-2"><strong>Nationality:</strong> {{ $playerProfile->nationality ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Preferred Foot:</strong> {{ $playerProfile->preferred_foot ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Position:</strong> {{ $playerProfile->primary_position ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Secondary Position:</strong> {{ $playerProfile->secondary_position ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Jersey Number:</strong> {{ $playerProfile->jersey_number ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Height:</strong> {{ $playerProfile->height_cm ? $playerProfile->height_cm . ' cm' : 'N/A' }}</li>
                            <li class="mb-2"><strong>Weight:</strong> {{ $playerProfile->weight_kg ? $playerProfile->weight_kg . ' kg' : 'N/A' }}</li>
                            <li class="mb-2"><strong>Date of Birth:</strong> {{ optional($playerProfile->date_of_birth)->format('M d, Y') ?: 'N/A' }}</li>
                            <li class="mb-0"><strong>Current Team:</strong> {{ $playerProfile->current_team ?: 'Abuja Kings Football Academy' }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 p-lg-5">
                        @if ($playerProfile->summary)
                            <p class="fw-semibold text-brand mb-3">{{ $playerProfile->summary }}</p>
                        @endif

                        @if ($playerProfile->bio)
                            <h2 class="h5 section-title">Bio</h2>
                            <div class="article-content mb-4">{!! nl2br(e($playerProfile->bio)) !!}</div>
                        @endif

                        @if ($playerProfile->strengths)
                            <h2 class="h5 section-title">Strengths</h2>
                            <div class="article-content mb-4">{!! nl2br(e($playerProfile->strengths)) !!}</div>
                        @endif

                        @if ($playerProfile->achievements)
                            <h2 class="h5 section-title">Achievements</h2>
                            <div class="article-content mb-4">{!! nl2br(e($playerProfile->achievements)) !!}</div>
                        @endif

                        <div class="d-flex gap-2 flex-wrap">
                            @if ($playerProfile->video_url)
                                <a class="btn btn-brand" href="{{ $playerProfile->video_url }}" target="_blank" rel="noopener">Watch Video</a>
                            @endif
                            @if ($playerProfile->cv_document)
                                <a class="btn btn-outline-brand" href="{{ asset('storage/' . $playerProfile->cv_document) }}" target="_blank" rel="noopener">Download CV (PDF)</a>
                            @endif
                            <a class="btn btn-outline-secondary" href="{{ route('player.profiles') }}">Back to Profiles</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

@if ($relatedPlayers->isNotEmpty())
<section class="py-5 soft-surface">
    <div class="container">
        <h2 class="section-title mb-4">Related Players</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($relatedPlayers as $item)
                <div class="col">
                    <article class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h3 class="h6 text-brand mb-1">{{ $item->full_name }}</h3>
                            <p class="small text-secondary mb-2">{{ $item->primary_position ?: 'Player' }}</p>
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('player.profiles.show', $item->slug) }}">View Profile</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
