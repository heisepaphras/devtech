@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <div>
            <span class="kicker">Media Center</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Video Clips</h1>
        </div>
    </div>
</section>

@if ($featuredVideos->isNotEmpty())
<section class="py-5">
    <div class="container">
        <h2 class="section-title mb-3">Featured Clips</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
            @foreach ($featuredVideos as $video)
                <div class="col">
                    <article class="card border-0 shadow-sm h-100 overflow-hidden">
                        @if ($video->thumbnail_url)
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="card-img-top news-card-img">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <p class="small text-secondary mb-1">{{ $video->category ?: 'General' }}</p>
                            <h3 class="h6 text-brand mb-2">{{ $video->title }}</h3>
                            <p class="small text-secondary mb-3">
                                {{ optional($video->recorded_at)->format('M d, Y') ?: 'Date not set' }}
                                @if ($video->duration_seconds)
                                    | {{ gmdate('i:s', $video->duration_seconds) }}
                                @endif
                            </p>
                            <a class="btn btn-sm btn-outline-brand mt-auto" href="{{ route('videos.show', $video->slug) }}">View Clip</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-5 {{ $featuredVideos->isNotEmpty() ? 'soft-surface border-top' : '' }}">
    <div class="container">
        <h2 class="section-title mb-3">All Clips</h2>

        @if ($videoClips->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <p class="text-secondary mb-0">No videos published yet.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($videoClips as $video)
                    <div class="col">
                        <article class="card border-0 shadow-sm h-100 overflow-hidden">
                            @if ($video->thumbnail_url)
                                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="card-img-top news-card-img">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <p class="small text-secondary mb-1">{{ $video->category ?: 'General' }}</p>
                                <h3 class="h6 text-brand mb-2">{{ $video->title }}</h3>
                                <p class="small text-secondary mb-2">
                                    {{ optional($video->recorded_at)->format('M d, Y') ?: 'Date not set' }}
                                    @if ($video->duration_seconds)
                                        | {{ gmdate('i:s', $video->duration_seconds) }}
                                    @endif
                                </p>
                                @if ($video->description)
                                    <p class="text-secondary mb-3">{{ \Illuminate\Support\Str::limit($video->description, 110) }}</p>
                                @endif
                                <a class="btn btn-sm btn-outline-brand mt-auto" href="{{ route('videos.show', $video->slug) }}">Open Clip</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $videoClips->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
