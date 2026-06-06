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
        @if (session('status') && !session('ref_code'))
            <div class="alert alert-success mb-4">{{ session('status') }}</div>
        @endif

        <div class="row g-4 justify-content-center">
            @if (session('ref_code'))
                <div class="col-lg-9">
                    <div class="card border-0 shadow-sm text-center p-4 p-md-5 module-item">
                        <div class="card-body">
                            <div class="success-icon mb-4">
                                <i class="fa-solid fa-circle-check text-success display-4"></i>
                            </div>
                            <span class="kicker kicker-dark mb-2">Registration Received</span>
                            <h2 class="h3 text-brand fw-bold mb-3">Pre-Registration Successful!</h2>
                            <p class="text-secondary mb-4 mx-auto" style="max-width: 600px;">
                                Thank you for registering with Abuja Kings Football Academy. Your application has been logged and a unique reference code has been generated.
                            </p>

                            <!-- Reference Code Box -->
                            <div class="p-3 border border-warning-subtle rounded-3 mb-5 d-inline-block px-5 score-mini" style="background: rgba(216, 164, 58, 0.05);">
                                <span class="small text-uppercase text-secondary d-block fw-semibold mb-1">Your Application Reference</span>
                                <strong class="fs-4 text-brand font-monospace">{{ session('ref_code') }}</strong>
                            </div>

                            <hr class="my-5 border-warning-subtle opacity-25">

                            <!-- Payment Options -->
                            <h3 class="h5 text-brand fw-bold mb-3">Complete Your Screening Registration</h3>
                            <p class="text-secondary mb-4 mx-auto" style="max-width: 620px;">
                                To complete your registration and schedule a physical trial screening, a non-refundable fee of <strong>20,000 NGN</strong> is required. Please choose your preferred payment option below:
                            </p>

                            <div class="row g-4 text-start justify-content-center">
                                <!-- Pay Online -->
                                <div class="col-md-6">
                                    <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between score-mini bg-white">
                                        <div>
                                            <h4 class="h6 text-brand fw-bold mb-3"><i class="fa-solid fa-credit-card me-2 text-warning"></i>Pay Online (Paystack)</h4>
                                            <p class="small text-secondary mb-4">
                                                Pay securely online using your debit card, bank transfer, USSD, or mobile money via Paystack.
                                            </p>
                                        </div>
                                        <a href="{{ config('services.paystack.payment_url') }}" target="_blank" rel="noopener" class="btn btn-brand w-100 py-2.5">
                                            <i class="fa-solid fa-wallet me-2"></i>Pay Online Now
                                        </a>
                                    </div>
                                </div>

                                <!-- Bank Transfer -->
                                <div class="col-md-6">
                                    <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between score-mini bg-white">
                                        <div>
                                            <h4 class="h6 text-brand fw-bold mb-3"><i class="fa-solid fa-building-columns me-2 text-warning"></i>Direct Bank Transfer</h4>
                                            <p class="small text-secondary mb-4">
                                                Transfer directly to our corporate bank account:
                                            </p>
                                            <ul class="list-unstyled small text-secondary mb-0">
                                                <li class="mb-1"><strong>Bank:</strong> First Bank PLC</li>
                                                <li class="mb-1"><strong>Account Name:</strong> Abuja Kings Football Academy</li>
                                                <li><strong>Account Number:</strong> <span class="fw-bold text-brand fs-6">2048087728</span></li>
                                            </ul>
                                        </div>
                                        <div class="small text-muted text-center pt-3 border-top mt-3">
                                            <i class="fa-solid fa-info-circle me-1"></i>Please use your reference code as transfer narration.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-5 border-warning-subtle opacity-25">

                            <!-- Submit Proof on WhatsApp -->
                            <div class="p-4 border border-warning-subtle rounded-3 text-start bg-warning-subtle" style="background: rgba(216, 164, 58, 0.05);">
                                <h4 class="h6 text-brand fw-bold mb-2"><i class="fa-brands fa-whatsapp me-2 text-success fs-5"></i>Already Paid? Submit Proof</h4>
                                <p class="small text-secondary mb-4">
                                    Once payment is made (online or direct transfer), send your proof of payment via WhatsApp to schedule your screening session.
                                </p>
                                <a href="https://wa.me/2348033279762?text={{ urlencode('Hello, I have completed payment for my pre-registration application (Ref: ' . session('ref_code') . '). Here is my proof of payment.') }}" target="_blank" rel="noopener" class="btn btn-outline-brand py-2.5">
                                    <i class="fa-brands fa-whatsapp me-2"></i>Send Proof on WhatsApp
                                </a>
                            </div>

                            <div class="mt-5">
                                <a href="{{ route('register') }}" class="btn btn-outline-secondary">Submit Another Application</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
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
            @endif
        </div>
    </div>
</section>
@endsection
