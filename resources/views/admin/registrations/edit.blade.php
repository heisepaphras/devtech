@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Admin</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">Review Registration</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        @include('admin.registrations.partials.form', [
                            'application' => $application,
                            'statuses' => $statuses,
                        ])
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h5 section-title mb-3">Application Details</h2>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2"><strong>Reference:</strong> {{ $application->reference_code }}</li>
                            <li class="mb-2"><strong>Applicant:</strong> {{ $application->full_name }}</li>
                            <li class="mb-2"><strong>DOB:</strong> {{ optional($application->date_of_birth)->format('M d, Y') ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Guardian:</strong> {{ $application->guardian_name ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Phone:</strong> {{ $application->phone }}</li>
                            <li class="mb-2"><strong>Email:</strong> {{ $application->email ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Age Group:</strong> {{ $application->age_group ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Position:</strong> {{ $application->preferred_position ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Foot:</strong> {{ $application->preferred_foot ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Experience:</strong> {{ $application->experience_level ?: 'N/A' }}</li>
                            <li class="mb-2"><strong>Submitted:</strong> {{ optional($application->submitted_at)->format('M d, Y h:i A') }}</li>
                            <li class="mb-0"><strong>Contacted:</strong> {{ $application->contacted_at ? optional($application->contacted_at)->format('M d, Y h:i A') : 'No' }}</li>
                        </ul>

                        @if ($application->medical_notes)
                            <hr>
                            <h3 class="h6 text-brand">Medical Notes</h3>
                            <p class="small mb-0">{{ $application->medical_notes }}</p>
                        @endif

                        @if ($application->additional_notes)
                            <hr>
                            <h3 class="h6 text-brand">Additional Notes</h3>
                            <p class="small mb-0">{{ $application->additional_notes }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
