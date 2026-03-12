@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Video Clips</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-1">{{ $videoClip->title }}</h1>
        <p class="text-light mb-0">{{ $videoClip->category ?: 'General' }}</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 p-lg-5">
                        @if ($videoClip->thumbnail_url)
                            <img src="{{ $videoClip->thumbnail_url }}" alt="{{ $videoClip->title }}" class="img-fluid rounded mb-4 news-detail-img">
                        @endif

                        @if ($videoClip->description)
                            <div class="article-content mb-4">{!! nl2br(e($videoClip->description)) !!}</div>
                        @endif

                        <div class="d-flex gap-2 flex-wrap">
                            <a class="btn btn-brand" href="{{ $videoClip->source_url }}" target="_blank" rel="noopener">Watch Clip</a>
                            <a class="btn btn-outline-brand" href="{{ route('videos') }}">Back to Video Clips</a>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h2 class="h5 section-title mb-3">Clip Details</h2>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2"><strong>Category:</strong> {{ $videoClip->category ?: 'General' }}</li>
                            <li class="mb-2"><strong>Recorded:</strong> {{ optional($videoClip->recorded_at)->format('M d, Y') ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Duration:</strong> {{ $videoClip->duration_seconds ? gmdate('i:s', $videoClip->duration_seconds) : 'N/A' }}</li>
                            <li class="mb-0"><strong>Published:</strong> {{ optional($videoClip->created_at)->format('M d, Y') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if ($relatedVideos->isNotEmpty())
<section class="py-5 soft-surface">
    <div class="container">
        <h2 class="section-title mb-4">Related Clips</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
            @foreach ($relatedVideos as $item)
                <div class="col">
                    <article class="card border-0 shadow-sm h-100 overflow-hidden">
                        @if ($item->thumbnail_url)
                            <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="card-img-top news-card-img">
                        @endif
                        <div class="card-body">
                            <h3 class="h6 text-brand mb-2">{{ $item->title }}</h3>
                            <p class="small text-secondary mb-3">{{ optional($item->recorded_at)->format('M d, Y') ?: 'Date not set' }}</p>
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('videos.show', $item->slug) }}">View</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
