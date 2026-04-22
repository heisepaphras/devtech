@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Players Value</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-1">{{ $playerValue->player_name_snapshot }}</h1>
        <p class="text-light mb-0">Assessed {{ optional($playerValue->assessed_at)->format('M d, Y') }}</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <article class="card border-0 shadow-sm h-100">
                    @php
                        $valueImage = $playerValue->player_image ?: $playerValue->playerProfile?->profile_image;
                    @endphp
                    <img
                        src="{{ $valueImage ? $valueImage : asset('images/gallery-placeholder.svg') }}"
                        alt="{{ $playerValue->player_name_snapshot }}"
                        class="card-img-top news-card-img"
                    >
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="h4 mb-3 text-brand">Current Value: NGN {{ number_format($playerValue->value_ngn) }}</h2>
                        @if ($playerValue->previous_value_ngn)
                            <p class="text-secondary mb-3">Previous Value: NGN {{ number_format($playerValue->previous_value_ngn) }}</p>
                        @endif
                        <p class="mb-3"><strong>Change:</strong> {{ ucfirst($playerValue->value_change) }}</p>

                        @if ($playerValue->assessment_note)
                            <h3 class="h5 section-title">Assessment Notes</h3>
                            <div class="article-content mb-4">{!! nl2br(e($playerValue->assessment_note)) !!}</div>
                        @endif

                        <div class="d-flex gap-2 flex-wrap">
                            @if ($playerValue->playerProfile)
                                <a class="btn btn-brand" href="{{ route('player.profiles.show', $playerValue->playerProfile->slug) }}">Open Player CV</a>
                            @endif
                            <a class="btn btn-outline-brand" href="{{ route('players.value') }}">Back to Players Value</a>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h2 class="h5 section-title mb-3">Value Metadata</h2>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2"><strong>Player:</strong> {{ $playerValue->player_name_snapshot }}</li>
                            <li class="mb-2"><strong>Assessed Date:</strong> {{ optional($playerValue->assessed_at)->format('M d, Y') }}</li>
                            <li class="mb-2"><strong>Assessor:</strong> {{ $playerValue->assessor_name ?: 'Internal Technical Team' }}</li>
                            <li class="mb-0"><strong>Linked CV:</strong> {{ $playerValue->playerProfile ? 'Yes' : 'No' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if ($relatedValues->isNotEmpty())
<section class="py-5 soft-surface">
    <div class="container">
        <h2 class="section-title mb-4">Related Value Updates</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($relatedValues as $item)
                <div class="col">
                    <article class="card border-0 shadow-sm h-100">
                        @php
                            $relatedValueImage = $item->player_image ?: $item->playerProfile?->profile_image;
                        @endphp
                        <img
                            src="{{ $relatedValueImage ? $relatedValueImage : asset('images/gallery-placeholder.svg') }}"
                            alt="{{ $item->player_name_snapshot }}"
                            class="card-img-top news-card-img"
                        >
                        <div class="card-body">
                            <h3 class="h6 text-brand mb-1">{{ $item->player_name_snapshot }}</h3>
                            <p class="mb-2">NGN {{ number_format($item->value_ngn) }}</p>
                            <p class="small text-secondary mb-3">Assessed {{ optional($item->assessed_at)->format('M d, Y') }}</p>
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('players.value.show', $item->slug) }}">View</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
