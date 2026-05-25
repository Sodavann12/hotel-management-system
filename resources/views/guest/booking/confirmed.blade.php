@extends('guest.layouts.app')

@section('title', 'Booking Confirmed!')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-16 text-center">

    {{-- Success Icon --}}
    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <i class="fas fa-check text-green-600 text-3xl"></i>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-2">Booking Confirmed!</h1>
    <p class="text-gray-500 mb-8">Your reservation has been successfully created.</p>

    {{-- Confirmation Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-left mb-8">

        <div class="text-center mb-6 pb-6 border-b border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Confirmation Code</p>
            <p class="text-3xl font-bold font-mono text-yellow-600">{{ $booking->confirmation_code }}</p>
            <p class="text-xs text-gray-400 mt-1">Save this code for your records</p>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-xs text-gray-400 uppercase mb-1">Guest</p>
                <p class="font-semibold text-gray-800">{{ $booking->user->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase mb-1">Room</p>
                <p class="font-semibold text-gray-800">Room {{ $booking->room->number }}</p>
                <p class="text-sm text-gray-500">{{ $booking->room->roomType->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase mb-1">Check In</p>
                <p class="font-semibold text-gray-800">{{ $booking->check_in->format('D, d M Y') }}</p>
                <p class="text-xs text-gray-400">From 2:00 PM</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase mb-1">Check Out</p>
                <p class="font-semibold text-gray-800">{{ $booking->check_out->format('D, d M Y') }}</p>
                <p class="text-xs text-gray-400">Before 12:00 PM</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase mb-1">Duration</p>
                <p class="font-semibold text-gray-800">{{ $booking->nights }} nights</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase mb-1">Guests</p>
                <p class="font-semibold text-gray-800">{{ $booking->guests }} guest{{ $booking->guests > 1 ? 's' : '' }}</p>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100 flex justify-between items-center">
            <div>
                <p class="text-xs text-gray-400 uppercase mb-1">Total Price</p>
                <p class="text-2xl font-bold text-gray-800">${{ number_format($booking->total_price, 2) }}</p>
                <p class="text-xs text-gray-400">Payable at hotel</p>
            </div>
            <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-medium">
                Confirmed
            </span>
        </div>

        @if($booking->special_requests)
            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-100 rounded-xl">
                <p class="text-xs text-yellow-700 font-medium mb-1">Your Special Requests</p>
                <p class="text-sm text-yellow-800">{{ $booking->special_requests }}</p>
            </div>
        @endif

    </div>

    {{-- Next Steps --}}
    <div class="bg-gray-50 rounded-2xl p-6 text-left mb-8">
        <h3 class="font-semibold text-gray-800 mb-4">What happens next?</h3>
        <div class="space-y-3">
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="text-yellow-700 text-xs font-bold">1</span>
                </div>
                <p class="text-sm text-gray-600">Save your confirmation code <strong>{{ $booking->confirmation_code }}</strong></p>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="text-yellow-700 text-xs font-bold">2</span>
                </div>
                <p class="text-sm text-gray-600">Arrive at the hotel on <strong>{{ $booking->check_in->format('d M Y') }}</strong> from 2:00 PM</p>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="text-yellow-700 text-xs font-bold">3</span>
                </div>
                <p class="text-sm text-gray-600">Show your confirmation code at the front desk</p>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span class="text-yellow-700 text-xs font-bold">4</span>
                </div>
                <p class="text-sm text-gray-600">Payment will be collected at check-out</p>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <a href="{{ route('guest.bookings') }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl font-medium transition">
            <i class="fas fa-list mr-2"></i> View My Bookings
        </a>
        <a href="{{ route('rooms.index') }}"
           class="border border-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium hover:bg-gray-50 transition">
            <i class="fas fa-search mr-2"></i> Browse More Rooms
        </a>
    </div>

</div>
@endsection