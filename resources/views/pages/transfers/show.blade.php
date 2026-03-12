@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Transfer Market</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-1">{{ $transferItem->player_name }}</h1>
        <p class="text-light mb-0">{{ $transferItem->title }}</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <article class="card border-0 shadow-sm h-100">
                    <img
                        src="{{ $transferItem->player_image ? asset('storage/' . $transferItem->player_image) : asset('images/gallery-placeholder.svg') }}"
                        alt="{{ $transferItem->player_name }}"
                        class="card-img-top news-card-img"
                    >
                    <div class="card-body p-4 p-lg-5">
                        @if ($transferItem->summary)
                            <p class="fw-semibold text-brand mb-3">{{ $transferItem->summary }}</p>
                        @endif

                        @if ($transferItem->details)
                            <div class="article-content mb-4">{!! nl2br(e($transferItem->details)) !!}</div>
                        @else
                            <p class="text-secondary mb-4">No additional details were provided for this update.</p>
                        @endif

                        <a class="btn btn-outline-brand" href="{{ route('transfer.market') }}">Back to Transfer Market</a>
                    </div>
                </article>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h2 class="h5 section-title mb-3">Transfer Details</h2>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2"><strong>Type:</strong> {{ ucfirst(str_replace('-', ' ', $transferItem->transfer_type)) }}</li>
                            <li class="mb-2"><strong>Position:</strong> {{ $transferItem->position ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>From:</strong> {{ $transferItem->from_club ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>To:</strong> {{ $transferItem->to_club ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Fee:</strong> {{ $transferItem->transfer_fee ?: 'Undisclosed' }}</li>
                            <li class="mb-2"><strong>Announced:</strong> {{ optional($transferItem->announced_at)->format('M d, Y h:i A') }}</li>
                            <li class="mb-0"><strong>Contract Until:</strong> {{ optional($transferItem->contract_until)->format('M d, Y') ?: 'N/A' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if ($relatedTransfers->isNotEmpty())
<section class="py-5 soft-surface">
    <div class="container">
        <h2 class="section-title mb-4">Related Transfer Updates</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($relatedTransfers as $item)
                <div class="col">
                    <article class="card border-0 shadow-sm h-100">
                        <img
                            src="{{ $item->player_image ? asset('storage/' . $item->player_image) : asset('images/gallery-placeholder.svg') }}"
                            alt="{{ $item->player_name }}"
                            class="card-img-top news-card-img"
                        >
                        <div class="card-body">
                            <p class="small text-secondary mb-2">{{ optional($item->announced_at)->format('M d, Y') }}</p>
                            <h3 class="h6 mb-1 text-brand">{{ $item->player_name }}</h3>
                            <p class="small text-secondary mb-2">{{ ucfirst(str_replace('-', ' ', $item->transfer_type)) }}</p>
                            <p class="mb-3">{{ $item->title }}</p>
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('transfer.market.show', $item->slug) }}">View</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
