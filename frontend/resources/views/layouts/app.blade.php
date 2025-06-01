<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Mileage'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('styles')

    <style>
        :root {
            --primary-color: #3F4CFF;
            --secondary-color: #A14FFF;
            --text-primary: #FFFFFF;
            --text-secondary: #A0A0A0;
            --background-color: #0A0A0A;
            --surface-color: #000000;
            --card-color: #141414;
            --border-color: #2A2A2A;
            --shadow: rgba(0, 0, 0, 0.3);
        }

        [data-bs-theme="light"] {
            --text-primary: #000000;
            --text-secondary: #6C757D;
            --background-color: #FFFFFF;
            --surface-color: #F8F9FA;
            --card-color: #FFFFFF;
            --border-color: #E5E5E5;
            --shadow: rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            color: var(--text-secondary);
            overflow-x: hidden;
        }

        /* Navbar Enhancements */
        .navbar {
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .navbar.scrolled {
            background-color: rgba(10, 10, 10, 0.95) !important;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
        }

        [data-bs-theme="light"] .navbar.scrolled {
            background-color: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--text-primary) !important;
        }

        .nav-link {
            font-weight: 500;
            padding: 0.6rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: var(--text-secondary) !important;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color) !important;
            background-color: rgba(63, 76, 255, 0.1);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(63, 76, 255, 0.3);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(161, 79, 255, 0.3);
        }

        .btn-outline {
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            background: transparent;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-outline:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            text-decoration: none;
        }

        #theme-toggle-btn, .search-icon-btn {
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            background: transparent;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 44px; /* Consistent width */
            height: 44px; /* Consistent height */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #theme-toggle-btn:hover, .search-icon-btn:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        /* Phone Mockup Styles */
        .phone-mockup {
            max-width: 300px;
            margin: 0 auto;
            perspective: 1000px;
            transition: transform 0.3s ease;
        }

        .phone-frame {
            background: linear-gradient(145deg, #181818, #0A0A0A); /* Darker, more modern black */
            border-radius: 50px; /* More rounded like modern iPhones */
            padding: 8px; /* Thinner bezels */
            box-shadow: 
                0 30px 60px rgba(0, 0, 0, 0.6),
                inset 0 1px 1px rgba(255, 255, 255, 0.05), /* Softer inset */
                inset 0 -1px 1px rgba(0,0,0,0.5); /* Inner shadow for depth */
            position: relative;
        }

        .phone-screen {
            background: #000;
            border-radius: 42px; /* Matches outer radius minus padding */
            overflow: hidden;
            aspect-ratio: 9 / 19.5;
            position: relative;
            display: flex; /* For centering slider */
            align-items: center;
            justify-content: center;
        }

        [data-bs-theme="light"] .phone-screen {
            background: #F8F9FA; /* Light background for light mode */
            border: 1px solid #E0E0E0; /* Subtle border for light mode screen */
        }

        /* iPhone notch/island - optional, can be simple or complex */
        .iphone-notch {
            position: absolute;
            top: 10px; /* Adjusted for thinner bezel */
            left: 50%;
            transform: translateX(-50%);
            width: 100px; /* Slightly smaller notch */
            height: 22px; /* Slightly smaller notch */
            background: #000;
            border-radius: 0 0 12px 12px; /* Smoother radius */
            z-index: 10;
        }
         .iphone-island { /* For dynamic island effect if needed */
            position: absolute;
            top: 12px; /* Adjusted for thinner bezel */
            left: 50%;
            transform: translateX(-50%);
            width: 120px; /* Wider island */
            height: 22px;
            background-color: #000;
            border-radius: 20px;
            z-index: 15; /* Above notch if both used */
        }

        [data-bs-theme="light"] .iphone-notch,
        [data-bs-theme="light"] .iphone-island {
            background-color: #495057; /* Darker grey for visibility in light mode */
            box-shadow: inset 0 -1px 1px rgba(0,0,0,0.1);
        }

        /* Card Stack Slider */
        .card-stack-slider {
            width: 85%;
            height: 60%; /* Adjust as needed */
            position: relative;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .card-slide-item {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%; /* Relative to parent .card-stack-slider */
            height: 160px; /* Fixed height for cards */
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.5s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            color: white;
            font-family: 'SF Pro Display', 'Helvetica Neue', Arial, sans-serif;
        }

        .card-slide-item img {
            /* display: none; Remove if replacing images with CSS cards */
            /* Or keep if using images as fallback / part of design */
            width: 90%;
            height: auto;
            object-fit: contain;
            border-radius: 8px; 
        }

        /* CSS Styled Cards */
        .card-content {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .card-logo {
            align-self: flex-end;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .card-chip-icon {
            width: 35px;
            height: 25px;
            background: #d4af37; /* Gold-like */
            border-radius: 4px;
        }

        .card-number-mockup {
            font-size: 1rem;
            letter-spacing: 2px;
            text-align: center;
            margin: auto 0;
        }

        .card-details-mockup {
            display: flex;
            justify-content: space-between;
            font-size: 0.65rem;
            text-transform: uppercase;
        }

        /* Example Card Styles (add more as needed) */
        .card-amex {
            background: linear-gradient(135deg, #434343, #111111) !important;
        }
        .card-jcb {
            background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
        }
        .card-visa {
            background: linear-gradient(135deg, #667eea, #764ba2) !important;
        }
        .card-mastercard {
            background: linear-gradient(135deg, #f093fb, #f5576c) !important;
        }

        [data-bs-theme="light"] .card-slide-item {
            color: #333;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        [data-bs-theme="light"] .card-amex {
            background: linear-gradient(135deg, #A0A0A0, #707070) !important;
            color: white;
        }
        [data-bs-theme="light"] .card-jcb {
            background: linear-gradient(135deg, #506BA7, #3E507B) !important;
            color: white;
        }
        [data-bs-theme="light"] .card-visa {
            background: linear-gradient(135deg, #8A9BF0, #5F4E93) !important;
            color: white;
        }
        [data-bs-theme="light"] .card-mastercard {
            background: linear-gradient(135deg, #F8B3FC, #F07C8F) !important;
            color: white;
        }
        [data-bs-theme="light"] .card-chip-icon {
            background: #b8860b; /* Darker gold for light mode */
        }

        /* Remove old credit card slider styles if they exist */
        .credit-card-slider {
            /* display: none; */ /* Or completely remove if not used elsewhere */
        }
        .card-slide {
            /* display: none; */
        }
        .credit-card-mockup {
            /* If this class is solely for old slider, remove or comment out */
        }

        /* Remove AI Analysis Box and Static Card Styles */
        .ai-analysis-box,
        .static-card-container,
        .static-amex-card {
            display: none !important; /* Ensure they are hidden */
        }

        /* Footer Styles */
        footer {
            background: var(--surface-color);
            border-top: 1px solid var(--border-color);
            padding: 60px 0 30px;
            margin-top: 80px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr repeat(4, 1fr);
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            color: var(--text-primary);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .footer-section p {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-section ul li {
            margin-bottom: 12px;
        }

        .footer-section ul li a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section ul li a:hover {
            color: var(--primary-color);
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(63, 76, 255, 0.1);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }
            
            .footer-section.company-info {
                grid-column: 1 / -1;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            
            .phone-mockup {
                max-width: 250px;
            }
            
            .navbar-brand {
                font-size: 1.5rem;
            }
        }

        /* Search Box Styles */
        .search-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-icon-btn {
            cursor: pointer;
        }

        .search-input {
            position: absolute;
            right: 50px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            opacity: 0;
            border: 1px solid var(--border-color);
            background: var(--card-color);
            color: var(--text-primary);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            z-index: 1000;
        }

        .search-container:hover .search-input,
        .search-input:focus {
            width: 250px;
            opacity: 1;
            border-color: var(--primary-color);
        }

        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(63, 76, 255, 0.1);
        }

        /* User Dropdown Styles */
        .user-dropdown {
            position: relative;
        }

        .user-avatar-btn {
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            background: var(--card-color);
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            width: 44px; /* Consistent height */
            height: 44px; /* Consistent height */
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .user-avatar-btn:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .dropdown-menu {
            background: var(--card-color);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 10px 30px var(--shadow);
            padding: 0.5rem 0;
            min-width: 180px;
            backdrop-filter: blur(10px);
            position: absolute;
            top: 100%;
            right: 0;
            z-index: 1050;
            display: none;
        }

        .dropdown-menu.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .dropdown-item {
            color: var(--text-secondary);
            padding: 0.6rem 1.2rem;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .dropdown-item:hover {
            background-color: rgba(63, 76, 255, 0.1);
            color: var(--primary-color);
            text-decoration: none;
        }

        .dropdown-item i {
            width: 16px;
            font-size: 0.9rem;
        }

        .dropdown-divider {
            height: 0;
            margin: 0.5rem 0;
            overflow: hidden;
            border-top: 1px solid var(--border-color);
        }

        /* Content Dropdown Styles */
        .nav-item.dropdown .dropdown-menu {
            top: calc(100% + 10px);
            left: 50%;
            transform: translateX(-50%);
            right: auto;
        }

        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
            opacity: 1;
            pointer-events: auto;
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .search-container:hover .search-input,
            .search-input:focus {
                width: 200px;
            }
            
            .dropdown-menu {
                position: static;
                box-shadow: none;
                border: none;
                background: rgba(63, 76, 255, 0.05);
                margin-top: 0.5rem;
                border-radius: 8px;
            }
        }
    </style>
</head>

<body>
    <div id="app">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg fixed-top" style="background-color: transparent;">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    Mileage
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @auth
                      
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mydeck') }}">My Deck</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('transactions') }}">Transactions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('privileges') }}">Privileges</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('challenges') }}">Challenges</a>
                        </li>
                        <li class="nav-item dropdown position-relative">
                            <a class="nav-link dropdown-toggle" href="#" id="kontenDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Contents
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="kontenDropdown">
                                <li><a class="dropdown-item" href="{{ url('blog') }}"><i class="bi bi-journal-text"></i>Blog</a></li>
                                <li><a class="dropdown-item" href="{{ url('promotions') }}"><i class="bi bi-gift"></i>Promotion</a></li>
                                <li><a class="dropdown-item" href="{{ url('tips') }}"><i class="bi bi-lightbulb"></i>Tips</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown position-relative">
                            <a class="nav-link dropdown-toggle" href="#" id="toolsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tools
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="toolsDropdown">
                                <li><a class="dropdown-item" href="{{ url('calculator') }}"><i class="bi bi-calculator"></i> Calculator</a></li>
                                <li><a class="dropdown-item" href="{{ url('ticketquery') }}"><i class="bi bi-ticket-perforated"></i> Ticket Query</a></li>
                            </ul>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('')}}#features-section">Fitur</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('')}}#pricing-section">Paket</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('apply-card') }}">Ajukan</a>
                        </li>
                        <li class="nav-item dropdown position-relative">
                            <a class="nav-link dropdown-toggle" href="#" id="kontenDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Konten
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="kontenDropdown">
                                <li><a class="dropdown-item" href="{{ url('blog') }}"><i class="bi bi-journal-text"></i>Blog</a></li>
                                <li><a class="dropdown-item" href="{{ url('promotions') }}"><i class="bi bi-gift"></i>Promosi</a></li>
                                <li><a class="dropdown-item" href="{{ url('tips') }}"><i class="bi bi-lightbulb"></i>Tips</a></li>
                            </ul>
                        </li>
                        @endauth
                        
                        
                    </ul>
                    
                    <div class="d-flex align-items-center gap-2">
                        <!-- Search Container -->
                        <div class="search-container">
                            <input type="text" class="search-input" placeholder="Cari kartu kredit, promosi..." id="searchInput">
                            <button class="search-icon-btn" type="button" id="searchBtn">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        
                        <!-- Theme Toggle -->
                        <button id="theme-toggle-btn" type="button" title="Toggle theme">
                            <i class="bi bi-sun-fill" id="theme-icon-light"></i>
                            <i class="bi bi-moon-stars-fill d-none" id="theme-icon-dark"></i>
                        </button>
                        
                        <!-- Authentication -->
                        @auth
                        <div class="user-dropdown dropdown">
                            <button class="user-avatar-btn" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-fill"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('billing') }}"><i class="bi bi-credit-card"></i>Billing</a></li>
                                <li><a class="dropdown-item" href="{{ route('setting') }}"><i class="bi bi-gear"></i>Settings</a></li>
                                <li><hr class="dropdown-divider" style="border-color: var(--border-color);"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary" style="height: 44px; display: inline-flex; align-items: center;">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section company-info">
                        <h3>Mileage</h3>
                        <p>Platform AI terdepan untuk optimasi kartu kredit dan manajemen keuangan personal. Maksimalkan reward dan kelola spending dengan cerdas.</p>
                        <div class="social-links">
                            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                            <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Produk</h3>
                        <ul>
                            <li><a href="#features">Fitur Utama</a></li>
                            <li><a href="#cards">Kartu Kredit</a></li>
                            <li><a href="#pricing">Paket Harga</a></li>
                            <li><a href="#">Mobile App</a></li>
                            <li><a href="#">API Integration</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Perusahaan</h3>
                        <ul>
                            <li><a href="#">Tentang Kami</a></li>
                            <li><a href="#">Karir</a></li>
                            <li><a href="#">Press Kit</a></li>
                            <li><a href="#">Partner</a></li>
                            <li><a href="#">Investor</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Dukungan</h3>
                        <ul>
                            <li><a href="#">Help Center</a></li>
                            <li><a href="#">Kontak Support</a></li>
                            <li><a href="#blog">Blog</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Community</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Legal</h3>
                        <ul>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Service</a></li>
                            <li><a href="#">Cookie Policy</a></li>
                            <li><a href="#">Security</a></li>
                            <li><a href="#">Compliance</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} Mileage. All rights reserved. Made with ❤️ in Indonesia.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme Toggle Functionality
            const themeToggleBtn = document.getElementById('theme-toggle-btn');
            const htmlElement = document.documentElement;
            const lightIcon = document.getElementById('theme-icon-light');
            const darkIcon = document.getElementById('theme-icon-dark');

            function setTheme(theme) {
                htmlElement.setAttribute('data-bs-theme', theme);
                if (theme === 'dark') {
                    lightIcon.classList.add('d-none');
                    darkIcon.classList.remove('d-none');
                } else {
                    lightIcon.classList.remove('d-none');
                    darkIcon.classList.add('d-none');
                }
                localStorage.setItem('theme', theme);
            }

            // Load saved theme
            const savedTheme = localStorage.getItem('theme') || 
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            setTheme(savedTheme);

            // Theme toggle event
            themeToggleBtn.addEventListener('click', function() {
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                setTheme(newTheme);
            });

            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            let lastScrollTop = 0;

            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > 100) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                
                lastScrollTop = scrollTop;
            });

            // Search Functionality
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            const searchContainer = document.querySelector('.search-container');

            // Handle search button click
            searchBtn.addEventListener('click', function() {
                if (searchInput.value.trim()) {
                    performSearch(searchInput.value.trim());
                }
            });

            // Handle search input enter key
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && this.value.trim()) {
                    performSearch(this.value.trim());
                }
            });

            // Focus search input when container is hovered
            searchContainer.addEventListener('mouseenter', function() {
                setTimeout(() => {
                    searchInput.focus();
                }, 100);
            });

            // Clear search when focus is lost and no value
            searchInput.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.value = '';
                }
            });

            function performSearch(query) {
                // Add your search logic here
                console.log('Searching for:', query);
                
                // Example: redirect to search results page
                // window.location.href = `/search?q=${encodeURIComponent(query)}`;
                
                // Example: show search suggestions
                showSearchSuggestions(query);
            }

            function showSearchSuggestions(query) {
                // Example search suggestions
                const suggestions = [
                    'Kartu Kredit BCA',
                    'Promo Cashback',
                    'Travel Card',
                    'Tips Kartu Kredit',
                    'Cara Daftar Kartu'
                ];
                
                const filteredSuggestions = suggestions.filter(item => 
                    item.toLowerCase().includes(query.toLowerCase())
                );
                
                // You can implement a suggestion dropdown here
                console.log('Suggestions:', filteredSuggestions);
            }

            // Dropdown Menu Enhancements
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    // Add click animation
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 100);
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                const dropdowns = document.querySelectorAll('.dropdown-menu.show');
                dropdowns.forEach(dropdown => {
                    const toggle = dropdown.previousElementSibling;
                    if (!dropdown.contains(e.target) && !toggle.contains(e.target)) {
                        dropdown.classList.remove('show');
                    }
                });
            });

            document.querySelectorAll('.nav-item.dropdown').forEach(dropdown => {
                const toggle = dropdown.querySelector('.dropdown-toggle');
                const menu = dropdown.querySelector('.dropdown-menu');
                let hoverTimeout;

                dropdown.addEventListener('mouseenter', function () {
                    clearTimeout(hoverTimeout);
                    menu.classList.add('show');
                    toggle.setAttribute('aria-expanded', 'true');
                });

                dropdown.addEventListener('mouseleave', function () {
                    hoverTimeout = setTimeout(() => {
                        menu.classList.remove('show');
                        toggle.setAttribute('aria-expanded', 'false');
                    }, 150);
                });
            });

            document.addEventListener("DOMContentLoaded", function () {
                const userDropdownBtn = document.getElementById('userDropdown');
                const userDropdownContainer = userDropdownBtn.closest('.dropdown');
                const userDropdownMenu = userDropdownContainer.querySelector('.dropdown-menu');

                let hoverTimeout;

                if (!userDropdownBtn || !userDropdownContainer || !userDropdownMenu) return;

                // Hover buka dropdown
                userDropdownContainer.addEventListener('mouseenter', () => {
                    clearTimeout(hoverTimeout);
                    const dropdown = bootstrap.Dropdown.getOrCreateInstance(userDropdownBtn);
                    dropdown.show();
                });

                // Hover keluar tutup dropdown
                userDropdownContainer.addEventListener('mouseleave', () => {
                    hoverTimeout = setTimeout(() => {
                        const dropdown = bootstrap.Dropdown.getOrCreateInstance(userDropdownBtn);
                        dropdown.hide();
                    }, 200);
                });

                // Klik di luar untuk menutup dropdown
                document.addEventListener('click', function (e) {
                    const isInside = userDropdownContainer.contains(e.target);
                    const dropdown = bootstrap.Dropdown.getOrCreateInstance(userDropdownBtn);

                    if (!isInside && userDropdownMenu.classList.contains('show')) {
                        dropdown.hide();
                    }
                });
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add fade-in animation to elements
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe elements for animation
            document.querySelectorAll('section, .feature-card, .credit-card, .plan-card, .promo-card, .blog-card').forEach(el => {
                observer.observe(el);
            });

            // Mobile navbar toggle enhancement
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');
            
            if (navbarToggler) {
                navbarToggler.addEventListener('click', function() {
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    
                    // Add smooth animation
                    if (!isExpanded) {
                        navbarCollapse.style.transition = 'all 0.3s ease';
                    }
                });
            }

            // Real-time search suggestions (optional)
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                if (query.length > 2) {
                    searchTimeout = setTimeout(() => {
                        // Implement real-time search suggestions here
                        showSearchSuggestions(query);
                    }, 300);
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
