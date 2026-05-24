@extends('admin.layouts.app')

@section('title', 'Booking ' . $booking->confirmation_code)

@section('content')
<div class="mt-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.bookings.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left mr-1"></i> Back to Bookings
        </a>
        <div class="flex gap-2">
            @if($booking->status === 'confirmed')
                <form method="POST" action="{{ route('admin.bookings.check-in', $booking) }}">
                    @csrf
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                        <i class="fas fa-sign-in-alt mr-1"></i> Check In
                    </button>
                </form>
            @endif
            @if($booking->status === 'checked_in')
                <form method="POST" action="{{ route('admin.bookings.check-out', $booking) }}">
                    @csrf
                    <button class="bg-orange-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-700">
                        <i class="fas fa-sign-out-alt mr-1"></i> Check Out
                    </button>
                </form>
            @endif
            @if(!in_array($booking->status, ['checked_out', 'cancelled']))
                <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}"
                      onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                    @csrf
                    <button class="bg-red-100 text-red-700 px-4 py-2 rounded-lg text-sm hover:bg-red-200">
                        <i class="fas fa-times mr-1"></i> Cancel Booking
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Booking Details --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Main info card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 font-mono">{{ $booking->confirmation_code }}</h2>
                        <p class="text-sm text-gray-500">Created {{ $booking->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    @php
                        $colors = [
                            'pending'     => 'bg-yellow-100 text-yellow-700',
                            'confirmed'   => 'bg-blue-100 text-blue-700',
                            'checked_in'  => 'bg-green-100 text-green-700',
                            'checked_out' => 'bg-gray-100 text-gray-600',
                            'cancelled'   => 'bg-red-100 text-red-700',
                            'no_show'     => 'bg-red-100 text-red-700',
                        ];
                    @endphp
                    <span class="px-3 py-1.5 rounded-full text-sm font-medium {{ $colors[$booking->status] ?? 'bg-gray-100' }}">
                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                    </span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                        <p class="text-xs text-gray-500">Check In</p>
                        <p class="text-sm font-semibold text-gray-800 mt-1">{{ $booking->check_in->format('d M Y') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                        <p class="text-xs text-gray-500">Check Out</p>
                        <p class="text-sm font-semibold text-gray-800 mt-1">{{ $booking->check_out->format('d M Y') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                        <p class="text-xs text-gray-500">Nights</p>
                        <p class="text-sm font-semibold text-gray-800 mt-1">{{ $booking->nights }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                        <p class="text-xs text-gray-500">Guests</p>
                        <p class="text-sm font-semibold text-gray-800 mt-1">{{ $booking->guests }}</p>
                    </div>
                </div>

                @if($booking->special_requests)
                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-100 rounded-lg">
                        <p class="text-xs text-yellow-700 font-medium mb-1">Special Requests</p>
                        <p class="text-sm text-yellow-800">{{ $booking->special_requests }}</p>
                    </div>
                @endif

                @if($booking->notes)
                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 font-medium mb-1">Internal Notes</p>
                        <p class="text-sm text-gray-700">{{ $booking->notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Invoice section --}}
            @if($booking->invoice)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-800">Invoice</h3>
                        <a href="{{ route('admin.invoices.show', $booking->invoice) }}"
                           class="text-sm text-blue-600 hover:underline">View full invoice</a>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Invoice #</span>
                            <span class="font-mono">{{ $booking->invoice->invoice_number }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span>${{ number_format($booking->invoice->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Tax ({{ $booking->invoice->tax_rate }}%)</span>
                            <span>${{ number_format($booking->invoice->tax_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-semibold border-t border-gray-100 pt-2">
                            <span>Total</span>
                            <span>${{ number_format($booking->invoice->total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-green-600">
                            <span>Amount Paid</span>
                            <span>${{ number_format($booking->invoice->amountPaid(), 2) }}</span>
                        </div>
                        @if($booking->invoice->amountDue() > 0)
                            <div class="flex justify-between text-sm text-red-600 font-medium">
                                <span>Amount Due</span>
                                <span>${{ number_format($booking->invoice->amountDue(), 2) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Guest Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Guest Information</h3>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-700 font-semibold text-sm">
                            {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $booking->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $booking->user->email }}</p>
                    </div>
                </div>
            </div>

            {{-- Room Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Room Information</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Room</span>
                        <span class="font-medium">{{ $booking->room->number }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Type</span>
                        <span>{{ $booking->room->roomType->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Floor</span>
                        <span>{{ $booking->room->floor }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Rate</span>
                        <span>${{ number_format($booking->room->roomType->base_price, 2) }}/night</span>
                    </div>
                    <div class="flex justify-between text-sm font-semibold border-t border-gray-100 pt-2">
                        <span>Total Charged</span>
                        <span>${{ number_format($booking->total_price, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Timeline</h3>
                <div class="space-y-3">
                    <div class="flex gap-3 text-sm">
                        <div class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 flex-shrink-0"></div>
                        <div>
                            <p class="font-medium text-gray-700">Booking created</p>
                            <p class="text-xs text-gray-400">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @if($booking->confirmed_at)
                        <div class="flex gap-3 text-sm">
                            <div class="w-2 h-2 rounded-full bg-green-500 mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="font-medium text-gray-700">Confirmed</p>
                                <p class="text-xs text-gray-400">{{ $booking->confirmed_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                    @if($booking->checked_in_at)
                        <div class="flex gap-3 text-sm">
                            <div class="w-2 h-2 rounded-full bg-green-500 mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="font-medium text-gray-700">Checked in</p>
                                <p class="text-xs text-gray-400">{{ $booking->checked_in_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                    @if($booking->checked_out_at)
                        <div class="flex gap-3 text-sm">
                            <div class="w-2 h-2 rounded-full bg-gray-400 mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="font-medium text-gray-700">Checked out</p>
                                <p class="text-xs text-gray-400">{{ $booking->checked_out_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                    @if($booking->cancelled_at)
                        <div class="flex gap-3 text-sm">
                            <div class="w-2 h-2 rounded-full bg-red-500 mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="font-medium text-gray-700">Cancelled by {{ $booking->cancelled_by }}</p>
                                <p class="text-xs text-gray-400">{{ $booking->cancelled_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection