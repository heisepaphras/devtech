@extends('layouts.app')

@section('content')
<section class="hero-shell hero-enhanced py-5">
    <div class="container py-lg-4 position-relative">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <span class="kicker reveal">KINGS FOOTBALL ACADEMY, ABUJA</span>
                <h1 class="display-4 fw-bold text-white mt-2 mb-3 reveal">
                    Building elite football talent with discipline, identity, and modern coaching.
                </h1>
                <p class="hero-copy mb-4 reveal">
                    Abuja Kings Football Academy develops players for local and international pathways through structured training,
                    tactical intelligence, character building, and consistent match exposure.
                </p>
                <div class="d-flex flex-wrap gap-2 reveal">
                    <a class="btn btn-brand btn-lg" href="{{ route('register') }}">Start Registration</a>
                    <a class="btn btn-outline-light btn-lg" href="{{ route('scouting.trials') }}">View Trials</a>
                </div>
                <div class="hero-metrics mt-4 reveal">
                    <span class="metric-pill">Youth Development</span>
                    <span class="metric-pill">Scouting Pathway</span>
                    <span class="metric-pill">Character + Leadership</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-visual reveal">
                    <img
                        src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=1200&q=80"
                        alt="Football training session"
                        class="hero-main-image"
                    >
                    <div class="hero-floating-card">
                        <span class="small text-uppercase fw-semibold text-secondary">Next Open Trials</span>
                        <p class="h5 mb-1 mt-1 text-brand">Saturday 9:00 AM</p>
                        <p class="small mb-0 text-secondary">Abuja Kings Training Ground</p>
                    </div>
                    <div class="hero-thumb-grid">
                        <img src="https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?auto=format&fit=crop&w=700&q=80" alt="Academy football match">
                        <img src="https://images.unsplash.com/photo-1522778119026-d647f0596c20?auto=format&fit=crop&w=700&q=80" alt="Coaching and tactical briefing">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4">
            <div>
                <span class="kicker kicker-dark">Academy In Motion</span>
                <h2 class="section-title mb-1 mt-2">A Visual Look At Kings</h2>
                <p class="text-secondary mb-0">Training intensity, match temperament, and player growth in one pathway.</p>
            </div>
            <a href="{{ route('gallery') }}" class="btn btn-outline-brand">View Full Gallery</a>
        </div>

        <div class="row g-4" data-stagger>
            <div class="col-lg-4">
                <article class="image-story card border-0 shadow-sm h-100 reveal">
                    <img src="https://images.unsplash.com/photo-1771257807779-a72e74deaa11?auto=format&fit=crop&w=900&q=80" alt="Player with football in training" class="story-image">
                    <div class="card-body">
                        <h3 class="h6 text-brand mb-1">Technical Sessions</h3>
                        <p class="small text-secondary mb-0">Ball mastery, first touch, scanning, and decision speed.</p>
                    </div>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="image-story card border-0 shadow-sm h-100 reveal">
                    <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=900&q=80" alt="Football match moment" class="story-image">
                    <div class="card-body">
                        <h3 class="h6 text-brand mb-1">Competitive Fixtures</h3>
                        <p class="small text-secondary mb-0">Structured match exposure to test tactical and mental growth.</p>
                    </div>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="image-story card border-0 shadow-sm h-100 reveal">
                    <img src="https://images.unsplash.com/photo-1518604666860-9ed391f76460?auto=format&fit=crop&w=900&q=80" alt="Coach mentoring player" class="story-image">
                    <div class="card-body">
                        <h3 class="h6 text-brand mb-1">Mentorship & Discipline</h3>
                        <p class="small text-secondary mb-0">Building leaders on and off the pitch through mentorship.</p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="py-5 soft-surface border-top">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4">
            <div>
                <span class="kicker kicker-dark">Latest Updates</span>
                <h2 class="section-title mb-1 mt-2">News</h2>
                <p class="text-secondary mb-0">Recent stories from Abuja Kings Football Academy.</p>
            </div>
            <a href="{{ route('news') }}" class="btn btn-outline-brand">More News</a>
        </div>

        @if ($newsItems->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <p class="text-secondary mb-0">No news available yet.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3" data-stagger>
            @foreach ($newsItems as $item)
                <div class="col">
                    <article class="card module-item module-item-rich h-100 border-0 shadow-sm reveal overflow-hidden">
                        @if ($item->cover_image)
                            <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}" class="news-card-img">
                        @endif
                        <div class="card-body d-flex flex-column gap-2">
                            <span class="small text-secondary">{{ optional($item->published_at)->format('M d, Y') }}</span>
                            <h3 class="h6 text-brand mb-0">{{ $item->title }}</h3>
                            <p class="small text-secondary mb-0">{{ \Illuminate\Support\Str::limit($item->excerpt, 110) }}</p>
                            <a href="{{ route('news.show', $item->slug) }}" class="btn btn-sm btn-outline-brand mt-2 align-self-start">Read Story</a>
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
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4">
            <div>
                <span class="kicker kicker-dark">Media</span>
                <h2 class="section-title mb-1 mt-2">Videos & Live Score</h2>
                <p class="text-secondary mb-0">See training clips and real-time match activity.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('videos') }}" class="btn btn-outline-brand">All Videos</a>
                <a href="{{ route('live.score') }}" class="btn btn-outline-brand">All Scores</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                @if ($videoItems->isEmpty())
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <p class="text-secondary mb-0">No videos available yet.</p>
                        </div>
                    </div>
                @else
                    <div class="row row-cols-1 row-cols-md-2 g-3" data-stagger>
                        @foreach ($videoItems as $video)
                            <div class="col">
                                <article class="card border-0 shadow-sm h-100 reveal overflow-hidden">
                                    @if ($video->thumbnail_url)
                                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="news-card-img">
                                    @endif
                                    <div class="card-body">
                                        <p class="small text-secondary mb-1">{{ $video->category ?: 'General' }}</p>
                                        <h3 class="h6 text-brand mb-2">{{ $video->title }}</h3>
                                        <a class="btn btn-sm btn-outline-brand" href="{{ route('videos.show', $video->slug) }}">Watch</a>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h3 class="h5 text-brand mb-3">Live Score Snapshot</h3>
                        @if ($liveScores->isEmpty())
                            <p class="text-secondary mb-0">No live or upcoming matches right now.</p>
                        @else
                            <div class="d-flex flex-column gap-3">
                                @foreach ($liveScores as $score)
                                    <a href="{{ route('live.score.show', $score->slug) }}" class="text-decoration-none">
                                        <div class="p-3 border rounded-3 score-mini">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="small text-secondary">{{ ucfirst($score->match_status) }}</span>
                                                <span class="small text-secondary">{{ optional($score->kickoff_at)->format('M d, h:i A') }}</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <img src="{{ $score->home_logo ? asset('storage/' . $score->home_logo) : asset('images/kings-logo.svg') }}" alt="{{ $score->home_team }}" class="img-thumbnail p-1" style="width: 30px; height: 30px; object-fit: cover;">
                                                <img src="{{ $score->away_logo ? asset('storage/' . $score->away_logo) : asset('images/kings-logo.svg') }}" alt="{{ $score->away_team }}" class="img-thumbnail p-1" style="width: 30px; height: 30px; object-fit: cover;">
                                            </div>
                                            <p class="fw-semibold text-brand mb-1">{{ $score->home_team }} vs {{ $score->away_team }}</p>
                                            <p class="mb-0">{{ $score->home_score ?? '-' }} - {{ $score->away_score ?? '-' }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 soft-surface border-top">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4">
            <div>
                <span class="kicker kicker-dark">Highlights</span>
                <h2 class="section-title mb-1 mt-2">Gallery & Events</h2>
                <p class="text-secondary mb-0">Visual highlights and upcoming academy activities.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('gallery') }}" class="btn btn-outline-brand">View Gallery</a>
                <a href="{{ route('events') }}" class="btn btn-outline-brand">View Events</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                @if ($galleryItems->isEmpty())
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <p class="text-secondary mb-0">Gallery items will appear here.</p>
                        </div>
                    </div>
                @else
                    <div class="row row-cols-2 row-cols-md-3 g-3" data-stagger>
                        @foreach ($galleryItems as $item)
                            <div class="col">
                                <article class="card border-0 shadow-sm h-100 reveal overflow-hidden">
                                    <img
                                        src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('images/gallery-placeholder.svg') }}"
                                        alt="{{ $item->title }}"
                                        class="story-image"
                                    >
                                </article>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h3 class="h5 text-brand mb-3">Upcoming Events</h3>
                        @if ($eventItems->isEmpty())
                            <p class="text-secondary mb-0">No upcoming events published yet.</p>
                        @else
                            <div class="d-flex flex-column gap-3">
                                @foreach ($eventItems as $event)
                                    <a href="{{ route('events.show', $event->slug) }}" class="text-decoration-none">
                                        <div class="p-3 border rounded-3 score-mini">
                                            <img
                                                src="{{ $event->featured_image ? asset('storage/' . $event->featured_image) : asset('images/gallery-placeholder.svg') }}"
                                                alt="{{ $event->title }}"
                                                class="img-fluid rounded mb-2"
                                                style="height: 120px; width: 100%; object-fit: cover;"
                                            >
                                            <p class="small text-secondary mb-1">{{ optional($event->starts_at)->format('M d, Y h:i A') }}</p>
                                            <p class="fw-semibold text-brand mb-1">{{ $event->title }}</p>
                                            <p class="small text-secondary mb-0">{{ $event->venue ?: 'Venue not set' }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
