@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Milestone Ready</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">{{ $pageTitle }}</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                <p class="mb-2">{{ $description }}</p>
                <p class="text-secondary mb-4">This section route and base template are in place. Full functionality will be implemented in its dedicated milestone.</p>
                <a class="btn btn-brand" href="{{ route('home') }}">Back to Home</a>
            </div>
        </div>
    </div>
</section>
@endsection
