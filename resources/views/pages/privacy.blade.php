@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Legal</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">Privacy Policy</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                <p class="text-secondary mb-4">Last updated: {{ now()->format('F d, Y') }}</p>

                <h2 class="h5 text-brand mb-2">1. Information We Collect</h2>
                <p>We collect player and guardian details submitted through forms, including names, phone numbers, email addresses, age groups, and related registration notes.</p>

                <h2 class="h5 text-brand mt-4 mb-2">2. How We Use Information</h2>
                <p>We use submitted information to process trial and registration applications, communicate program updates, and manage academy operations.</p>

                <h2 class="h5 text-brand mt-4 mb-2">3. Data Protection</h2>
                <p>We restrict access to submitted data to authorized academy staff and apply reasonable safeguards to protect stored information.</p>

                <h2 class="h5 text-brand mt-4 mb-2">4. Data Sharing</h2>
                <p>We do not sell personal data. Information may be shared only when required for academy administration, legal compliance, or with guardian consent.</p>

                <h2 class="h5 text-brand mt-4 mb-2">5. Contact</h2>
                <p class="mb-0">
                    For privacy questions, contact us at
                    <a href="mailto:info@kingsfootballacademyabuja.com">info@kingsfootballacademyabuja.com</a>
                    or on WhatsApp
                    <a href="https://wa.me/2348033279762" target="_blank" rel="noopener">+234 803 327 9762</a>.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
