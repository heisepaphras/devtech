<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0a1e4f">
    <title>{{ isset($pageTitle) ? $pageTitle . ' | Abuja Kings Football Academy' : 'Abuja Kings Football Academy' }}</title>
    <meta name="description" content="Abuja Kings Football Academy develops young football talents through professional training, discipline, and exposure programs.">
    <link rel="icon" type="image/png" href="{{ asset('images/kings-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/kings-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/kings-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body class="{{ request()->routeIs('home') ? 'home-page' : '' }}">
    @php
        $isAdminUser = auth()->check() && auth()->user()->is_admin;
        $isAdminRoute = request()->routeIs('admin.*');
        $primaryNavItems = [
            ['route' => 'home', 'label' => 'Home', 'active' => 'home'],
            ['route' => 'about', 'label' => 'About', 'active' => 'about'],
            ['route' => 'news', 'label' => 'News', 'active' => 'news*'],
            ['route' => 'gallery', 'label' => 'Gallery', 'active' => 'gallery*'],
            ['route' => 'events', 'label' => 'Events', 'active' => 'events*'],
        ];
        $pagesNavItems = [
            ['route' => 'transfer.market', 'label' => 'Transfer Market', 'active' => 'transfer.market*'],
            ['route' => 'videos', 'label' => 'Video Clips', 'active' => 'videos*'],
            ['route' => 'player.profiles', 'label' => 'CV Players Profile', 'active' => 'player.profiles*'],
            ['route' => 'players.management', 'label' => 'Academy Players / Management', 'active' => 'players.management'],
            ['route' => 'players.value', 'label' => 'Players Value', 'active' => 'players.value*'],
            ['route' => 'live.score', 'label' => 'Live Score', 'active' => 'live.score*'],
            ['route' => 'scouting.trials', 'label' => 'Scouting & Trials Programs', 'active' => 'scouting.trials*'],
            ['route' => 'register', 'label' => 'Register Now', 'active' => 'register*'],
        ];
        $pagesDropdownActive = collect($pagesNavItems)->contains(fn ($item) => request()->routeIs($item['active']));
    @endphp

    <nav class="navbar navbar-expand-lg site-navbar sticky-top">
        <div class="container py-2">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <img src="{{ asset('images/kings-logo.png') }}" alt="Abuja Kings Football Academy Logo" class="brand-logo">
                <span class="brand-title">Abuja Kings Football Academy</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#siteNavbar" aria-controls="siteNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="siteNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @foreach ($primaryNavItems as $item)
                        <li class="nav-item">
                            <a class="nav-link nav-pill {{ request()->routeIs($item['active']) ? 'active' : '' }}" href="{{ route($item['route']) }}">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-pill dropdown-toggle {{ $pagesDropdownActive ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Pages
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @foreach ($pagesNavItems as $item)
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs($item['active']) ? 'active' : '' }}" href="{{ route($item['route']) }}">
                                        {{ $item['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @if ($isAdminUser && $isAdminRoute)
        @php
            $adminItems = [
                ['name' => 'admin.news.index', 'label' => 'News'],
                ['name' => 'admin.gallery.index', 'label' => 'Gallery'],
                ['name' => 'admin.transfers.index', 'label' => 'Transfers'],
                ['name' => 'admin.player-profiles.index', 'label' => 'Players'],
                ['name' => 'admin.management.index', 'label' => 'Management'],
                ['name' => 'admin.player-values.index', 'label' => 'Values'],
                ['name' => 'admin.videos.index', 'label' => 'Videos'],
                ['name' => 'admin.live-scores.index', 'label' => 'Scores'],
                ['name' => 'admin.programs.index', 'label' => 'Programs'],
                ['name' => 'admin.events.index', 'label' => 'Events'],
                ['name' => 'admin.registrations.index', 'label' => 'Registrations'],
            ];
        @endphp
        <section class="admin-strip py-2">
            <div class="container d-flex align-items-center justify-content-between gap-3 flex-wrap">
                <div class="admin-strip-links d-flex flex-wrap gap-2">
                    @foreach ($adminItems as $item)
                        <a href="{{ route($item['name']) }}" class="admin-link {{ request()->routeIs($item['name']) ? 'active' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-sm btn-outline-light" type="submit">Logout</button>
                </form>
            </div>
        </section>
    @endif

    <main class="site-main">
        @yield('content')
    </main>

    <footer class="site-footer py-5 mt-5">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="{{ asset('images/kings-logo.png') }}" alt="Abuja Kings Football Academy logo" class="footer-logo">
                        <span class="footer-brand">Abuja Kings Football Academy</span>
                    </div>
                    <p class="footer-text mb-3">
                        Developing disciplined footballers through elite coaching, structured programs, and strong character values.
                    </p>
                    <p class="footer-text mb-0">Abuja, Nigeria</p>
                </div>

                <div class="col-6 col-lg-2">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="list-unstyled footer-links mb-0">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('news') }}">News</a></li>
                        <li><a href="{{ route('gallery') }}">Gallery</a></li>
                        <li><a href="{{ route('events') }}">Events</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-3">
                    <h5 class="footer-heading">Academy Pages</h5>
                    <ul class="list-unstyled footer-links mb-0">
                        <li><a href="{{ route('scouting.trials') }}">Scouting & Trials</a></li>
                        <li><a href="{{ route('player.profiles') }}">Player CV</a></li>
                        <li><a href="{{ route('transfer.market') }}">Transfer Market</a></li>
                        <li><a href="{{ route('live.score') }}">Live Score</a></li>
                        <li><a href="{{ route('videos') }}">Video Clips</a></li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h5 class="footer-heading">Contact & Socials</h5>
                    <ul class="list-unstyled footer-text mb-3">
                        <li class="mb-1">WhatsApp: <a href="https://wa.me/2348033279762" target="_blank" rel="noopener">+234 803 327 9762</a></li>
                        <li>Email: <a href="mailto:info@kingsfootballacademyabuja.com">info@kingsfootballacademyabuja.com</a></li>
                    </ul>
                    <div class="social-icons d-flex align-items-center gap-2">
                        <a href="https://www.instagram.com/kingsfootballacademyabuja" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.facebook.com/share/1Uor2nggTf/" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://x.com/akingsfootball" target="_blank" rel="noopener" aria-label="X"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="https://www.tiktok.com/@kingsfootballacademy" target="_blank" rel="noopener" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="https://youtube.com/@kingsfootballacademyabuja" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        <a href="https://www.threads.com/@kingsfootballacademyabuja" target="_blank" rel="noopener" aria-label="Threads"><i class="fa-brands fa-threads"></i></a>
                        <a href="https://wa.me/2348033279762" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>

            <div class="border-top border-warning-subtle mt-4 pt-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 footer-text small">
                <span>&copy; {{ now()->year }} Abuja Kings Football Academy. All rights reserved.</span>
                <div class="d-flex gap-3">
                    <a href="{{ route('privacy') }}">Privacy</a>
                    <a href="{{ route('terms') }}">Terms</a>
                    <a href="{{ route('support') }}">Support</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/site.js') }}"></script>
</body>
</html>
