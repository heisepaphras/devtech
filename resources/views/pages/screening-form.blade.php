@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Academy Intake</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">Screening & Enrolment Form</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">

            {{-- Download card --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 p-lg-5 d-flex flex-column gap-3">
                        <div>
                            <span class="kicker kicker-dark">Step 1</span>
                            <h2 class="h5 section-title mt-2 mb-1">Download the Form</h2>
                            <p class="text-secondary mb-0">
                                Click the button below to download the official Kings FA Screening &amp; Enrolment Form
                                in Microsoft Word format (.docx). You can fill it in digitally or print and fill by hand.
                            </p>
                        </div>
                        <a href="{{ asset('downloads/kings-fa-screening-form.docx') }}"
                           download="Kings-FA-Screening-Form.docx"
                           class="btn btn-brand btn-lg align-self-start">
                            <i class="fa-solid fa-file-arrow-down me-2"></i>Download Screening Form
                        </a>
                        <p class="small text-secondary mb-0">
                            File type: Microsoft Word (.docx) &mdash; Compatible with Word, Google Docs, LibreOffice.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Instructions card --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 p-lg-5">
                        <span class="kicker kicker-dark">Step 2 &amp; 3</span>
                        <h2 class="h5 section-title mt-2 mb-4">Complete &amp; Submit the Form</h2>

                        <ol class="d-flex flex-column gap-4 ps-3 mb-4">
                            <li>
                                <strong class="d-block mb-1">Fill in all sections carefully</strong>
                                <span class="text-secondary small">
                                    Complete the player details, parent/guardian information, medical history,
                                    and any other fields marked on the form. Ensure all information is accurate
                                    before submitting.
                                </span>
                            </li>
                            <li>
                                <strong class="d-block mb-1">Attach a passport photograph</strong>
                                <span class="text-secondary small">
                                    Include a recent passport-size photograph of the player. You can attach a
                                    scanned/photographed copy to your WhatsApp message.
                                </span>
                            </li>
                            <li>
                                <strong class="d-block mb-1">Send to us on WhatsApp</strong>
                                <span class="text-secondary small">
                                    Once completed, send the filled form (and photo) directly to our
                                    WhatsApp number below. Our team will review your submission and get
                                    back to you within 1–2 working days to confirm your screening date.
                                </span>
                            </li>
                        </ol>

                        <div class="card border-0 bg-light rounded-3 p-3 d-flex flex-column flex-sm-row align-items-sm-center gap-3">
                            <div class="flex-grow-1">
                                <p class="fw-semibold mb-0 text-brand">Send completed form to:</p>
                                <p class="small text-secondary mb-0">WhatsApp only &mdash; Mon to Sat, 9 AM – 5 PM (WAT)</p>
                            </div>
                            <a href="https://wa.me/2348033279762?text=Hello%2C%20I%20would%20like%20to%20submit%20my%20Kings%20FA%20Screening%20Form."
                               target="_blank" rel="noopener"
                               class="btn btn-success d-flex align-items-center gap-2 flex-shrink-0">
                                <i class="fa-brands fa-whatsapp fs-5"></i>
                                <span>+234 803 327 9762</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Also apply online section --}}
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                        <div>
                            <h3 class="h5 text-brand mb-1">Prefer to Apply Online?</h3>
                            <p class="text-secondary mb-0">
                                You can also complete our digital registration form directly on the site —
                                no download required.
                            </p>
                        </div>
                        <a href="{{ route('register') }}" class="btn btn-outline-brand flex-shrink-0">Go to Online Registration</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
