@extends('admin.layouts.app')

@section('title', 'New Booking')

@section('content')
<div class="mt-6 max-w-3xl">

    <div class="mb-6">
        <a href="{{ route('admin.bookings.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left mr-1"></i> Back to Bookings
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Create New Booking</h2>

        <form method="POST" action="{{ route('admin.bookings.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Guest --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Guest <span class="text-red-500">*</span></label>
                    <select name="user_id"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-400 @enderror">
                        <option value="">Select guest</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} — {{ $customer->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Room --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Room <span class="text-red-500">*</span></label>
                    <select name="room_id"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('room_id') border-red-400 @enderror">
                        <option value="">Select room</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                Room {{ $room->number }} — {{ $room->roomType->name }} (${{ number_format($room->roomType->base_price, 2) }}/night)
                            </option>
                        @endforeach
                    </select>
                    @error('room_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Check In --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Check In <span class="text-red-500">*</span></label>
                    <input type="date" name="check_in" value="{{ old('check_in') }}"
                           min="{{ date('Y-m-d') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('check_in') border-red-400 @enderror">
                    @error('check_in') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Check Out --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Check Out <span class="text-red-500">*</span></label>
                    <input type="date" name="check_out" value="{{ old('check_out') }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('check_out') border-red-400 @enderror">
                    @error('check_out') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Guests --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Number of Guests <span class="text-red-500">*</span></label>
                    <input type="number" name="guests" value="{{ old('guests', 1) }}"
                           min="1" max="10"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('guests') border-red-400 @enderror">
                    @error('guests') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

            </div>

            {{-- Special Requests --}}
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Special Requests</label>
                <textarea name="special_requests" rows="3"
                          placeholder="Any special requests from the guest..."
                          class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('special_requests') }}</textarea>
            </div>

            {{-- Info box --}}
            <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                <p class="text-xs text-blue-700">
                    <i class="fas fa-info-circle mr-1"></i>
                    The total price will be calculated automatically based on the room rate and number of nights.
                    Weekend nights (Friday & Saturday) have a 20% surcharge.
                </p>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">
                    <i class="fas fa-calendar-check mr-1"></i> Create Booking
                </button>
                <a href="{{ route('admin.bookings.index') }}"
                   class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>
@endsection