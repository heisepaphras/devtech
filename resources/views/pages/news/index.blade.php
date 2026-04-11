@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Academy Updates</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">Latest News</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <p class="text-secondary mb-4">Recent development stories from Abuja Kings Football Academy.</p>

        @if ($newsItems->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <h2 class="h4 mb-2">No news published yet</h2>
                    <p class="text-secondary mb-0">Publish your first article from the admin panel to populate this page.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($newsItems as $item)
                    <div class="col">
                        <article class="card border-0 shadow-sm h-100 overflow-hidden">
                            @if ($item->cover_image)
                                <a href="{{ route('news.show', $item->slug) }}">
                                    <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}" class="card-img-top news-card-img">
                                </a>
                            @endif
                            <div class="card-body">
                                <p class="small text-secondary mb-2">{{ optional($item->published_at)->format('M d, Y') }}</p>
                                <h2 class="h5 mb-2">
                                    <a href="{{ route('news.show', $item->slug) }}" class="text-brand text-decoration-none">{{ $item->title }}</a>
                                </h2>
                                <p class="mb-0 text-secondary">{{ $item->excerpt }}</p>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $newsItems->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
