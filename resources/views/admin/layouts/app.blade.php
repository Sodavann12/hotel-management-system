<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
<body class="bg-gray-100 font-sans">

{{-- ══════════════════════════════════════════
     LOGOUT MODAL
══════════════════════════════════════════ --}}
<div class="modal-overlay" id="adminLogoutModal">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-sign-out-alt text-red-500 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Logging Out</h3>
        <p class="text-gray-500 text-sm mb-6">
            Are you sure you want to log out of the admin panel?
        </p>
        <div class="flex gap-3">
            <button onclick="closeAdminLogoutModal()"
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

<div class="flex h-screen overflow-hidden">

    {{-- ══════════════════════════════════════════
         SIDEBAR
    ══════════════════════════════════════════ --}}
    <aside class="w-64 bg-gray-900 text-white flex flex-col flex-shrink-0">

        {{-- Logo --}}
        <div class="flex items-center justify-center h-16 bg-gray-800 border-b border-gray-700">
            <i class="fas fa-hotel text-blue-400 text-xl mr-2"></i>
            <span class="text-white font-bold text-lg">Hotel Admin</span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-4">

            <div class="px-4 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Main</p>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-4 py-2.5 text-sm transition
               {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-tachometer-alt w-5 mr-3"></i> Dashboard
            </a>

            <div class="px-4 mt-4 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Rooms</p>
            </div>

            <a href="{{ route('admin.rooms.index') }}"
               class="flex items-center px-4 py-2.5 text-sm transition
               {{ request()->routeIs('admin.rooms.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-door-open w-5 mr-3"></i> Rooms
            </a>

            <a href="{{ route('admin.room-types.index') }}"
               class="flex items-center px-4 py-2.5 text-sm transition
               {{ request()->routeIs('admin.room-types.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-layer-group w-5 mr-3"></i> Room Types
            </a>

            <div class="px-4 mt-4 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Reservations</p>
            </div>

            <a href="{{ route('admin.bookings.index') }}"
               class="flex items-center px-4 py-2.5 text-sm transition
               {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-calendar-check w-5 mr-3"></i> Bookings
            </a>

            <a href="{{ route('admin.customers.index') }}"
               class="flex items-center px-4 py-2.5 text-sm transition
               {{ request()->routeIs('admin.customers.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-users w-5 mr-3"></i> Customers
            </a>

            <div class="px-4 mt-4 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Finance</p>
            </div>

            <a href="{{ route('admin.invoices.index') }}"
               class="flex items-center px-4 py-2.5 text-sm transition
               {{ request()->routeIs('admin.invoices.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-file-invoice w-5 mr-3"></i> Invoices
            </a>

            <div class="px-4 mt-4 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Operations</p>
            </div>

            <a href="{{ route('admin.staff.index') }}"
               class="flex items-center px-4 py-2.5 text-sm transition
               {{ request()->routeIs('admin.staff.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-user-tie w-5 mr-3"></i> Staff
            </a>

            <a href="{{ route('admin.housekeeping.index') }}"
               class="flex items-center px-4 py-2.5 text-sm transition
               {{ request()->routeIs('admin.housekeeping.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-broom w-5 mr-3"></i> Housekeeping
            </a>

            <div class="px-4 mt-4 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Analytics</p>
            </div>

            <a href="{{ route('admin.reports.occupancy') }}"
               class="flex items-center px-4 py-2.5 text-sm transition
               {{ request()->routeIs('admin.reports.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-chart-bar w-5 mr-3"></i> Reports
            </a>

        </nav>

        {{-- Sidebar bottom — user info + logout --}}
        <div class="border-t border-gray-700 p-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-sm font-bold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate capitalize">
                        {{ str_replace('_', ' ', auth()->user()->getRoleNames()->first()) }}
                    </p>
                </div>
                {{-- Logout icon in sidebar --}}
                <button onclick="openAdminLogoutModal()"
                        title="Logout"
                        class="text-gray-400 hover:text-red-400 transition flex-shrink-0">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </div>

    </aside>

    {{-- ══════════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════════ --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Bar --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0">

            <h1 class="text-xl font-semibold text-gray-800">
                @yield('title', 'Dashboard')
            </h1>

            <div class="flex items-center gap-4">

                {{-- Date --}}
                <div class="hidden md:flex items-center gap-2 text-sm text-gray-500">
                    <i class="fas fa-clock"></i>
                    <span>{{ now()->format('D, d M Y') }}</span>
                </div>

                {{-- Profile Dropdown --}}
                <div class="relative" id="adminProfileDropdown">
                    <button onclick="toggleAdminDropdown()"
                            class="flex items-center gap-2.5 hover:opacity-80 transition focus:outline-none">
                        <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center shadow">
                            <span class="text-white text-sm font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-semibold text-gray-800 leading-none">
                                {{ explode(' ', auth()->user()->name)[0] }}
                            </p>
                            <p class="text-xs text-gray-400 capitalize">
                                {{ str_replace('_', ' ', auth()->user()->getRoleNames()->first()) }}
                            </p>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-gray-400 ml-1 transition-transform" id="adminChevron"></i>
                    </button>

                    {{-- Dropdown --}}
                    <div class="dropdown-menu" id="adminDropdownMenu">

                        {{-- User info header --}}
                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 rounded-t-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">
                                        {{ auth()->user()->name }}
                                    </p>
                                    <p class="text-xs text-gray-400 truncate">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Menu links --}}
                        <div class="py-1">
                            <a href="{{ route('admin.profile') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                                <i class="fas fa-user text-gray-400 w-4 text-center"></i>
                                My Profile
                            </a>
                            <a href="{{ route('admin.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                                <i class="fas fa-tachometer-alt text-gray-400 w-4 text-center"></i>
                                Dashboard
                            </a>
                            <a href="{{ url('/') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                                <i class="fas fa-home text-gray-400 w-4 text-center"></i>
                                View Website
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <button onclick="openAdminLogoutModal()"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 w-full text-left transition rounded-b-xl">
                                <i class="fas fa-sign-out-alt text-red-400 w-4 text-center"></i>
                                Logout
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2 mb-4">
                    <i class="fas fa-check-circle text-green-500"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error') || $errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2 mb-4">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    {{ session('error') ?? $errors->first() }}
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto px-6 pb-6">
            @yield('content')
        </main>

    </div>
</div>

{{-- ══════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════ --}}
<script>
    // ── Profile Dropdown ──────────────────────
    function toggleAdminDropdown() {
        const menu    = document.getElementById('adminDropdownMenu');
        const chevron = document.getElementById('adminChevron');
        menu.classList.toggle('open');
        chevron.style.transform = menu.classList.contains('open')
            ? 'rotate(180deg)' : 'rotate(0deg)';
    }

    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('adminProfileDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            document.getElementById('adminDropdownMenu').classList.remove('open');
            document.getElementById('adminChevron').style.transform = 'rotate(0deg)';
        }
    });

    // ── Logout Modal ──────────────────────────
    function openAdminLogoutModal() {
        document.getElementById('adminDropdownMenu').classList.remove('open');
        document.getElementById('adminLogoutModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeAdminLogoutModal() {
        document.getElementById('adminLogoutModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    document.getElementById('adminLogoutModal').addEventListener('click', function(e) {
        if (e.target === this) closeAdminLogoutModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAdminLogoutModal();
    });
</script>

</body>
</html>