@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <div>
            <span class="kicker">Market Assessment</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Players Value</h1>
        </div>
    </div>
</section>

@if ($featuredValues->isNotEmpty())
<section class="py-5">
    <div class="container">
        <h2 class="section-title mb-3">Featured Valuations</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($featuredValues as $item)
                @php
                    $badgeClass = match($item->value_change) {
                        'increase' => 'text-bg-success',
                        'decrease' => 'text-bg-danger',
                        default => 'text-bg-secondary',
                    };
                    $valueImage = $item->player_image ?: $item->playerProfile?->profile_image;
                @endphp
                <div class="col">
                    <article class="card border-0 shadow-sm h-100">
                        <img
                            src="{{ $valueImage ? $valueImage : asset('images/gallery-placeholder.svg') }}"
                            alt="{{ $item->player_name_snapshot }}"
                            class="card-img-top news-card-img"
                        >
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h3 class="h6 mb-0 text-brand">{{ $item->player_name_snapshot }}</h3>
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($item->value_change) }}</span>
                            </div>
                            <p class="small text-secondary mb-2">Assessed {{ optional($item->assessed_at)->format('M d, Y') }}</p>
                            <p class="h5 mb-2">NGN {{ number_format($item->value_ngn) }}</p>
                            @if ($item->previous_value_ngn)
                                <p class="small text-secondary mb-3">Previous: NGN {{ number_format($item->previous_value_ngn) }}</p>
                            @endif
                            <a class="btn btn-sm btn-outline-brand mt-auto" href="{{ route('players.value.show', $item->slug) }}">View Breakdown</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-5 {{ $featuredValues->isNotEmpty() ? 'soft-surface border-top' : '' }}">
    <div class="container">
        <h2 class="section-title mb-3">All Player Values</h2>

        @if ($playerValues->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <p class="text-secondary mb-0">No player values published yet.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($playerValues as $item)
                    @php
                        $badgeClass = match($item->value_change) {
                            'increase' => 'text-bg-success',
                            'decrease' => 'text-bg-danger',
                            default => 'text-bg-secondary',
                        };
                        $valueImage = $item->player_image ?: $item->playerProfile?->profile_image;
                    @endphp
                    <div class="col">
                        <article class="card border-0 shadow-sm h-100">
                            <img
                                src="{{ $valueImage ? $valueImage : asset('images/gallery-placeholder.svg') }}"
                                alt="{{ $item->player_name_snapshot }}"
                                class="card-img-top news-card-img"
                            >
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h3 class="h6 mb-0 text-brand">{{ $item->player_name_snapshot }}</h3>
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($item->value_change) }}</span>
                                </div>
                                <p class="h5 mb-2">NGN {{ number_format($item->value_ngn) }}</p>
                                <p class="small text-secondary mb-2">Assessed {{ optional($item->assessed_at)->format('M d, Y') }}</p>
                                @if ($item->playerProfile)
                                    <p class="small text-secondary mb-3">Linked profile: {{ $item->playerProfile->full_name }}</p>
                                @endif
                                <a class="btn btn-sm btn-outline-brand mt-auto" href="{{ route('players.value.show', $item->slug) }}">Open Details</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $playerValues->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
