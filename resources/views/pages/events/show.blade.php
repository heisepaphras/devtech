@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Academy Event</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">{{ $eventItem->title }}</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <article class="card border-0 shadow-sm">
                    <img
                        src="{{ $eventItem->featured_image ? asset('storage/' . $eventItem->featured_image) : asset('images/gallery-placeholder.svg') }}"
                        alt="{{ $eventItem->title }}"
                        class="card-img-top news-card-img"
                    >
                    <div class="card-body p-4 p-lg-5">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="event-meta-box p-3 rounded">
                                    <small class="text-secondary d-block">Start</small>
                                    <strong>{{ $eventItem->starts_at->format('M d, Y • h:i A') }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="event-meta-box p-3 rounded">
                                    <small class="text-secondary d-block">End</small>
                                    <strong>
                                        {{ $eventItem->ends_at ? $eventItem->ends_at->format('M d, Y • h:i A') : 'Not specified' }}
                                    </strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="event-meta-box p-3 rounded">
                                    <small class="text-secondary d-block">Type</small>
                                    <strong>{{ $eventItem->event_type ?: 'General Event' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="event-meta-box p-3 rounded">
                                    <small class="text-secondary d-block">Venue</small>
                                    <strong>{{ $eventItem->venue ?: 'To be announced' }}</strong>
                                </div>
                            </div>
                        </div>

                        @if ($eventItem->summary)
                            <p class="fw-semibold text-brand mb-3">{{ $eventItem->summary }}</p>
                        @endif

                        @if ($eventItem->description)
                            <div class="article-content">{!! nl2br(e($eventItem->description)) !!}</div>
                        @endif

                        <div class="mt-4 d-flex gap-2 flex-wrap">
                            <a class="btn btn-outline-brand" href="{{ route('events') }}">Back to Events</a>
                            @if ($eventItem->registration_link)
                                <a class="btn btn-brand" href="{{ $eventItem->registration_link }}" target="_blank" rel="noopener">Open Registration</a>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

@if ($relatedEvents->isNotEmpty())
<section class="py-5 soft-surface">
    <div class="container">
        <h2 class="section-title mb-3">Related Events</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($relatedEvents as $event)
                <div class="col">
                    <article class="card h-100 border-0 shadow-sm">
                        <img
                            src="{{ $event->featured_image ? asset('storage/' . $event->featured_image) : asset('images/gallery-placeholder.svg') }}"
                            alt="{{ $event->title }}"
                            class="card-img-top news-card-img"
                        >
                        <div class="card-body">
                            <p class="small text-secondary mb-2">{{ $event->starts_at->format('M d, Y • h:i A') }}</p>
                            <h3 class="h6 mb-2 text-brand">{{ $event->title }}</h3>
                            <p class="small text-secondary mb-3">{{ $event->event_type ?: 'General Event' }}</p>
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('events.show', $event->slug) }}">Details</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
