@extends('admin.layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="mt-6 max-w-4xl">

    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800">My Profile</h2>
        <p class="text-sm text-gray-500">Your account information and system overview</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Left: Profile Card ── --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">

            {{-- Avatar --}}
            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <span class="text-white text-3xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </div>

            <h2 class="font-bold text-gray-800 text-xl">{{ $user->name }}</h2>
            <p class="text-gray-500 text-sm mt-1">{{ $user->email }}</p>

            {{-- Role Badge --}}
            <div class="mt-3 flex justify-center flex-wrap gap-2">
                @foreach($user->getRoleNames() as $role)
                    <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-medium capitalize">
                        <i class="fas fa-shield-alt"></i>
                        {{ str_replace('_', ' ', $role) }}
                    </span>
                @endforeach
            </div>

            <p class="text-gray-400 text-xs mt-3">
                <i class="fas fa-calendar mr-1"></i>
                Member since {{ $user->created_at->format('d M Y') }}
            </p>

            <div class="border-t border-gray-100 my-5"></div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-blue-50 rounded-xl p-3">
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['total_bookings'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        <i class="fas fa-calendar-check mr-1"></i>Bookings
                    </p>
                </div>
                <div class="bg-green-50 rounded-xl p-3">
                    <p class="text-2xl font-bold text-green-600">{{ $stats['total_customers'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        <i class="fas fa-users mr-1"></i>Customers
                    </p>
                </div>
                <div class="bg-purple-50 rounded-xl p-3">
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['today_arrivals'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        <i class="fas fa-plane-arrival mr-1"></i>Arrivals
                    </p>
                </div>
                <div class="bg-orange-50 rounded-xl p-3">
                    <p class="text-2xl font-bold text-orange-600">{{ $stats['today_departures'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        <i class="fas fa-plane-departure mr-1"></i>Departures
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-100 my-5"></div>

            {{-- Logout Button --}}
            <button onclick="openAdminLogoutModal()"
                    class="w-full flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 py-2.5 rounded-xl text-sm font-medium transition border border-red-100">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </button>

        </div>

        {{-- ── Right: Details ── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Account Information --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-5 flex items-center gap-2">
                    <i class="fas fa-user-circle text-blue-500"></i>
                    Account Information
                </h3>

                <div class="space-y-3">
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                        <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center shadow-sm flex-shrink-0">
                            <i class="fas fa-user text-blue-500 text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-400">Full Name</p>
                            <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                        <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center shadow-sm flex-shrink-0">
                            <i class="fas fa-envelope text-blue-500 text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-400">Email Address</p>
                            <p class="text-sm font-medium text-gray-800">{{ $user->email }}</p>
                        </div>
                        @if($user->email_verified_at)
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full flex-shrink-0">
                                <i class="fas fa-check-circle mr-1"></i>Verified
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                        <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center shadow-sm flex-shrink-0">
                            <i class="fas fa-shield-alt text-blue-500 text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-400">Role</p>
                            <p class="text-sm font-medium text-gray-800 capitalize">
                                {{ str_replace('_', ' ', $user->getRoleNames()->first()) }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                        <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center shadow-sm flex-shrink-0">
                            <i class="fas fa-calendar-alt text-blue-500 text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-400">Account Created</p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $user->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Permissions --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-key text-yellow-500"></i>
                    Your Permissions
                </h3>
                <div class="flex flex-wrap gap-2">
                    @forelse($user->getAllPermissions() as $permission)
                        <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-check text-green-500"></i>
                            {{ $permission->name }}
                        </span>
                    @empty
                        <p class="text-sm text-gray-400">No specific permissions assigned.</p>
                    @endforelse
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-bolt text-yellow-500"></i>
                    Quick Actions
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex flex-col items-center gap-2 p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition">
                        <i class="fas fa-tachometer-alt text-blue-600 text-xl"></i>
                        <span class="text-xs font-medium text-blue-700">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.bookings.index') }}"
                       class="flex flex-col items-center gap-2 p-4 bg-green-50 hover:bg-green-100 rounded-xl transition">
                        <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                        <span class="text-xs font-medium text-green-700">Bookings</span>
                    </a>
                    <a href="{{ route('admin.rooms.index') }}"
                       class="flex flex-col items-center gap-2 p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition">
                        <i class="fas fa-door-open text-purple-600 text-xl"></i>
                        <span class="text-xs font-medium text-purple-700">Rooms</span>
                    </a>
                    <a href="{{ route('admin.customers.index') }}"
                       class="flex flex-col items-center gap-2 p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition">
                        <i class="fas fa-users text-yellow-600 text-xl"></i>
                        <span class="text-xs font-medium text-yellow-700">Customers</span>
                    </a>
                    <a href="{{ route('admin.reports.revenue') }}"
                       class="flex flex-col items-center gap-2 p-4 bg-orange-50 hover:bg-orange-100 rounded-xl transition">
                        <i class="fas fa-chart-bar text-orange-600 text-xl"></i>
                        <span class="text-xs font-medium text-orange-700">Reports</span>
                    </a>
                    <button onclick="openAdminLogoutModal()"
                            class="flex flex-col items-center gap-2 p-4 bg-red-50 hover:bg-red-100 rounded-xl transition w-full">
                        <i class="fas fa-sign-out-alt text-red-600 text-xl"></i>
                        <span class="text-xs font-medium text-red-700">Logout</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection