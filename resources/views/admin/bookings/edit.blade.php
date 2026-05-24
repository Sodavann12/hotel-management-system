@extends('admin.layouts.app')

@section('title', 'Edit Booking')

@section('content')
<div class="mt-6 max-w-2xl">

    <div class="mb-6">
        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-sm text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left mr-1"></i> Back to Booking
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-1">Edit Booking</h2>
        <p class="text-sm text-gray-500 mb-6 font-mono">{{ $booking->confirmation_code }}</p>

        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Number of Guests</label>
                    <input type="number" name="guests" value="{{ old('guests', $booking->guests) }}"
                           min="1" max="10"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Special Requests</label>
                    <textarea name="special_requests" rows="3"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('special_requests', $booking->special_requests) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Internal Notes</label>
                    <textarea name="notes" rows="3"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $booking->notes) }}</textarea>
                </div>

            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">
                    Save Changes
                </button>
                <a href="{{ route('admin.bookings.show', $booking) }}"
                   class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>
@endsection