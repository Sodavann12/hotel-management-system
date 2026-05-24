@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Available Rooms</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['available_rooms'] }}</p>
                <p class="text-xs text-gray-400 mt-1">of {{ $stats['total_rooms'] }} total</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-door-open text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Active Bookings</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['active_bookings'] }}</p>
                <p class="text-xs text-gray-400 mt-1">confirmed + checked in</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Today's Arrivals</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['today_arrivals'] }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ now()->format('d M Y') }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-plane-arrival text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Revenue This Month</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">${{ number_format($stats['revenue_this_month'], 2) }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ now()->format('F Y') }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>

</div>

{{-- Two column section --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

    {{-- Today's Arrivals --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Today's Arrivals</h2>
            <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full">
                {{ $todayArrivals->count() }} guests
            </span>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($todayArrivals as $booking)
                <div class="flex items-center justify-between px-6 py-3">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $booking->user->name }}</p>
                        <p class="text-xs text-gray-500">Room {{ $booking->room->number }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">{{ $booking->confirmation_code }}</p>
                        <form method="POST" action="{{ route('admin.bookings.check-in', $booking) }}">
                            @csrf
                            <button class="text-xs bg-green-500 text-white px-3 py-1 rounded-full mt-1 hover:bg-green-600">
                                Check In
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-gray-400">
                    <i class="fas fa-check-circle text-2xl mb-2 block"></i>
                    No arrivals today
                </div>
            @endforelse
        </div>
    </div>

    {{-- Today's Departures --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Today's Departures</h2>
            <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded-full">
                {{ $todayDepartures->count() }} guests
            </span>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($todayDepartures as $booking)
                <div class="flex items-center justify-between px-6 py-3">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $booking->user->name }}</p>
                        <p class="text-xs text-gray-500">Room {{ $booking->room->number }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">{{ $booking->confirmation_code }}</p>
                        <form method="POST" action="{{ route('admin.bookings.check-out', $booking) }}">
                            @csrf
                            <button class="text-xs bg-blue-500 text-white px-3 py-1 rounded-full mt-1 hover:bg-blue-600">
                                Check Out
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-gray-400">
                    <i class="fas fa-check-circle text-2xl mb-2 block"></i>
                    No departures today
                </div>
            @endforelse
        </div>
    </div>

</div>

{{-- Recent Bookings --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 mt-6">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h2 class="font-semibold text-gray-800">Recent Bookings</h2>
        <a href="{{ route('admin.bookings.index') }}"
           class="text-sm text-blue-600 hover:underline">View all</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Code</th>
                    <th class="px-6 py-3 text-left">Guest</th>
                    <th class="px-6 py-3 text-left">Room</th>
                    <th class="px-6 py-3 text-left">Check In</th>
                    <th class="px-6 py-3 text-left">Check Out</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentBookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-mono text-xs">{{ $booking->confirmation_code }}</td>
                        <td class="px-6 py-3">{{ $booking->user->name }}</td>
                        <td class="px-6 py-3">{{ $booking->room->number }}</td>
                        <td class="px-6 py-3">{{ $booking->check_in->format('d M Y') }}</td>
                        <td class="px-6 py-3">{{ $booking->check_out->format('d M Y') }}</td>
                        <td class="px-6 py-3">
                            @php
                                $colors = [
                                    'pending'     => 'bg-yellow-100 text-yellow-700',
                                    'confirmed'   => 'bg-blue-100 text-blue-700',
                                    'checked_in'  => 'bg-green-100 text-green-700',
                                    'checked_out' => 'bg-gray-100 text-gray-700',
                                    'cancelled'   => 'bg-red-100 text-red-700',
                                    'no_show'     => 'bg-red-100 text-red-700',
                                ];
                                $color = $colors[$booking->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs {{ $color }}">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-3">${{ number_format($booking->total_price, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                            No bookings yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection