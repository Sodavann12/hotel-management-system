@extends('guest.layouts.app')

@section('title', 'Complete Your Booking')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">

    {{-- Progress Steps --}}
    <div class="flex items-center justify-center gap-4 mb-10">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-yellow-500 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
            <span class="text-sm font-medium text-gray-800">Choose Room</span>
        </div>
        <div class="w-12 h-0.5 bg-yellow-300"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-yellow-500 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
            <span class="text-sm font-medium text-gray-800">Your Details</span>
        </div>
        <div class="w-12 h-0.5 bg-gray-200"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-gray-200 text-gray-400 rounded-full flex items-center justify-center text-sm font-bold">3</div>
            <span class="text-sm text-gray-400">Confirmed</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Booking Form --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-6">Complete Your Booking</h2>

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
                        <p class="text-red-700 text-sm font-medium mb-1">Please fix these errors:</p>
                        @foreach($errors->all() as $error)
                            <p class="text-red-600 text-sm">• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('guest.booking.store', $room) }}">
                    @csrf

                    {{-- Guest Info (read-only) --}}
                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <p class="text-xs text-gray-500 mb-2 font-medium">Booking for</p>
                        <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    </div>

                    {{-- Dates --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Check In <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="check_in"
                                   value="{{ old('check_in', $checkIn) }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('check_in') border-red-400 @enderror">
                            @error('check_in') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Check Out <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="check_out"
                                   value="{{ old('check_out', $checkOut) }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('check_out') border-red-400 @enderror">
                            @error('check_out') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Guests --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Number of Guests <span class="text-red-500">*</span>
                        </label>
                        <select name="guests"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            @for($i = 1; $i <= $room->roomType->max_occupancy; $i++)
                                <option value="{{ $i }}" {{ old('guests') == $i ? 'selected' : '' }}>
                                    {{ $i }} guest{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- Special Requests --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Special Requests <span class="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <textarea name="special_requests" rows="3"
                                  placeholder="Early check-in, extra pillows, dietary requirements..."
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('special_requests') }}</textarea>
                    </div>

                    {{-- Terms --}}
                    <div class="flex items-start gap-3 mb-6 p-4 bg-yellow-50 border border-yellow-100 rounded-xl">
                        <input type="checkbox" required id="terms" class="mt-0.5">
                        <label for="terms" class="text-sm text-gray-600">
                            I agree to the hotel's booking terms. Free cancellation is available before check-in date.
                            A 10% tax will be applied to the total.
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-xl font-semibold text-base transition">
                        <i class="fas fa-calendar-check mr-2"></i> Confirm Booking
                    </button>

                </form>
            </div>
        </div>

        {{-- Booking Summary --}}
        <div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-24">
                <h3 class="font-bold text-gray-800 mb-4">Booking Summary</h3>

                <div class="h-32 rounded-xl flex items-center justify-center mb-4"
                     style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%)">
                    <div class="text-center">
                        <i class="fas fa-bed text-4xl text-yellow-400 mb-1 block"></i>
                        <span class="text-white text-sm">Room {{ $room->number }}</span>
                    </div>
                </div>

                <h4 class="font-semibold text-gray-800">{{ $room->roomType->name }}</h4>
                <p class="text-sm text-gray-500 mb-4">Floor {{ $room->floor }}</p>

                <div class="space-y-2 text-sm border-t border-gray-100 pt-4">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Check in</span>
                        <span class="font-medium" id="summary-checkin">{{ \Carbon\Carbon::parse($checkIn)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Check out</span>
                        <span class="font-medium" id="summary-checkout">{{ \Carbon\Carbon::parse($checkOut)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Rate</span>
                        <span>${{ number_format($room->roomType->base_price, 2) }}/night</span>
                    </div>
                </div>

                <div class="bg-yellow-50 rounded-xl p-3 mt-4 text-center">
                    <p class="text-xs text-yellow-700">Final price calculated at checkout including applicable surcharges and 10% tax.</p>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection