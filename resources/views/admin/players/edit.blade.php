@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Admin</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">Edit Player Profile</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                @include('admin.players.partials.form', [
                    'action' => route('admin.player-profiles.update', $playerProfile),
                    'method' => 'PUT',
                    'submitLabel' => 'Save Changes',
                    'playerProfile' => $playerProfile,
                ])
            </div>
        </div>
    </div>
</section>
@endsection
