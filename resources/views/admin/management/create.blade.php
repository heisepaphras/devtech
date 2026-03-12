@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Admin</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">Create Management Member</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                @include('admin.management.partials.form', [
                    'action' => route('admin.management.store'),
                    'method' => 'POST',
                    'submitLabel' => 'Create Member',
                    'managementMember' => $managementMember,
                ])
            </div>
        </div>
    </div>
</section>
@endsection
