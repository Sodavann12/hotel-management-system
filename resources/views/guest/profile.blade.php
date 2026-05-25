@extends('guest.layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">

    <h1 class="text-2xl font-bold text-gray-800 mb-8">My Profile</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Profile Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-yellow-700 text-3xl font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
            </div>
            <h2 class="font-bold text-gray-800 text-xl">{{ auth()->user()->name }}</h2>
            <p class="text-gray-500 text-sm mt-1">{{ auth()->user()->email }}</p>
            <p class="text-gray-400 text-xs mt-1">Member since {{ auth()->user()->created_at->format('M Y') }}</p>

            <div class="grid grid-cols-2 gap-3 mt-6">
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_bookings'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Total bookings</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['completed_stays'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Completed stays</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-2xl font-bold text-green-600">{{ $stats['active_bookings'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Active bookings</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xl font-bold text-yellow-600">${{ number_format($stats['total_spent'], 0) }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Total spent</p>
                </div>
            </div>

            <a href="{{ route('guest.bookings') }}"
               class="mt-5 w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-xl text-sm font-medium transition block">
                View All Bookings
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button class="w-full text-gray-400 hover:text-gray-600 py-2 text-sm transition">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </button>
            </form>
        </div>

        {{-- Recent Bookings --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Recent Bookings</h3>
                <a href="{{ route('guest.bookings') }}" class="text-sm text-yellow-600 hover:underline">View all</a>
            </div>

            <div class="divide-y divide-gray-50">
                @forelse($recentBookings as $booking)
                    @php
                        $colors = [
                            'confirmed'   => 'bg-blue-100 text-blue-700',
                            'checked_in'  => 'bg-green-100 text-green-700',
                            'checked_out' => 'bg-gray-100 text-gray-600',
                            'cancelled'   => 'bg-red-100 text-red-700',
                            'pending'     => 'bg-yellow-100 text-yellow-700',
                        ];
                    @endphp
                    <div class="flex items-center justify-between px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                                 style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%)">
                                <i class="fas fa-bed text-yellow-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $booking->room->roomType->name }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $booking->check_in->format('d M') }} → {{ $booking->check_out->format('d M Y') }}
                                    · {{ $booking->nights }} nights
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800">${{ number_format($booking->total_price, 2) }}</p>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $colors[$booking->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-gray-400 text-sm">
                        No bookings yet.
                        <a href="{{ route('rooms.index') }}" class="text-yellow-600 hover:underline ml-1">Book a room</a>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection