<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
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
               class="flex items-center px-4 py-2.5 text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-tachometer-alt w-5 mr-3"></i> Dashboard
            </a>

            <div class="px-4 mt-4 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Rooms</p>
            </div>

            <a href="{{ route('admin.rooms.index') }}"
               class="flex items-center px-4 py-2.5 text-sm {{ request()->routeIs('admin.rooms.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-door-open w-5 mr-3"></i> Rooms
            </a>

            <a href="{{ route('admin.room-types.index') }}"
               class="flex items-center px-4 py-2.5 text-sm {{ request()->routeIs('admin.room-types.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-layer-group w-5 mr-3"></i> Room Types
            </a>

            <div class="px-4 mt-4 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Reservations</p>
            </div>

            <a href="{{ route('admin.bookings.index') }}"
               class="flex items-center px-4 py-2.5 text-sm {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-calendar-check w-5 mr-3"></i> Bookings
            </a>

            <a href="{{ route('admin.customers.index') }}"
               class="flex items-center px-4 py-2.5 text-sm {{ request()->routeIs('admin.customers.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-users w-5 mr-3"></i> Customers
            </a>

            <div class="px-4 mt-4 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Finance</p>
            </div>

            <a href="{{ route('admin.invoices.index') }}"
               class="flex items-center px-4 py-2.5 text-sm {{ request()->routeIs('admin.invoices.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-file-invoice w-5 mr-3"></i> Invoices
            </a>

            <div class="px-4 mt-4 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Operations</p>
            </div>

            <a href="{{ route('admin.staff.index') }}"
               class="flex items-center px-4 py-2.5 text-sm {{ request()->routeIs('admin.staff.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-user-tie w-5 mr-3"></i> Staff
            </a>

            <a href="{{ route('admin.housekeeping.index') }}"
               class="flex items-center px-4 py-2.5 text-sm {{ request()->routeIs('admin.housekeeping.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-broom w-5 mr-3"></i> Housekeeping
            </a>

            <div class="px-4 mt-4 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Analytics</p>
            </div>

            <a href="{{ route('admin.reports.occupancy') }}"
               class="flex items-center px-4 py-2.5 text-sm {{ request()->routeIs('admin.reports.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                <i class="fas fa-chart-bar w-5 mr-3"></i> Reports
            </a>

        </nav>

        {{-- User info at bottom --}}
        <div class="border-t border-gray-700 p-4">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-sm font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-white ml-2" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    {{-- Main content --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top bar --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0">
            <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
            <div class="flex items-center gap-3 text-sm text-gray-500">
                <i class="fas fa-clock"></i>
                <span>{{ now()->format('D, d M Y') }}</span>
            </div>
        </header>

        {{-- Flash messages --}}
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

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto px-6 pb-6">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>