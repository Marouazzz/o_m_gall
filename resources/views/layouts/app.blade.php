<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Icons -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Playfair+Display:400,500,700|Cormorant+Garamond:400,500,600|Nunito:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS (loaded through Vite) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --primary-pink: #D8A7B1;
            --primary-dark-pink: #B86B77;
            --primary-light-pink: #F3E0E5;
            --gold-accent: #C0A080;
            --ivory: #F9F5F0;
            --text-dark: #3A2E2A;
            --text-light: #F9F5F0;
            --topbar-height: 60px;
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Cormorant Garamond', serif;
            background-color: var(--ivory);
            color: var(--text-dark);
            overflow-x: hidden;
            padding-top: var(--topbar-height);
        }

        /* Top Navigation Bar */
        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--topbar-height);
            background: var(--ivory);
            box-shadow: 0 2px 10px rgba(184, 107, 119, 0.1);
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-bottom: 1px solid rgba(192, 160, 128, 0.3);
        }

        .topbar-logo {
            height: 40px;
            margin-right: 20px;
        }

        .topbar-nav {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }

        .topbar-link {
            color: var(--text-dark);
            text-decoration: none;
            padding: 0 15px;
            font-weight: 500;
            transition: all var(--transition-speed) ease;
            position: relative;
        }

        .topbar-link:hover {
            color: var(--primary-dark-pink);
        }

        .topbar-link.active {
            color: var(--primary-dark-pink);
        }

        .topbar-link.active::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 15px;
            right: 15px;
            height: 2px;
            background: var(--gold-accent);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .topbar-profile {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid var(--gold-accent);
            object-fit: cover;
            margin-left: 15px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .topbar-profile:hover {
            transform: scale(1.1);
        }

        .topbar-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--text-dark);
            cursor: pointer;
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: var(--ivory);
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1);
            z-index: 1;
            border-radius: 4px;
            border: 1px solid rgba(192, 160, 128, 0.3);
            overflow: hidden;
        }

        .dropdown-content a,
        .dropdown-content button {
            color: var(--text-dark);
            padding: 10px 16px;
            text-decoration: none;
            display: block;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .dropdown-content a:hover,
        .dropdown-content button:hover {
            background-color: var(--primary-light-pink);
            color: var(--primary-dark-pink);
        }

        .dropdown-content form {
            margin: 0;
        }

        .show-dropdown {
            display: block;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Main content area */
        .main-content {
            padding: 2rem;
            background-color: var(--ivory);
            min-height: calc(100vh - var(--topbar-height));
        }

        /* Post content width */
        .post-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Old money aesthetic elements */
        .gold-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold-accent), transparent);
            margin: 1.5rem 0;
        }

        .embossed {
            background: var(--ivory);
            box-shadow:
                8px 8px 16px rgba(184, 107, 119, 0.1),
                -8px -8px 16px rgba(255, 255, 255, 0.8);
            border-radius: 8px;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            color: var(--primary-dark-pink);
        }

        .text-gold {
            color: var(--gold-accent);
        }

        /* Buttons */
        .btn-pink {
            background-color: var(--primary-dark-pink);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: all var(--transition-speed) ease;
        }

        .btn-pink:hover {
            background-color: var(--primary-pink);
            color: white;
        }

        .btn-outline-pink {
            background-color: transparent;
            color: var(--primary-dark-pink);
            border: 1px solid var(--primary-dark-pink);
            padding: 8px 16px;
            border-radius: 4px;
            transition: all var(--transition-speed) ease;
        }

        .btn-outline-pink:hover {
            background-color: rgba(184, 107, 119, 0.1);
        }

        /* Mobile responsiveness */
        @media (max-width: 991.98px) {
            .topbar-nav {
                position: fixed;
                top: var(--topbar-height);
                left: 0;
                right: 0;
                background: var(--ivory);
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
                box-shadow: 0 5px 10px rgba(184, 107, 119, 0.1);
                transform: translateY(-100%);
                opacity: 0;
                transition: all var(--transition-speed) ease;
                z-index: 999;
            }

            .topbar-nav.show {
                transform: translateY(0);
                opacity: 1;
            }

            .topbar-link {
                padding: 10px 0;
                width: 100%;
            }

            .topbar-link.active::after {
                bottom: 5px;
                left: 0;
                right: auto;
                width: 30px;
            }

            .topbar-menu-btn {
                display: block;
            }

            .main-content {
                padding: 1rem;
            }

            .dropdown-content {
                position: fixed;
                top: calc(var(--topbar-height) + 10px);
                right: 20px;
                left: auto;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
<div id="app">
    <!-- Top Navigation Bar -->
    <nav class="topbar">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="topbar-logo">
        </a>

        <button class="topbar-menu-btn d-lg-none" onclick="toggleMobileMenu()">
            <i class="fas fa-bars"></i>
        </button>

        <div class="topbar-nav" id="topbarNav">

            @auth
                <a href="/" class="topbar-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                <a href="/profile/{{ auth()->user()->id }}" class="topbar-link {{ request()->is('profile/'.auth()->user()->id) ? 'active' : '' }}" > Profile </a>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('explore') }}">
                         Explore
                    </a>
                </li>
                <a href="#" class="topbar-link">Messages</a
            @endauth

        </div>

        <div class="topbar-right">
            @auth

                <div class="profile-dropdown">
                    <img src="{{ auth()->user()->profile ? auth()->user()->profile->profileImage() : asset('images/default-profile.png') }}"
                         class="topbar-profile"
                         onclick="toggleDropdown()"
                         alt="Profile Picture">
                    <div class="dropdown-content" id="profileDropdown">
                        <a href="/profile/{{ auth()->user()->id }}"><i class="fas fa-user me-2"></i>Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                        </form>
                    </div>
                </div>

            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid py-4">
            <div class="post-container">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle mobile menu
    function toggleMobileMenu() {
        const nav = document.getElementById('topbarNav');
        nav.classList.toggle('show');

        // Close dropdown if open
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown.classList.contains('show-dropdown')) {
            dropdown.classList.remove('show-dropdown');
        }
    }

    // Toggle profile dropdown
    function toggleDropdown() {
        document.getElementById('profileDropdown').classList.toggle('show-dropdown');

        // Close mobile menu if open
        const nav = document.getElementById('topbarNav');
        if (nav.classList.contains('show')) {
            nav.classList.remove('show');
        }
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        // Close profile dropdown
        if (!event.target.closest('.profile-dropdown')) {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown.classList.contains('show-dropdown')) {
                dropdown.classList.remove('show-dropdown');
            }
        }

        // Close mobile menu
        const nav = document.getElementById('topbarNav');
        const menuBtn = document.querySelector('.topbar-menu-btn');
        if (!nav.contains(event.target) && event.target !== menuBtn && !menuBtn.contains(event.target)) {
            nav.classList.remove('show');
        }
    });

    // Set active link based on current page (fallback)
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const links = document.querySelectorAll('.topbar-link');

        links.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
    });
</script>

@stack('scripts')
</body>
</html>
