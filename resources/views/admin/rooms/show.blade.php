@extends('admin.layouts.app')

@section('title', 'Room ' . $room->number)

@section('content')
<div class="mt-6">

    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.rooms.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left mr-1"></i> Back to Rooms
        </a>
        <a href="{{ route('admin.rooms.edit', $room) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            <i class="fas fa-edit mr-1"></i> Edit Room
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Room Info --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-4xl font-bold text-gray-800 mb-1">Room {{ $room->number }}</h2>
            <p class="text-gray-500 text-sm mb-4">Floor {{ $room->floor }}</p>

            @php
                $colors = [
                    'available'   => 'bg-green-100 text-green-700',
                    'occupied'    => 'bg-red-100 text-red-700',
                    'reserved'    => 'bg-blue-100 text-blue-700',
                    'dirty'       => 'bg-yellow-100 text-yellow-700',
                    'maintenance' => 'bg-orange-100 text-orange-700',
                    'out_of_order'=> 'bg-gray-100 text-gray-700',
                ];
            @endphp

            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $colors[$room->status] ?? 'bg-gray-100 text-gray-700' }}">
                {{ ucfirst(str_replace('_', ' ', $room->status)) }}
            </span>

            <div class="mt-6 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Type</span>
                    <span class="font-medium">{{ $room->roomType->name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Price per night</span>
                    <span class="font-medium">${{ number_format($room->roomType->base_price, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Max occupancy</span>
                    <span class="font-medium">{{ $room->roomType->max_occupancy }} guests</span>
                </div>
            </div>

            @if($room->roomType->amenities)
                <div class="mt-4">
                    <p class="text-xs text-gray-500 mb-2">Amenities</p>
                    <div class="flex flex-wrap gap-1">
                        @foreach($room->roomType->amenities as $amenity)
                            <span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded">{{ $amenity }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($room->notes)
                <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500 mb-1">Notes</p>
                    <p class="text-sm text-gray-700">{{ $room->notes }}</p>
                </div>
            @endif
        </div>

        {{-- Recent Bookings --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Booking History</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($room->bookings->take(8) as $booking)
                    <div class="flex items-center justify-between px-6 py-3">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $booking->user->name }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $booking->check_in->format('d M Y') }} → {{ $booking->check_out->format('d M Y') }}
                                · {{ $booking->nights }} nights
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium">${{ number_format($booking->total_price, 2) }}</p>
                            <span class="text-xs text-gray-500">{{ $booking->confirmation_code }}</span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-gray-400 text-sm">
                        No booking history for this room.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection