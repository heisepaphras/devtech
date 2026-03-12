@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Program Detail</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">{{ $program->title }}</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <article class="card border-0 shadow-sm">
                    <img
                        src="{{ $program->featured_image ? asset('storage/' . $program->featured_image) : asset('images/gallery-placeholder.svg') }}"
                        alt="{{ $program->title }}"
                        class="card-img-top news-card-img"
                    >
                    <div class="card-body p-4 p-lg-5">
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="event-meta-box p-3 rounded">
                                    <small class="text-secondary d-block">Age Group</small>
                                    <strong>{{ $program->age_group ?: 'All age groups' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="event-meta-box p-3 rounded">
                                    <small class="text-secondary d-block">Duration</small>
                                    <strong>{{ $program->duration_weeks ? $program->duration_weeks . ' weeks' : 'Flexible' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="event-meta-box p-3 rounded">
                                    <small class="text-secondary d-block">Capacity</small>
                                    <strong>{{ $program->capacity ? $program->capacity . ' players' : 'Open' }}</strong>
                                </div>
                            </div>
                        </div>

                        @if ($program->description)
                            <p class="mb-4">{{ $program->description }}</p>
                        @endif

                        @if ($program->highlights)
                            <div class="mb-4">
                                <h2 class="h5 text-brand mb-2">Highlights</h2>
                                <div class="article-content">{!! nl2br(e($program->highlights)) !!}</div>
                            </div>
                        @endif

                        @if ($program->requirements)
                            <div class="mb-4">
                                <h2 class="h5 text-brand mb-2">Requirements</h2>
                                <div class="article-content">{!! nl2br(e($program->requirements)) !!}</div>
                            </div>
                        @endif

                        <ul class="small text-secondary ps-3 mb-4">
                            @if ($program->schedule)
                                <li><strong>Schedule:</strong> {{ $program->schedule }}</li>
                            @endif
                            @if ($program->fee)
                                <li><strong>Fee:</strong> {{ $program->fee }}</li>
                            @endif
                        </ul>

                        <div class="d-flex gap-2 flex-wrap">
                            <a class="btn btn-outline-brand" href="{{ route('scouting.trials') }}">Back to Programs</a>
                            @if ($program->registration_link)
                                <a class="btn btn-brand" href="{{ $program->registration_link }}" target="_blank" rel="noopener">Open Registration</a>
                            @else
                                <a class="btn btn-brand" href="{{ route('register') }}">Register Interest</a>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

@if ($relatedPrograms->isNotEmpty())
<section class="py-5 soft-surface">
    <div class="container">
        <h2 class="section-title mb-3">Related Programs</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($relatedPrograms as $item)
                <div class="col">
                    <article class="card h-100 border-0 shadow-sm">
                        <img
                            src="{{ $item->featured_image ? asset('storage/' . $item->featured_image) : asset('images/gallery-placeholder.svg') }}"
                            alt="{{ $item->title }}"
                            class="card-img-top news-card-img"
                        >
                        <div class="card-body">
                            <h3 class="h6 text-brand mb-2">{{ $item->title }}</h3>
                            <p class="small text-secondary mb-3">{{ $item->age_group ?: 'All age groups' }}</p>
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('scouting.trials.show', $item->slug) }}">Details</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
