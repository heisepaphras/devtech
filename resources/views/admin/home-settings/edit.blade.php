@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <span class="kicker">Admin</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Home Page Settings</h1>
        </div>
        <a class="btn btn-outline-light" href="{{ route('home') }}" target="_blank">View Home Page</a>
    </div>
</section>

<section class="py-5">
    <div class="container">

        @if (session('status'))
            <div class="alert alert-success mb-4">{{ session('status') }}</div>
        @endif

        <form action="{{ route('admin.home-settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ── HERO SECTION ─────────────────────────────────────────── --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h2 class="h5 mb-0 fw-semibold">Hero Section — Texts</h2>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Kicker (small label above title)</label>
                            <input type="text" name="hero_kicker" value="{{ old('hero_kicker', $settings->hero_kicker) }}" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Heading</label>
                            <input type="text" name="hero_title" value="{{ old('hero_title', $settings->hero_title) }}" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Paragraph / Copy</label>
                            <textarea name="hero_copy" rows="3" class="form-control" required>{{ old('hero_copy', $settings->hero_copy) }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Metric Pill 1</label>
                            <input type="text" name="hero_metric_1" value="{{ old('hero_metric_1', $settings->hero_metric_1) }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Metric Pill 2</label>
                            <input type="text" name="hero_metric_2" value="{{ old('hero_metric_2', $settings->hero_metric_2) }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Metric Pill 3</label>
                            <input type="text" name="hero_metric_3" value="{{ old('hero_metric_3', $settings->hero_metric_3) }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Trials Card — Label</label>
                            <input type="text" name="hero_trials_label" value="{{ old('hero_trials_label', $settings->hero_trials_label) }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Trials Card — Date / Time</label>
                            <input type="text" name="hero_trials_date" value="{{ old('hero_trials_date', $settings->hero_trials_date) }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Trials Card — Location</label>
                            <input type="text" name="hero_trials_location" value="{{ old('hero_trials_location', $settings->hero_trials_location) }}" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── HERO IMAGES ───────────────────────────────────────────── --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h2 class="h5 mb-0 fw-semibold">Hero Section — Images</h2>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Main Hero Image</label>
                            @if ($settings->hero_main_image)
                                <div class="mb-2">
                                    <img src="{{ $settings->hero_main_image }}" alt="Main hero" class="img-fluid rounded" style="max-height:160px; object-fit:cover; width:100%;">
                                </div>
                            @endif
                            <input type="file" name="hero_main_image" accept="image/*" class="form-control">
                            <div class="form-text">Recommended: 1200×800px. Leave blank to keep current.</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Thumbnail Image 1</label>
                            @if ($settings->hero_thumb_1)
                                <div class="mb-2">
                                    <img src="{{ $settings->hero_thumb_1 }}" alt="Thumbnail 1" class="img-fluid rounded" style="max-height:160px; object-fit:cover; width:100%;">
                                </div>
                            @endif
                            <input type="file" name="hero_thumb_1" accept="image/*" class="form-control">
                            <div class="form-text">Recommended: 700×500px. Leave blank to keep current.</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Thumbnail Image 2</label>
                            @if ($settings->hero_thumb_2)
                                <div class="mb-2">
                                    <img src="{{ $settings->hero_thumb_2 }}" alt="Thumbnail 2" class="img-fluid rounded" style="max-height:160px; object-fit:cover; width:100%;">
                                </div>
                            @endif
                            <input type="file" name="hero_thumb_2" accept="image/*" class="form-control">
                            <div class="form-text">Recommended: 700×500px. Leave blank to keep current.</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── VISUAL SECTION ────────────────────────────────────────── --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h2 class="h5 mb-0 fw-semibold">"Academy In Motion" Section — Header</h2>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kicker</label>
                            <input type="text" name="visual_kicker" value="{{ old('visual_kicker', $settings->visual_kicker) }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="visual_title" value="{{ old('visual_title', $settings->visual_title) }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Description</label>
                            <input type="text" name="visual_description" value="{{ old('visual_description', $settings->visual_description) }}" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── VISUAL CARDS ──────────────────────────────────────────── --}}
            @foreach ([1, 2, 3] as $n)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h2 class="h5 mb-0 fw-semibold">Visual Card {{ $n }}</h2>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Image</label>
                            @if ($settings->{"visual_card_{$n}_image"})
                                <div class="mb-2">
                                    <img src="{{ $settings->{"visual_card_{$n}_image"} }}" alt="Card {{ $n }}" class="img-fluid rounded" style="max-height:160px; object-fit:cover; width:100%;">
                                </div>
                            @endif
                            <input type="file" name="visual_card_{{ $n }}_image" accept="image/*" class="form-control">
                            <div class="form-text">Recommended: 900×600px. Leave blank to keep current.</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="visual_card_{{ $n }}_title" value="{{ old("visual_card_{$n}_title", $settings->{"visual_card_{$n}_title"}) }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Description</label>
                            <input type="text" name="visual_card_{{ $n }}_description" value="{{ old("visual_card_{$n}_description", $settings->{"visual_card_{$n}_description"}) }}" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="d-flex gap-2">
                <button class="btn btn-brand btn-lg" type="submit">Save Settings</button>
                <a class="btn btn-outline-secondary btn-lg" href="{{ route('home') }}" target="_blank">Preview Home Page</a>
            </div>
        </form>
    </div>
</section>
@endsection
