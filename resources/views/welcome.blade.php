<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Hotel — Luxury Stay Experience</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .gold { color: #D4AF37; }
        .bg-gold { background-color: #D4AF37; }
        .border-gold { border-color: #D4AF37; }
        .hover-gold:hover { background-color: #B8960C; }

        /* Dropdown */
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 52px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            border: 1px solid #f3f4f6;
            width: 220px;
            z-index: 100;
        }
        .dropdown-menu.open { display: block; }

        /* Logout Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }
        .modal-overlay.active { display: flex; }
    </style>
</head>
<body class="bg-gray-50">

{{-- ══════════════════════════════════════════
     LOGOUT CONFIRMATION MODAL
══════════════════════════════════════════ --}}
<div class="modal-overlay" id="logoutModal">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-sign-out-alt text-red-500 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Logging Out</h3>
        <p class="text-gray-500 text-sm mb-6">
            Are you sure you want to log out of Grand Hotel?
        </p>
        <div class="flex gap-3">
            <button onclick="closeLogoutModal()"
                    class="flex-1 border border-gray-200 text-gray-700 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                <i class="fas fa-times mr-1"></i> Cancel
            </button>
            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf
                <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 text-white py-2.5 rounded-xl text-sm font-medium transition">
                    <i class="fas fa-sign-out-alt mr-1"></i> Yes, Logout
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     NAVIGATION
══════════════════════════════════════════ --}}
<nav class="hero-bg shadow-lg fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gold rounded-full flex items-center justify-center">
                <i class="fas fa-hotel text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-white font-bold text-lg leading-none">Grand Hotel</h1>
                <p class="text-xs gold">Luxury & Comfort</p>
            </div>
        </a>

        {{-- Nav Links --}}
        <div class="hidden md:flex items-center gap-8">
            <a href="#rooms" class="text-gray-300 hover:text-white text-sm transition flex items-center gap-1.5">
                <i class="fas fa-door-open text-xs"></i> Rooms
            </a>
            <a href="#amenities" class="text-gray-300 hover:text-white text-sm transition flex items-center gap-1.5">
                <i class="fas fa-concierge-bell text-xs"></i> Amenities
            </a>
            <a href="#about" class="text-gray-300 hover:text-white text-sm transition flex items-center gap-1.5">
                <i class="fas fa-info-circle text-xs"></i> About
            </a>
            <a href="#contact" class="text-gray-300 hover:text-white text-sm transition flex items-center gap-1.5">
                <i class="fas fa-envelope text-xs"></i> Contact
            </a>
        </div>

        {{-- ── Auth Buttons ── --}}
        <div class="flex items-center gap-3">
            @auth
                {{-- ── Logged In: Show Profile Dropdown ── --}}
                <div class="relative" id="profileDropdown">
                    <button onclick="toggleDropdown()"
                            class="flex items-center gap-2.5 text-white hover:opacity-90 transition focus:outline-none">
                        {{-- Avatar --}}
                        <div class="w-9 h-9 bg-gold rounded-full flex items-center justify-center shadow-md">
                            <span class="text-white text-sm font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                        {{-- Name --}}
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-semibold text-white leading-none">
                                {{ explode(' ', auth()->user()->name)[0] }}
                            </p>
                            <p class="text-xs text-yellow-300">Guest Account</p>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-gray-400 ml-1" id="chevron"></i>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div class="dropdown-menu" id="dropdownMenu">
                        {{-- User Info --}}
                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 rounded-t-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Menu Items --}}
                        <div class="py-1">
                            <a href="{{ route('rooms.index') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition">
                                <i class="fas fa-door-open text-gray-400 w-4 text-center"></i>
                                Browse Rooms
                            </a>
                            <a href="{{ route('guest.bookings') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition">
                                <i class="fas fa-calendar-check text-gray-400 w-4 text-center"></i>
                                My Bookings
                            </a>
                            <a href="{{ route('guest.profile') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition">
                                <i class="fas fa-user text-gray-400 w-4 text-center"></i>
                                My Profile
                            </a>

                            {{-- Show Admin Panel link only if user is admin/staff --}}
                            @if(auth()->user()->hasAnyRole(['super_admin', 'manager', 'receptionist', 'housekeeping']))
                                <div class="border-t border-gray-100 my-1"></div>
                                <a href="{{ route('admin.dashboard') }}"
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-purple-700 hover:bg-purple-50 transition">
                                    <i class="fas fa-tachometer-alt text-purple-400 w-4 text-center"></i>
                                    Admin Panel
                                </a>
                            @endif

                            <div class="border-t border-gray-100 my-1"></div>

                            {{-- Logout Button --}}
                            <button onclick="openLogoutModal()"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 w-full text-left transition rounded-b-xl">
                                <i class="fas fa-sign-out-alt text-red-400 w-4 text-center"></i>
                                Logout
                            </button>
                        </div>
                    </div>
                </div>

            @else
                {{-- ── Not Logged In: Show Login + Register ── --}}
                <a href="{{ route('login') }}"
                   class="flex items-center gap-2 text-gray-300 hover:text-white text-sm transition px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-10">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="hidden sm:inline">Login</span>
                </a>
                <a href="{{ route('register') }}"
                   class="flex items-center gap-2 bg-gold hover-gold text-white px-5 py-2 rounded-lg text-sm font-medium transition shadow-md">
                    <i class="fas fa-user-plus"></i>
                    <span>Register</span>
                </a>
            @endauth
        </div>

    </div>
</nav>

{{-- ══════════════════════════════════════════
     FLASH MESSAGE (after login)
══════════════════════════════════════════ --}}
@if(session('success') || session('error'))
    <div class="fixed top-20 right-4 z-50 max-w-sm">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl shadow-lg flex items-center gap-2 text-sm">
                <i class="fas fa-check-circle text-green-500"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl shadow-lg flex items-center gap-2 text-sm">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                {{ session('error') }}
            </div>
        @endif
    </div>
@endif

{{-- ══════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════ --}}
<section class="hero-bg min-h-screen flex items-center justify-center pt-20">
    <div class="text-center px-6 fade-in">

        @auth
            {{-- Personalized welcome for logged-in users --}}
            <p class="gold text-sm font-medium tracking-widest uppercase mb-4">
                <i class="fas fa-hand-wave mr-1"></i>
                Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!
            </p>
        @else
            <p class="gold text-sm font-medium tracking-widest uppercase mb-4">
                <i class="fas fa-star mr-1"></i>
                Welcome to Grand Hotel
            </p>
        @endauth

        <h2 class="text-5xl md:text-7xl font-bold text-white leading-tight mb-6">
            Experience<br>
            <span class="gold">Luxury</span> Living
        </h2>
        <p class="text-gray-300 text-lg md:text-xl max-w-2xl mx-auto mb-10">
            Discover the perfect blend of comfort, elegance, and world-class
            hospitality. Your dream stay awaits at Grand Hotel.
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
            <a href="{{ route('rooms.index') }}"
               class="bg-gold hover-gold text-white px-8 py-4 rounded-xl text-base font-semibold transition w-full sm:w-auto shadow-lg">
                <i class="fas fa-calendar-check mr-2"></i> Book Your Stay
            </a>
            <a href="#rooms"
               class="border border-white text-white hover:bg-white hover:text-gray-900 px-8 py-4 rounded-xl text-base font-semibold transition w-full sm:w-auto">
                <i class="fas fa-door-open mr-2"></i> View Rooms
            </a>
        </div>

        {{-- Quick Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto">
            <div class="text-center">
                <p class="text-4xl font-bold gold">11+</p>
                <p class="text-gray-400 text-sm mt-1">
                    <i class="fas fa-bed mr-1 text-xs"></i> Luxury Rooms
                </p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-bold gold">4</p>
                <p class="text-gray-400 text-sm mt-1">
                    <i class="fas fa-layer-group mr-1 text-xs"></i> Room Types
                </p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-bold gold">24/7</p>
                <p class="text-gray-400 text-sm mt-1">
                    <i class="fas fa-concierge-bell mr-1 text-xs"></i> Room Service
                </p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-bold gold">100%</p>
                <p class="text-gray-400 text-sm mt-1">
                    <i class="fas fa-heart mr-1 text-xs"></i> Satisfaction
                </p>
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════
     ROOM TYPES SECTION
══════════════════════════════════════════ --}}
<section id="rooms" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="gold text-sm font-medium tracking-widest uppercase mb-2">
                <i class="fas fa-door-open mr-1"></i> Our Rooms
            </p>
            <h3 class="text-4xl font-bold text-gray-800">Choose Your Perfect Room</h3>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">
                From cozy standard rooms to lavish executive suites,
                we have the perfect room for every occasion.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Standard Room --}}
            <div class="card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="h-48 hero-bg flex items-center justify-center relative">
                    <i class="fas fa-bed text-6xl gold opacity-80"></i>
                    <div class="absolute bottom-3 left-3">
                        <span class="bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded-full border border-white border-opacity-30">
                            <i class="fas fa-users mr-1"></i> Max 2 guests
                        </span>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between mb-1">
                        <h4 class="font-bold text-gray-800 text-lg">Standard Room</h4>
                        <i class="fas fa-bed text-gray-300"></i>
                    </div>
                    <p class="text-gray-500 text-sm mt-1 mb-3">Perfect for solo travelers and couples</p>
                    <div class="flex flex-wrap gap-1 mb-4">
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-wifi text-xs"></i> WiFi
                        </span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-snowflake text-xs"></i> AC
                        </span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-tv text-xs"></i> TV
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-2xl font-bold text-gray-800">$80</span>
                            <span class="text-gray-400 text-sm">/night</span>
                        </div>
                        <a href="{{ route('rooms.index') }}"
                           class="bg-gold text-white px-4 py-2 rounded-lg text-sm hover-gold transition flex items-center gap-1">
                            <i class="fas fa-calendar-plus text-xs"></i> Book
                        </a>
                    </div>
                </div>
            </div>

            {{-- Deluxe Room --}}
            <div class="card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="h-48 bg-gradient-to-br from-blue-900 to-blue-700 flex items-center justify-center relative">
                    <i class="fas fa-bed text-6xl text-blue-200 opacity-80"></i>
                    <div class="absolute bottom-3 left-3">
                        <span class="bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded-full border border-white border-opacity-30">
                            <i class="fas fa-users mr-1"></i> Max 2 guests
                        </span>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between mb-1">
                        <h4 class="font-bold text-gray-800 text-lg">Deluxe Room</h4>
                        <i class="fas fa-star text-blue-300"></i>
                    </div>
                    <p class="text-gray-500 text-sm mt-1 mb-3">Spacious room with premium furnishings</p>
                    <div class="flex flex-wrap gap-1 mb-4">
                        <span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-wifi text-xs"></i> WiFi
                        </span>
                        <span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-snowflake text-xs"></i> AC
                        </span>
                        <span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-glass-martini text-xs"></i> Mini Bar
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-2xl font-bold text-gray-800">$130</span>
                            <span class="text-gray-400 text-sm">/night</span>
                        </div>
                        <a href="{{ route('rooms.index') }}"
                           class="bg-gold text-white px-4 py-2 rounded-lg text-sm hover-gold transition flex items-center gap-1">
                            <i class="fas fa-calendar-plus text-xs"></i> Book
                        </a>
                    </div>
                </div>
            </div>

            {{-- Junior Suite --}}
            <div class="card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden relative">
                <div class="absolute top-3 right-3 z-10">
                    <span class="bg-gold text-white text-xs px-2 py-1 rounded-full font-medium flex items-center gap-1">
                        <i class="fas fa-fire text-xs"></i> Popular
                    </span>
                </div>
                <div class="h-48 bg-gradient-to-br from-purple-900 to-purple-700 flex items-center justify-center relative">
                    <i class="fas fa-crown text-6xl text-purple-200 opacity-80"></i>
                    <div class="absolute bottom-3 left-3">
                        <span class="bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded-full border border-white border-opacity-30">
                            <i class="fas fa-users mr-1"></i> Max 3 guests
                        </span>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between mb-1">
                        <h4 class="font-bold text-gray-800 text-lg">Junior Suite</h4>
                        <i class="fas fa-crown text-purple-300"></i>
                    </div>
                    <p class="text-gray-500 text-sm mt-1 mb-3">Suite with separate living area</p>
                    <div class="flex flex-wrap gap-1 mb-4">
                        <span class="text-xs bg-purple-50 text-purple-600 px-2 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-wifi text-xs"></i> WiFi
                        </span>
                        <span class="text-xs bg-purple-50 text-purple-600 px-2 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-bath text-xs"></i> Bathtub
                        </span>
                        <span class="text-xs bg-purple-50 text-purple-600 px-2 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-couch text-xs"></i> Lounge
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-2xl font-bold text-gray-800">$200</span>
                            <span class="text-gray-400 text-sm">/night</span>
                        </div>
                        <a href="{{ route('rooms.index') }}"
                           class="bg-gold text-white px-4 py-2 rounded-lg text-sm hover-gold transition flex items-center gap-1">
                            <i class="fas fa-calendar-plus text-xs"></i> Book
                        </a>
                    </div>
                </div>
            </div>

            {{-- Executive Suite --}}
            <div class="card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden relative">
                <div class="absolute top-3 right-3 z-10">
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-medium flex items-center gap-1">
                        <i class="fas fa-gem text-xs"></i> Luxury
                    </span>
                </div>
                <div class="h-48 bg-gradient-to-br from-yellow-800 to-yellow-600 flex items-center justify-center relative">
                    <i class="fas fa-gem text-6xl text-yellow-200 opacity-80"></i>
                    <div class="absolute bottom-3 left-3">
                        <span class="bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded-full border border-white border-opacity-30">
                            <i class="fas fa-users mr-1"></i> Max 4 guests
                        </span>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between mb-1">
                        <h4 class="font-bold text-gray-800 text-lg">Executive Suite</h4>
                        <i class="fas fa-gem text-yellow-400"></i>
                    </div>
                    <p class="text-gray-500 text-sm mt-1 mb-3">Luxury suite with panoramic views</p>
                    <div class="flex flex-wrap gap-1 mb-4">
                        <span class="text-xs bg-yellow-50 text-yellow-700 px-2 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-hot-tub text-xs"></i> Jacuzzi
                        </span>
                        <span class="text-xs bg-yellow-50 text-yellow-700 px-2 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-concierge-bell text-xs"></i> Butler
                        </span>
                        <span class="text-xs bg-yellow-50 text-yellow-700 px-2 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-glass-whiskey text-xs"></i> Bar
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-2xl font-bold text-gray-800">$350</span>
                            <span class="text-gray-400 text-sm">/night</span>
                        </div>
                        <a href="{{ route('rooms.index') }}"
                           class="bg-gold text-white px-4 py-2 rounded-lg text-sm hover-gold transition flex items-center gap-1">
                            <i class="fas fa-calendar-plus text-xs"></i> Book
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- View All Rooms Button --}}
        <div class="text-center mt-10">
            <a href="{{ route('rooms.index') }}"
               class="inline-flex items-center gap-2 border-2 border-gold text-yellow-600 hover:bg-gold hover:text-white px-8 py-3 rounded-xl font-semibold transition">
                <i class="fas fa-th-large"></i> View All Available Rooms
            </a>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════
     AMENITIES SECTION
══════════════════════════════════════════ --}}
<section id="amenities" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="gold text-sm font-medium tracking-widest uppercase mb-2">
                <i class="fas fa-concierge-bell mr-1"></i> What We Offer
            </p>
            <h3 class="text-4xl font-bold text-gray-800">World-Class Amenities</h3>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">Everything you need for a perfect and comfortable stay</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach([
                ['fas fa-wifi',         'Free WiFi',      'High-speed internet',   'bg-blue-50',   'text-blue-600'],
                ['fas fa-swimming-pool','Swimming Pool',  'Open 6am - 10pm',       'bg-cyan-50',   'text-cyan-600'],
                ['fas fa-spa',          'Spa & Wellness', 'Full body treatments',  'bg-pink-50',   'text-pink-600'],
                ['fas fa-utensils',     'Restaurant',     '24/7 room service',     'bg-orange-50', 'text-orange-600'],
                ['fas fa-car',          'Airport Transfer','Pick up & drop off',   'bg-green-50',  'text-green-600'],
                ['fas fa-dumbbell',     'Fitness Center', 'Modern equipment',      'bg-purple-50', 'text-purple-600'],
            ] as $amenity)
                <div class="card-hover bg-white rounded-2xl p-5 text-center shadow-sm border border-gray-100">
                    <div class="w-12 h-12 {{ $amenity[3] }} rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="{{ $amenity[0] }} {{ $amenity[4] }} text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 text-sm">{{ $amenity[1] }}</h4>
                    <p class="text-gray-400 text-xs mt-1">{{ $amenity[2] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     ABOUT SECTION
══════════════════════════════════════════ --}}
<section id="about" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <div>
                <p class="gold text-sm font-medium tracking-widest uppercase mb-3">
                    <i class="fas fa-info-circle mr-1"></i> About Us
                </p>
                <h3 class="text-4xl font-bold text-gray-800 mb-5">
                    A Legacy of Luxury<br>and Hospitality
                </h3>
                <p class="text-gray-500 mb-5 leading-relaxed">
                    Grand Hotel has been providing world-class hospitality services
                    for years. Our commitment to excellence ensures that every guest
                    experiences the finest in comfort, service, and luxury.
                </p>
                <p class="text-gray-500 mb-8 leading-relaxed">
                    From our elegantly designed rooms to our exceptional dining
                    experiences, every detail is crafted to make your stay
                    truly unforgettable.
                </p>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4 flex items-center gap-3">
                        <i class="fas fa-layer-group gold text-2xl"></i>
                        <div>
                            <p class="text-2xl font-bold gold">4</p>
                            <p class="text-gray-500 text-sm">Room Categories</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 flex items-center gap-3">
                        <i class="fas fa-bed gold text-2xl"></i>
                        <div>
                            <p class="text-2xl font-bold gold">11</p>
                            <p class="text-gray-500 text-sm">Luxury Rooms</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 flex items-center gap-3">
                        <i class="fas fa-concierge-bell gold text-2xl"></i>
                        <div>
                            <p class="text-2xl font-bold gold">6+</p>
                            <p class="text-gray-500 text-sm">Hotel Services</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 flex items-center gap-3">
                        <i class="fas fa-headset gold text-2xl"></i>
                        <div>
                            <p class="text-2xl font-bold gold">24/7</p>
                            <p class="text-gray-500 text-sm">Guest Support</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-bg rounded-3xl p-10 text-center">
                <i class="fas fa-hotel text-9xl gold mb-6 block opacity-80"></i>
                <h4 class="text-white text-2xl font-bold mb-3">Grand Hotel</h4>
                <p class="text-gray-300 mb-4">Where luxury meets comfort</p>
                <div class="flex justify-center gap-1 mb-2">
                    <i class="fas fa-star gold"></i>
                    <i class="fas fa-star gold"></i>
                    <i class="fas fa-star gold"></i>
                    <i class="fas fa-star gold"></i>
                    <i class="fas fa-star gold"></i>
                </div>
                <p class="text-gray-400 text-sm">5-Star Rated Hotel</p>
                <div class="grid grid-cols-3 gap-3 mt-6">
                    <div class="bg-white bg-opacity-10 rounded-xl p-3">
                        <i class="fas fa-shield-alt text-yellow-400 text-lg block mb-1"></i>
                        <p class="text-white text-xs">Safe & Secure</p>
                    </div>
                    <div class="bg-white bg-opacity-10 rounded-xl p-3">
                        <i class="fas fa-leaf text-green-400 text-lg block mb-1"></i>
                        <p class="text-white text-xs">Eco Friendly</p>
                    </div>
                    <div class="bg-white bg-opacity-10 rounded-xl p-3">
                        <i class="fas fa-award text-yellow-400 text-lg block mb-1"></i>
                        <p class="text-white text-xs">Award Winning</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     SERVICES SECTION
══════════════════════════════════════════ --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="gold text-sm font-medium tracking-widest uppercase mb-2">
                <i class="fas fa-hand-holding-heart mr-1"></i> Our Services
            </p>
            <h3 class="text-4xl font-bold text-gray-800">Everything You Need</h3>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">Premium services designed to make your stay extraordinary</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                [
                    'icon'  => 'fas fa-concierge-bell',
                    'title' => 'Room Service',
                    'desc'  => 'Enjoy delicious meals delivered directly to your room, available 24 hours a day, 7 days a week.',
                    'price' => '$15',
                    'color' => 'bg-orange-50',
                    'icon_color' => 'text-orange-500',
                    'badge' => 'bg-orange-100 text-orange-700',
                ],
                [
                    'icon'  => 'fas fa-spa',
                    'title' => 'Spa Treatment',
                    'desc'  => 'Relax and rejuvenate with our full-body massage and wellness treatments by expert therapists.',
                    'price' => '$80',
                    'color' => 'bg-pink-50',
                    'icon_color' => 'text-pink-500',
                    'badge' => 'bg-pink-100 text-pink-700',
                ],
                [
                    'icon'  => 'fas fa-car-side',
                    'title' => 'Airport Transfer',
                    'desc'  => 'Comfortable and punctual airport pickup and drop-off service for a seamless travel experience.',
                    'price' => '$35',
                    'color' => 'bg-green-50',
                    'icon_color' => 'text-green-500',
                    'badge' => 'bg-green-100 text-green-700',
                ],
            ] as $service)
                <div class="card-hover bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="w-14 h-14 {{ $service['color'] }} rounded-2xl flex items-center justify-center mb-4">
                        <i class="{{ $service['icon'] }} {{ $service['icon_color'] }} text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg mb-2">{{ $service['title'] }}</h4>
                    <p class="text-gray-500 text-sm mb-4 leading-relaxed">{{ $service['desc'] }}</p>
                    <div class="flex items-center justify-between">
                        <p class="gold font-bold text-lg">From {{ $service['price'] }}</p>
                        <span class="text-xs px-3 py-1 rounded-full {{ $service['badge'] }} font-medium">
                            <i class="fas fa-check mr-1"></i> Available
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     CONTACT SECTION
══════════════════════════════════════════ --}}
<section id="contact" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="gold text-sm font-medium tracking-widest uppercase mb-2">
                <i class="fas fa-envelope mr-1"></i> Get In Touch
            </p>
            <h3 class="text-4xl font-bold text-gray-800">Contact Us</h3>
            <p class="text-gray-500 mt-3">We are here to help with any questions about your stay</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
            <div class="text-center card-hover bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-map-marker-alt text-red-500 text-xl"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-1">Address</h4>
                <p class="text-gray-500 text-sm">Phnom Penh, Cambodia</p>
            </div>
            <div class="text-center card-hover bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <div class="w-14 h-14 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-phone text-green-500 text-xl"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-1">Phone</h4>
                <p class="text-gray-500 text-sm">+855 12 345 678</p>
            </div>
            <div class="text-center card-hover bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <div class="w-14 h-14 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-envelope text-blue-500 text-xl"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-1">Email</h4>
                <p class="text-gray-500 text-sm">info@grandhotel.com</p>
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════
     CTA SECTION
══════════════════════════════════════════ --}}
<section class="hero-bg py-20">
    <div class="max-w-3xl mx-auto px-6 text-center">
        <i class="fas fa-hotel text-5xl gold mb-6 block opacity-70"></i>
        <h3 class="text-4xl font-bold text-white mb-4">
            Ready for an Unforgettable Stay?
        </h3>
        <p class="text-gray-300 mb-8 text-lg">
            Book your room today and experience the finest hospitality
            that Grand Hotel has to offer.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('rooms.index') }}"
               class="bg-gold hover-gold text-white px-8 py-4 rounded-xl text-base font-semibold transition w-full sm:w-auto shadow-lg flex items-center justify-center gap-2">
                <i class="fas fa-calendar-check"></i> Book Now
            </a>
            @guest
                <a href="{{ route('login') }}"
                   class="border border-white text-white hover:bg-white hover:text-gray-900 px-8 py-4 rounded-xl text-base font-semibold transition w-full sm:w-auto flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            @endguest
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     FOOTER
══════════════════════════════════════════ --}}
<footer class="bg-gray-900 text-gray-400 py-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">

            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 bg-gold rounded-full flex items-center justify-center">
                        <i class="fas fa-hotel text-white text-sm"></i>
                    </div>
                    <span class="text-white font-bold text-lg">Grand Hotel</span>
                </div>
                <p class="text-sm leading-relaxed mb-4">
                    Experience luxury and comfort at its finest. Your perfect stay awaits.
                </p>
                <div class="flex gap-3">
                    <div class="w-8 h-8 bg-gray-800 hover:bg-gold rounded-full flex items-center justify-center cursor-pointer transition">
                        <i class="fab fa-facebook-f text-xs text-gray-400"></i>
                    </div>
                    <div class="w-8 h-8 bg-gray-800 hover:bg-gold rounded-full flex items-center justify-center cursor-pointer transition">
                        <i class="fab fa-instagram text-xs text-gray-400"></i>
                    </div>
                    <div class="w-8 h-8 bg-gray-800 hover:bg-gold rounded-full flex items-center justify-center cursor-pointer transition">
                        <i class="fab fa-twitter text-xs text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-4">
                    <i class="fas fa-link mr-2 text-yellow-500"></i>Quick Links
                </h4>
                <div class="space-y-2 text-sm">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 hover:text-white transition">
                        <i class="fas fa-home text-xs gold"></i> Home
                    </a>
                    <a href="{{ route('rooms.index') }}" class="flex items-center gap-2 hover:text-white transition">
                        <i class="fas fa-door-open text-xs gold"></i> Browse Rooms
                    </a>
                    <a href="#amenities" class="flex items-center gap-2 hover:text-white transition">
                        <i class="fas fa-concierge-bell text-xs gold"></i> Amenities
                    </a>
                    <a href="#contact" class="flex items-center gap-2 hover:text-white transition">
                        <i class="fas fa-envelope text-xs gold"></i> Contact
                    </a>
                    @auth
                        <a href="{{ route('guest.bookings') }}" class="flex items-center gap-2 hover:text-white transition">
                            <i class="fas fa-calendar-check text-xs gold"></i> My Bookings
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-2 hover:text-white transition">
                            <i class="fas fa-sign-in-alt text-xs gold"></i> Login
                        </a>
                    @endauth
                </div>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-4">
                    <i class="fas fa-headset mr-2 text-yellow-500"></i>Contact Info
                </h4>
                <div class="space-y-3 text-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-red-900 bg-opacity-50 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-map-marker-alt text-red-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-white text-xs font-medium">Address</p>
                            <p class="text-gray-400">Phnom Penh, Cambodia</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-green-900 bg-opacity-50 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-phone text-green-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-white text-xs font-medium">Phone</p>
                            <p class="text-gray-400">+855 12 345 678</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-blue-900 bg-opacity-50 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-envelope text-blue-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-white text-xs font-medium">Email</p>
                            <p class="text-gray-400">info@grandhotel.com</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="border-t border-gray-800 pt-6 flex flex-col md:flex-row items-center justify-between gap-3 text-sm">
            <p>
                © {{ date('Y') }} Grand Hotel. Built with
                <i class="fas fa-heart text-red-500 mx-1"></i>
                by <span class="gold font-medium">Team Hotel Management System</span>
                — Royal University of Phnom Penh
            </p>
            <div class="flex items-center gap-2 text-xs">
                <i class="fas fa-lock text-green-500"></i>
                <span>Secure & Encrypted</span>
            </div>
        </div>
    </div>
</footer>

{{-- ══════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════ --}}
<script>
    // ── Profile Dropdown ──────────────────────────────────
    function toggleDropdown() {
        const menu = document.getElementById('dropdownMenu');
        const chevron = document.getElementById('chevron');
        menu.classList.toggle('open');
        if (menu.classList.contains('open')) {
            chevron.style.transform = 'rotate(180deg)';
        } else {
            chevron.style.transform = 'rotate(0deg)';
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            const menu = document.getElementById('dropdownMenu');
            const chevron = document.getElementById('chevron');
            if (menu) menu.classList.remove('open');
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        }
    });

    // ── Logout Modal ──────────────────────────────────────
    function openLogoutModal() {
        // Close dropdown first
        const menu = document.getElementById('dropdownMenu');
        if (menu) menu.classList.remove('open');
        // Open modal
        document.getElementById('logoutModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close modal when clicking the dark overlay
    document.getElementById('logoutModal').addEventListener('click', function(e) {
        if (e.target === this) closeLogoutModal();
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLogoutModal();
    });

    // ── Auto-hide flash messages ───────────────────────────
    setTimeout(function() {
        const flash = document.querySelector('.fixed.top-20');
        if (flash) {
            flash.style.opacity = '0';
            flash.style.transition = 'opacity 0.5s';
            setTimeout(() => flash.remove(), 500);
        }
    }, 4000);

    // ── Smooth scroll for anchor links ────────────────────
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>

</body>
</html>