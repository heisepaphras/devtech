@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <div>
            <span class="kicker">Academy Highlights</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Gallery</h1>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if ($galleryItems->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <h2 class="h4 mb-2">Gallery is empty</h2>
                    <p class="text-secondary mb-0">Add images from the admin panel to showcase training and match moments.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($galleryItems as $item)
                    <div class="col">
                        <article class="card border-0 shadow-sm h-100 overflow-hidden">
                            <button
                                type="button"
                                class="gallery-shot-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#galleryLightbox"
                                data-image="{{ $item->image_path ? $item->image_path : asset('images/gallery-placeholder.svg') }}"
                                data-title="{{ $item->title }}"
                                data-meta="{{ trim(($item->category ? $item->category . ' • ' : '') . (optional($item->captured_at)->format('M d, Y') ?? 'Date not set')) }}"
                                aria-label="Open {{ $item->title }}">
                                <img
                                    src="{{ $item->image_path ? $item->image_path : asset('images/gallery-placeholder.svg') }}"
                                    alt="{{ $item->title }}"
                                    class="card-img-top gallery-thumb"
                                >
                            </button>
                            <div class="card-body">
                                <h2 class="h5 mb-1 text-brand">{{ $item->title }}</h2>
                                <p class="small text-secondary mb-2">
                                    {{ $item->category ?: 'General' }}
                                    @if ($item->captured_at)
                                        • {{ $item->captured_at->format('M d, Y') }}
                                    @endif
                                </p>
                                @if ($item->description)
                                    <p class="text-secondary mb-0">{{ \Illuminate\Support\Str::limit($item->description, 120) }}</p>
                                @endif
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $galleryItems->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</section>

<div class="modal fade" id="galleryLightbox" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0 pb-0">
                <h2 class="h5 modal-title" id="galleryLightboxTitle"></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <p class="small text-secondary mb-3" id="galleryLightboxMeta"></p>
                <img src="" alt="" id="galleryLightboxImage" class="img-fluid rounded gallery-lightbox-image">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lightbox = document.getElementById('galleryLightbox');
        const lightboxImage = document.getElementById('galleryLightboxImage');
        const lightboxTitle = document.getElementById('galleryLightboxTitle');
        const lightboxMeta = document.getElementById('galleryLightboxMeta');

        lightbox?.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            if (!trigger) return;

            const image = trigger.getAttribute('data-image') || '';
            const title = trigger.getAttribute('data-title') || '';
            const meta = trigger.getAttribute('data-meta') || '';

            lightboxImage.src = image;
            lightboxImage.alt = title;
            lightboxTitle.textContent = title;
            lightboxMeta.textContent = meta;
        });
    });
</script>
@endsection
