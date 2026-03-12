@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <div>
            <span class="kicker">Academy Transfer Desk</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Transfer Market</h1>
        </div>
    </div>
</section>

@if ($featuredTransfers->isNotEmpty())
<section class="py-5">
    <div class="container">
        <h2 class="section-title mb-3">Featured Updates</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($featuredTransfers as $item)
                <div class="col">
                    <article class="card h-100 border-0 shadow-sm">
                        <img
                            src="{{ $item->player_image ? asset('storage/' . $item->player_image) : asset('images/gallery-placeholder.svg') }}"
                            alt="{{ $item->player_name }}"
                            class="card-img-top news-card-img"
                        >
                        <div class="card-body d-flex flex-column">
                            <p class="small text-secondary mb-2">{{ optional($item->announced_at)->format('M d, Y') }}</p>
                            <h3 class="h5 mb-1 text-brand">{{ $item->player_name }}</h3>
                            <p class="small text-secondary mb-2">{{ ucfirst(str_replace('-', ' ', $item->transfer_type)) }}</p>
                            <p class="fw-semibold mb-2">{{ $item->title }}</p>
                            @if ($item->summary)
                                <p class="text-secondary mb-3">{{ $item->summary }}</p>
                            @endif
                            <a class="btn btn-sm btn-outline-brand mt-auto" href="{{ route('transfer.market.show', $item->slug) }}">View Details</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-5 {{ $featuredTransfers->isNotEmpty() ? 'soft-surface border-top' : '' }}">
    <div class="container">
        <h2 class="section-title mb-3">All Transfer Updates</h2>

        @if ($transferItems->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <p class="text-secondary mb-0">No transfer updates published yet.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-lg-2 g-4">
                @foreach ($transferItems as $item)
                    <div class="col">
                        <article class="card h-100 border-0 shadow-sm">
                            <img
                                src="{{ $item->player_image ? asset('storage/' . $item->player_image) : asset('images/gallery-placeholder.svg') }}"
                                alt="{{ $item->player_name }}"
                                class="card-img-top news-card-img"
                            >
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <div>
                                        <p class="small text-secondary mb-2">{{ optional($item->announced_at)->format('M d, Y h:i A') }}</p>
                                        <h3 class="h5 mb-1 text-brand">{{ $item->player_name }}</h3>
                                        <p class="mb-0 fw-semibold">{{ $item->title }}</p>
                                    </div>
                                    <span class="badge text-bg-primary">{{ ucfirst(str_replace('-', ' ', $item->transfer_type)) }}</span>
                                </div>

                                <hr>

                                <div class="small text-secondary mb-2">
                                    <strong>From:</strong> {{ $item->from_club ?: 'N/A' }}
                                </div>
                                <div class="small text-secondary mb-2">
                                    <strong>To:</strong> {{ $item->to_club ?: 'N/A' }}
                                </div>
                                @if ($item->transfer_fee)
                                    <div class="small text-secondary mb-2"><strong>Fee:</strong> {{ $item->transfer_fee }}</div>
                                @endif
                                @if ($item->position)
                                    <div class="small text-secondary mb-2"><strong>Position:</strong> {{ $item->position }}</div>
                                @endif

                                <a class="btn btn-sm btn-outline-brand mt-2" href="{{ route('transfer.market.show', $item->slug) }}">Open Update</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $transferItems->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
