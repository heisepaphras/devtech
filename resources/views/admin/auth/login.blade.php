@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container">
        <span class="kicker">Admin Access</span>
        <h1 class="display-6 fw-bold text-white mt-2 mb-0">Admin Login</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                @if (session('status'))
                    <div class="alert alert-info">{{ session('status') }}</div>
                @endif

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        <form method="POST" action="{{ route('admin.login.store') }}" class="row g-3">
                            @csrf

                            <div class="col-12">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" value="1" class="form-check-input" id="remember">
                                    <label for="remember" class="form-check-label">Remember me</label>
                                </div>
                            </div>

                            <div class="col-12 d-flex gap-2">
                                <button class="btn btn-brand" type="submit">Sign In</button>
                                <a class="btn btn-outline-secondary" href="{{ route('home') }}">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
