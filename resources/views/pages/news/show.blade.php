@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Academy Updates</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">{{ $news->title }}</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <article class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        <p class="small text-secondary mb-3">Published {{ optional($news->published_at)->format('M d, Y \a\t h:i A') }}</p>

                        @if ($news->cover_image)
                            <img src="{{ $news->cover_image }}" alt="{{ $news->title }}" class="img-fluid rounded mb-4 news-detail-img">
                        @endif

                        <p class="fw-semibold text-brand mb-3">{{ $news->excerpt }}</p>
                        <div class="article-content">{!! nl2br(e($news->content)) !!}</div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

@if ($relatedNews->isNotEmpty())
<section class="py-5 soft-surface">
    <div class="container">
        <h2 class="section-title mb-4">Related News</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($relatedNews as $item)
                <div class="col">
                    <article class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="small text-secondary mb-2">{{ optional($item->published_at)->format('M d, Y') }}</p>
                            <h3 class="h5 mb-2">
                                <a href="{{ route('news.show', $item->slug) }}" class="text-brand text-decoration-none">{{ $item->title }}</a>
                            </h3>
                            <p class="mb-0 text-secondary">{{ $item->excerpt }}</p>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
