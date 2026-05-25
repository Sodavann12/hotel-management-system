@extends('guest.layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">My Bookings</h1>
            <p class="text-gray-500 text-sm mt-1">All your reservations at Grand Hotel</p>
        </div>
        <a href="{{ route('rooms.index') }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
            <i class="fas fa-plus mr-1"></i> New Booking
        </a>
    </div>

    @forelse($bookings as $booking)
        @php
            $colors = [
                'pending'     => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                'confirmed'   => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700'],
                'checked_in'  => ['bg' => 'bg-green-100',  'text' => 'text-green-700'],
                'checked_out' => ['bg' => 'bg-gray-100',   'text' => 'text-gray-600'],
                'cancelled'   => ['bg' => 'bg-red-100',    'text' => 'text-red-700'],
            ];
            $color = $colors[$booking->status] ?? $colors['pending'];
        @endphp

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-4">
            <div class="flex flex-col md:flex-row">

                {{-- Room visual --}}
                <div class="w-full md:w-48 h-32 md:h-auto flex items-center justify-center flex-shrink-0"
                     style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%)">
                    <div class="text-center">
                        <i class="fas fa-bed text-3xl text-yellow-400 block mb-1"></i>
                        <span class="text-white text-xs">Room {{ $booking->room->number }}</span>
                    </div>
                </div>

                {{-- Booking info --}}
                <div class="flex-1 p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="font-bold text-gray-800">{{ $booking->room->roomType->name }}</h3>
                            <p class="text-sm text-gray-500 font-mono">{{ $booking->confirmation_code }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $color['bg'] }} {{ $color['text'] }}">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="text-xs text-gray-400">Check In</p>
                            <p class="text-sm font-medium text-gray-700">{{ $booking->check_in->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Check Out</p>
                            <p class="text-sm font-medium text-gray-700">{{ $booking->check_out->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Duration</p>
                            <p class="text-sm font-medium text-gray-700">{{ $booking->nights }} nights</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="font-bold text-gray-800">${{ number_format($booking->total_price, 2) }}</p>
                        @if(in_array($booking->status, ['confirmed', 'pending']))
                            <form method="POST" action="{{ route('guest.booking.cancel', $booking) }}"
                                  onsubmit="return confirm('Cancel this booking? This cannot be undone.')">
                                @csrf
                                <button class="text-sm text-red-500 hover:text-red-700 transition border border-red-200 hover:border-red-400 px-3 py-1 rounded-lg">
                                    <i class="fas fa-times mr-1"></i> Cancel
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    @empty
        <div class="text-center py-16">
            <i class="fas fa-calendar-times text-5xl text-gray-300 mb-4 block"></i>
            <h3 class="text-gray-500 text-lg font-medium">No bookings yet</h3>
            <p class="text-gray-400 text-sm mt-1">Book your first stay at Grand Hotel</p>
            <a href="{{ route('rooms.index') }}"
               class="mt-4 inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                Browse Rooms
            </a>
        </div>
    @endforelse

    @if($bookings->hasPages())
        <div class="mt-6">{{ $bookings->links() }}</div>
    @endif

</div>
@endsection