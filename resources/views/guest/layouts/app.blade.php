<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Hotel — @yield('title', 'Book Your Stay')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .nav-bg { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); }
        .gold { color: #D4AF37; }
        .bg-gold { background-color: #D4AF37; }
        .hover-gold:hover { background-color: #B8960C; }
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.active { display: flex; }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    {{-- ── Logout Confirmation Modal ── --}}
    <div class="modal-overlay" id="logoutModal">
        <div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full mx-4 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-sign-out-alt text-red-500 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Logging Out</h3>
            <p class="text-gray-500 text-sm mb-6">Are you sure you want to log out of Grand Hotel?</p>
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

    {{-- ── Navigation ── --}}
    <nav class="nav-bg shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gold rounded-full flex items-center justify-center">
                    <i class="fas fa-hotel text-white"></i>
                </div>
                <div>
                    <span class="text-white font-bold text-lg leading-none">Grand Hotel</span>
                    <p class="text-yellow-400 text-xs">Luxury & Comfort</p>
                </div>
            </a>

            {{-- Nav Links --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ url('/') }}"
                   class="text-gray-300 hover:text-white text-sm transition flex items-center gap-1.5
                   {{ request()->is('/') ? 'text-white' : '' }}">
                    <i class="fas fa-home text-xs"></i> Home
                </a>
                <a href="{{ route('rooms.index') }}"
                   class="text-gray-300 hover:text-white text-sm transition flex items-center gap-1.5
                   {{ request()->routeIs('rooms.*') ? 'text-white' : '' }}">
                    <i class="fas fa-door-open text-xs"></i> Rooms
                </a>
                @auth
                    <a href="{{ route('guest.bookings') }}"
                       class="text-gray-300 hover:text-white text-sm transition flex items-center gap-1.5
                       {{ request()->routeIs('guest.bookings') ? 'text-white' : '' }}">
                        <i class="fas fa-calendar-check text-xs"></i> My Bookings
                    </a>
                @endauth
            </div>

            {{-- Right Side — Auth --}}
            <div class="flex items-center gap-3">
                @auth
                    {{-- User Profile Dropdown --}}
                    <div class="relative" id="profileDropdown">
                        <button onclick="toggleDropdown()"
                                class="flex items-center gap-2 text-white hover:text-yellow-400 transition">
                            {{-- Avatar --}}
                            <div class="w-9 h-9 bg-yellow-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-white leading-none">
                                    {{ explode(' ', auth()->user()->name)[0] }}
                                </p>
                                <p class="text-xs text-gray-400">Guest</p>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div id="dropdownMenu"
                             class="hidden absolute right-0 top-12 bg-white rounded-xl shadow-xl border border-gray-100 w-52 py-2 z-50">

                            {{-- User Info --}}
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            {{-- Links --}}
                            <a href="{{ route('guest.profile') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <i class="fas fa-user text-gray-400 w-4"></i> My Profile
                            </a>
                            <a href="{{ route('guest.bookings') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <i class="fas fa-calendar-check text-gray-400 w-4"></i> My Bookings
                            </a>

                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <button onclick="openLogoutModal()"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 w-full text-left transition">
                                    <i class="fas fa-sign-out-alt text-red-400 w-4"></i> Logout
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Not logged in — show Login button --}}
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-2 text-gray-300 hover:text-white text-sm transition">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="hidden md:inline">Login</span>
                    </a>
                    <a href="{{ route('register') }}"
                       class="flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        <i class="fas fa-user-plus"></i>
                        <span>Register</span>
                    </a>
                @endauth
            </div>

        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-50 border-b border-green-200 px-6 py-3 text-green-800 text-sm flex items-center gap-2">
            <i class="fas fa-check-circle text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error') || $errors->any())
        <div class="bg-red-50 border-b border-red-200 px-6 py-3 text-red-800 text-sm flex items-center gap-2">
            <i class="fas fa-exclamation-circle text-red-500"></i>
            {{ session('error') ?? $errors->first() }}
        </div>
    @endif

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-10 mt-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-gold rounded-full flex items-center justify-center">
                            <i class="fas fa-hotel text-white text-sm"></i>
                        </div>
                        <span class="text-white font-bold">Grand Hotel</span>
                    </div>
                    <p class="text-sm leading-relaxed">Experience luxury and comfort at its finest.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">
                        <i class="fas fa-link mr-2 text-yellow-500"></i>Quick Links
                    </h4>
                    <div class="space-y-2 text-sm">
                        <a href="{{ url('/') }}" class="flex items-center gap-2 hover:text-white transition">
                            <i class="fas fa-home text-xs"></i> Home
                        </a>
                        <a href="{{ route('rooms.index') }}" class="flex items-center gap-2 hover:text-white transition">
                            <i class="fas fa-door-open text-xs"></i> Browse Rooms
                        </a>
                        @auth
                            <a href="{{ route('guest.bookings') }}" class="flex items-center gap-2 hover:text-white transition">
                                <i class="fas fa-calendar-check text-xs"></i> My Bookings
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center gap-2 hover:text-white transition">
                                <i class="fas fa-sign-in-alt text-xs"></i> Login
                            </a>
                        @endauth
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">
                        <i class="fas fa-headset mr-2 text-yellow-500"></i>Contact
                    </h4>
                    <div class="space-y-2 text-sm">
                        <p class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-yellow-500"></i> Phnom Penh, Cambodia
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-phone text-yellow-500"></i> +855 12 345 678
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-envelope text-yellow-500"></i> info@grandhotel.com
                        </p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-6 text-center text-sm">
                © {{ date('Y') }} Grand Hotel — Royal University of Phnom Penh
            </div>
        </div>
    </footer>

    {{-- JavaScript --}}
    <script>
        // Dropdown toggle
        function toggleDropdown() {
            document.getElementById('dropdownMenu').classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                document.getElementById('dropdownMenu').classList.add('hidden');
            }
        });

        // Logout modal
        function openLogoutModal() {
            document.getElementById('dropdownMenu').classList.add('hidden');
            document.getElementById('logoutModal').classList.add('active');
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.remove('active');
        }

        // Close modal on overlay click
        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) closeLogoutModal();
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLogoutModal();
        });
    </script>

</body>
</html>