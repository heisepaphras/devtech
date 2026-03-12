@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <div>
            <span class="kicker">Academy Calendar</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Events</h1>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-3">
            <h2 class="section-title mb-0">Upcoming Events</h2>
        </div>

        @if ($upcomingEvents->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <p class="text-secondary mb-0">No upcoming events published yet.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($upcomingEvents as $event)
                    <div class="col">
                        <article class="card h-100 border-0 shadow-sm">
                            <img
                                src="{{ $event->featured_image ? asset('storage/' . $event->featured_image) : asset('images/gallery-placeholder.svg') }}"
                                alt="{{ $event->title }}"
                                class="card-img-top news-card-img"
                            >
                            <div class="card-body d-flex flex-column">
                                <p class="small text-secondary mb-2">
                                    {{ $event->starts_at->format('M d, Y • h:i A') }}
                                </p>
                                <h3 class="h5 mb-2 text-brand">{{ $event->title }}</h3>
                                <p class="small text-secondary mb-2">
                                    {{ $event->event_type ?: 'General Event' }}
                                    @if ($event->venue)
                                        • {{ $event->venue }}
                                    @endif
                                </p>
                                @if ($event->summary)
                                    <p class="text-secondary mb-3">{{ $event->summary }}</p>
                                @endif

                                <div class="mt-auto d-flex gap-2 flex-wrap">
                                    <a class="btn btn-sm btn-outline-brand" href="{{ route('events.show', $event->slug) }}">Details</a>
                                    @if ($event->registration_link)
                                        <a class="btn btn-sm btn-brand" href="{{ $event->registration_link }}" target="_blank" rel="noopener">Register</a>
                                    @endif
                                </div>
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
        <h2 class="section-title mb-3">Past Events</h2>

        @if ($pastEvents->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <p class="text-secondary mb-0">Past events will appear here once available.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($pastEvents as $event)
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
                                <p class="small text-secondary mb-2">
                                    {{ $event->event_type ?: 'General Event' }}
                                    @if ($event->venue)
                                        • {{ $event->venue }}
                                    @endif
                                </p>
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('events.show', $event->slug) }}">View recap</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
