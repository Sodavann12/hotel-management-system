@extends('guest.layouts.app')

@section('title', 'Browse Rooms')

@section('content')

{{-- Hero --}}
<div style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%)" class="py-16 text-center">
    <p class="text-yellow-400 text-sm font-medium tracking-widest uppercase mb-2">Find Your Perfect Room</p>
    <h1 class="text-4xl font-bold text-white mb-4">Browse Our Rooms</h1>
    <p class="text-gray-300 max-w-xl mx-auto">Choose from our selection of luxury rooms and suites</p>
</div>

{{-- Filter Bar --}}
<div class="bg-white border-b border-gray-200 sticky top-16 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <form method="GET" action="{{ route('rooms.index') }}" class="flex flex-wrap gap-3 items-end">

            <div>
                <label class="block text-xs text-gray-500 mb-1">Check In</label>
                <input type="date" name="check_in" value="{{ request('check_in') }}"
                       min="{{ date('Y-m-d') }}"
                       class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Check Out</label>
                <input type="date" name="check_out" value="{{ request('check_out') }}"
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Guests</label>
                <select name="guests" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="">Any</option>
                    @for($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" {{ request('guests') == $i ? 'selected' : '' }}>{{ $i }} guest{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Room Type</label>
                <select name="type" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="">All types</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                <i class="fas fa-search mr-1"></i> Search
            </button>

            <a href="{{ route('rooms.index') }}" class="text-gray-500 hover:text-gray-700 text-sm py-2">Clear</a>

        </form>
    </div>
</div>

{{-- Rooms Grid --}}
<div class="max-w-7xl mx-auto px-6 py-10">

    @if(request('check_in') && request('check_out'))
        <p class="text-sm text-gray-500 mb-6">
            Showing available rooms for
            <strong>{{ \Carbon\Carbon::parse(request('check_in'))->format('d M Y') }}</strong>
            to
            <strong>{{ \Carbon\Carbon::parse(request('check_out'))->format('d M Y') }}</strong>
        </p>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($rooms as $room)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">

                {{-- Room Image Placeholder --}}
                <div class="h-48 flex items-center justify-center relative"
                     style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%)">
                    <i class="fas fa-bed text-6xl text-yellow-400 opacity-70"></i>
                    <div class="absolute top-3 left-3">
                        <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                            Available
                        </span>
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded-full">
                            Room {{ $room->number }}
                        </span>
                    </div>
                </div>

                <div class="p-5">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">{{ $room->roomType->name }}</h3>
                            <p class="text-gray-500 text-xs">Floor {{ $room->floor }} · Max {{ $room->roomType->max_occupancy }} guests</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-yellow-600">${{ number_format($room->roomType->base_price, 0) }}</p>
                            <p class="text-xs text-gray-400">per night</p>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $room->roomType->description }}</p>

                    @if($room->roomType->amenities)
                        <div class="flex flex-wrap gap-1 mb-4">
                            @foreach(array_slice($room->roomType->amenities, 0, 4) as $amenity)
                                <span class="text-xs bg-yellow-50 text-yellow-700 px-2 py-0.5 rounded-full border border-yellow-100">
                                    {{ $amenity }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex gap-2">
                        <a href="{{ route('rooms.show', $room) }}"
                           class="flex-1 text-center border border-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
                            View Details
                        </a>
                        <a href="{{ route('guest.booking.create', array_merge(['room' => $room->id], request()->only('check_in', 'check_out'))) }}"
                           class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16">
                <i class="fas fa-door-open text-5xl text-gray-300 mb-4 block"></i>
                <h3 class="text-gray-500 text-lg font-medium">No rooms available</h3>
                <p class="text-gray-400 text-sm mt-1">Try different dates or room type</p>
                <a href="{{ route('rooms.index') }}" class="text-yellow-600 text-sm mt-3 inline-block hover:underline">
                    Clear filters
                </a>
            </div>
        @endforelse
    </div>

</div>

@endsection
