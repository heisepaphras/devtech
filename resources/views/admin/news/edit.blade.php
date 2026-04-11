@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Admin</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">Edit News</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        @include('admin.news.partials.form', [
                            'action' => route('admin.news.update', $news),
                            'method' => 'PUT',
                            'news' => $news,
                            'submitLabel' => 'Update Article',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
