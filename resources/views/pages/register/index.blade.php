@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <div>
            <span class="kicker">Academy Intake</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Register Now</h1>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="h5 section-title mb-3">Player Registration Form</h2>

                        <form action="{{ route('register.store') }}" method="POST" class="row g-3">
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

                            <div class="col-md-7">
                                <label class="form-label fw-semibold">Full Name *</label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control" required>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Date of Birth</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Parent/Guardian Name</label>
                                <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Phone *</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Address</label>
                                <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Age Group</label>
                                <select name="age_group" class="form-select">
                                    <option value="">Select age group</option>
                                    @foreach ($ageGroups as $group)
                                        <option value="{{ $group }}" {{ old('age_group') === $group ? 'selected' : '' }}>{{ $group }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Preferred Position</label>
                                <input type="text" name="preferred_position" value="{{ old('preferred_position') }}" class="form-control" placeholder="Forward, Midfielder...">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Preferred Foot</label>
                                <select name="preferred_foot" class="form-select">
                                    <option value="">Select foot</option>
                                    <option value="Right" {{ old('preferred_foot') === 'Right' ? 'selected' : '' }}>Right</option>
                                    <option value="Left" {{ old('preferred_foot') === 'Left' ? 'selected' : '' }}>Left</option>
                                    <option value="Both" {{ old('preferred_foot') === 'Both' ? 'selected' : '' }}>Both</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Football Experience Level</label>
                                <input type="text" name="experience_level" value="{{ old('experience_level') }}" class="form-control" placeholder="Beginner, Intermediate, Competitive...">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Medical Notes</label>
                                <textarea name="medical_notes" rows="3" maxlength="2000" class="form-control">{{ old('medical_notes') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Additional Notes</label>
                                <textarea name="additional_notes" rows="4" maxlength="2000" class="form-control">{{ old('additional_notes') }}</textarea>
                            </div>

                            <div class="col-12 d-flex gap-2 flex-wrap">
                                <button class="btn btn-brand" type="submit">Submit Registration</button>
                                <a class="btn btn-outline-secondary" href="{{ route('home') }}">Back to Home</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h2 class="h5 section-title mb-3">Registration Notes</h2>
                        <ul class="small mb-3">
                            <li>Fill in accurate player and guardian details.</li>
                            <li>Applications are reviewed by the academy team.</li>
                            <li>Selected applicants will be contacted for trials.</li>
                        </ul>
                        <p class="small text-secondary mb-2">Need quick help?</p>
                        <a class="btn btn-outline-brand btn-sm" href="https://wa.me/2348033279762" target="_blank" rel="noopener">Contact on WhatsApp</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
