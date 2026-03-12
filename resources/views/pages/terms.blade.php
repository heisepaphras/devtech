@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Legal</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">Terms and Conditions</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                <p class="text-secondary mb-4">Last updated: {{ now()->format('F d, Y') }}</p>

                <h2 class="h5 text-brand mb-2">1. Website Use</h2>
                <p>By using this website, you agree to use it for lawful purposes and to provide accurate information in all forms and submissions.</p>

                <h2 class="h5 text-brand mt-4 mb-2">2. Academy Registrations</h2>
                <p>Submitting a registration does not guarantee immediate admission. All applications are reviewed by the academy based on available slots and evaluation standards.</p>

                <h2 class="h5 text-brand mt-4 mb-2">3. Content and Updates</h2>
                <p>News, player values, event schedules, and match updates are provided for information purposes and may change without prior notice.</p>

                <h2 class="h5 text-brand mt-4 mb-2">4. Intellectual Property</h2>
                <p>All academy branding, logos, and website content are property of Abuja Kings Football Academy and may not be reused without permission.</p>

                <h2 class="h5 text-brand mt-4 mb-2">5. Limitation of Liability</h2>
                <p class="mb-0">The academy is not liable for losses arising from reliance on website content, service interruptions, or third-party links.</p>
            </div>
        </div>
    </div>
</section>
@endsection
