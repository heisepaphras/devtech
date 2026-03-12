@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <div>
            <span class="kicker">Development Pathways</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Scouting and Trials Programs</h1>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if ($programs->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <p class="text-secondary mb-0">No programs published yet.</p>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($programs as $program)
                    <div class="col">
                        <article class="card h-100 border-0 shadow-sm">
                            <img
                                src="{{ $program->featured_image ? asset('storage/' . $program->featured_image) : asset('images/gallery-placeholder.svg') }}"
                                alt="{{ $program->title }}"
                                class="card-img-top news-card-img"
                            >
                            <div class="card-body d-flex flex-column">
                                @if ($program->is_featured)
                                    <span class="badge text-bg-primary align-self-start mb-2">Featured</span>
                                @endif
                                <h2 class="h5 text-brand mb-2">{{ $program->title }}</h2>

                                <p class="small text-secondary mb-2">
                                    {{ $program->age_group ?: 'All age groups' }}
                                    @if ($program->duration_weeks)
                                        • {{ $program->duration_weeks }} weeks
                                    @endif
                                </p>

                                @if ($program->description)
                                    <p class="text-secondary mb-3">{{ \Illuminate\Support\Str::limit($program->description, 130) }}</p>
                                @endif

                                <ul class="small text-secondary ps-3 mb-3">
                                    @if ($program->schedule)
                                        <li><strong>Schedule:</strong> {{ $program->schedule }}</li>
                                    @endif
                                    @if ($program->capacity)
                                        <li><strong>Capacity:</strong> {{ $program->capacity }} players</li>
                                    @endif
                                    @if ($program->fee)
                                        <li><strong>Fee:</strong> {{ $program->fee }}</li>
                                    @endif
                                </ul>

                                <div class="mt-auto d-flex gap-2 flex-wrap">
                                    <a class="btn btn-sm btn-outline-brand" href="{{ route('scouting.trials.show', $program->slug) }}">Details</a>
                                    @if ($program->registration_link)
                                        <a class="btn btn-sm btn-brand" href="{{ $program->registration_link }}" target="_blank" rel="noopener">Register</a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
