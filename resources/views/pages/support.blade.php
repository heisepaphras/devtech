@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Help Desk</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">Support</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="h5 text-brand mb-3">How We Can Help</h2>
                        <ul class="mb-4">
                            <li>Registration and trial application support</li>
                            <li>Program schedule clarification</li>
                            <li>General academy inquiries</li>
                            <li>Partnership and scouting inquiries</li>
                        </ul>

                        <h3 class="h6 fw-semibold mb-2">Support Hours</h3>
                        <p class="mb-0">Monday to Saturday, 9:00 AM to 5:00 PM (WAT).</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="h5 text-brand mb-3">Contact Support</h2>
                        <p class="mb-2"><strong>Email:</strong> <a href="mailto:info@kingsfootballacademyabuja.com">info@kingsfootballacademyabuja.com</a></p>
                        <p class="mb-3"><strong>WhatsApp:</strong> <a href="https://wa.me/2348033279762" target="_blank" rel="noopener">+234 803 327 9762</a></p>

                        <div class="d-flex gap-2 flex-wrap">
                            <a class="btn btn-brand" href="{{ route('register') }}">Go to Registration</a>
                            <a class="btn btn-outline-brand" href="{{ route('about') }}">Read About Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
