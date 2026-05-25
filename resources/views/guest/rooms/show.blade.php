@extends('guest.layouts.app')

@section('title', $room->roomType->name . ' - Room ' . $room->number)

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    {{-- Back --}}
    <a href="{{ route('rooms.index') }}" class="text-sm text-gray-500 hover:text-gray-700 mb-6 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Back to all rooms
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left — Room Info --}}
        <div class="lg:col-span-2">

            {{-- Room Image --}}
            <div class="h-72 rounded-2xl flex items-center justify-center mb-6"
                 style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%)">
                <div class="text-center">
                    <i class="fas fa-bed text-8xl text-yellow-400 opacity-70 block mb-3"></i>
                    <span class="text-white text-lg font-medium">Room {{ $room->number }}</span>
                </div>
            </div>

            {{-- Details --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $room->roomType->name }}</h1>
                        <p class="text-gray-500">Room {{ $room->number }} · Floor {{ $room->floor }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-yellow-600">${{ number_format($room->roomType->base_price, 2) }}</p>
                        <p class="text-gray-400 text-sm">per night</p>
                    </div>
                </div>

                <p class="text-gray-600 leading-relaxed mb-6">{{ $room->roomType->description }}</p>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <i class="fas fa-users text-yellow-500 text-xl mb-2 block"></i>
                        <p class="text-sm font-medium text-gray-800">Max {{ $room->roomType->max_occupancy }} guests</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <i class="fas fa-layer-group text-yellow-500 text-xl mb-2 block"></i>
                        <p class="text-sm font-medium text-gray-800">Floor {{ $room->floor }}</p>
                    </div>
                </div>

                @if($room->roomType->amenities)
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-3">Amenities</h3>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($room->roomType->amenities as $amenity)
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="fas fa-check text-green-500 text-xs"></i>
                                    {{ $amenity }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Policies --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6">
                <h3 class="font-semibold text-blue-800 mb-3">
                    <i class="fas fa-info-circle mr-2"></i>Hotel Policies
                </h3>
                <div class="space-y-2 text-sm text-blue-700">
                    <p><i class="fas fa-clock mr-2"></i>Check-in: 2:00 PM · Check-out: 12:00 PM</p>
                    <p><i class="fas fa-ban mr-2"></i>No smoking in rooms</p>
                    <p><i class="fas fa-paw mr-2"></i>No pets allowed</p>
                    <p><i class="fas fa-percentage mr-2"></i>10% tax applied to all bookings</p>
                    <p><i class="fas fa-calendar-times mr-2"></i>Free cancellation before check-in</p>
                </div>
            </div>

        </div>

        {{-- Right — Booking Form --}}
        <div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-24">
                <h3 class="font-bold text-gray-800 text-lg mb-5">Book This Room</h3>

                <form method="GET" action="{{ route('guest.booking.create', $room) }}">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Check In</label>
                        <input type="date" name="check_in"
                               value="{{ request('check_in', now()->addDay()->format('Y-m-d')) }}"
                               min="{{ date('Y-m-d') }}"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Check Out</label>
                        <input type="date" name="check_out"
                               value="{{ request('check_out', now()->addDays(2)->format('Y-m-d')) }}"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Guests</label>
                        <select name="guests" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            @for($i = 1; $i <= $room->roomType->max_occupancy; $i++)
                                <option value="{{ $i }}">{{ $i }} guest{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 mb-5">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-500">Base rate</span>
                            <span>${{ number_format($room->roomType->base_price, 2) }}/night</span>
                        </div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-500">Tax</span>
                            <span>10%</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-400">
                            <span>Weekend surcharge</span>
                            <span>+20% (Fri/Sat)</span>
                        </div>
                    </div>

                    @auth
                        <button type="submit"
                                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-xl font-semibold transition">
                            <i class="fas fa-calendar-check mr-2"></i> Continue to Book
                        </button>
                    @else
                        <a href="{{ route('login') }}"
                           class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-xl font-semibold transition block text-center">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login to Book
                        </a>
                        <p class="text-center text-xs text-gray-400 mt-2">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-yellow-600 hover:underline">Register free</a>
                        </p>
                    @endauth

                </form>
            </div>
        </div>

    </div>

</div>
@endsection