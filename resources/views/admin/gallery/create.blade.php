@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Admin</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">Create Gallery Section</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                            @csrf

                            @if ($errors->any())
                                <div class="col-12">
                                    <div class="alert alert-danger mb-0">
                                        <strong>There are validation errors:</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Section Name *</label>
                                <input type="text" name="section_name" value="{{ old('section_name') }}" class="form-control" required placeholder="Training Week 1, Tournament Day...">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Section Slug (optional)</label>
                                <input type="text" name="section_slug" value="{{ old('section_slug') }}" class="form-control" placeholder="training-week-1">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Section Description</label>
                                <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Captured At</label>
                                <input type="date" name="captured_at" value="{{ old('captured_at') }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Sort Order Start</label>
                                <input type="number" min="0" max="9999" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Publication</label>
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="isPublished" {{ old('is_published', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isPublished">Mark all images as published</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Drop Images *</label>
                                <div
                                    class="gallery-dropzone rounded p-4 text-center"
                                    data-gallery-dropzone
                                    data-target-input="galleryImagesInput"
                                    data-preview-target="galleryImagesPreview"
                                >
                                    <i class="fa-solid fa-cloud-arrow-up fs-3 mb-2 d-block"></i>
                                    <p class="fw-semibold mb-1">Drag and drop images here</p>
                                    <p class="small text-secondary mb-2">or click to browse files</p>
                                    <span class="badge text-bg-primary">First uploaded image becomes featured</span>
                                </div>
                                <input id="galleryImagesInput" type="file" name="images[]" accept="image/*" multiple required class="form-control mt-3">
                                <div id="galleryImagesPreview" class="row row-cols-2 row-cols-md-4 g-3 mt-1"></div>
                            </div>

                            <div class="col-12 d-flex gap-2 flex-wrap">
                                <button class="btn btn-brand" type="submit">Create Section</button>
                                <a class="btn btn-outline-secondary" href="{{ route('admin.gallery.index') }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
