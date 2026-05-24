@extends('admin.layouts.app')

@section('title', $customer->name)

@section('content')
<div class="mt-6">

    <div class="mb-6">
        <a href="{{ route('admin.customers.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left mr-1"></i> Back to Customers
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Customer Info --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-blue-700 text-2xl font-bold">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </span>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">{{ $customer->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $customer->email }}</p>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Member since</span>
                    <span class="font-medium">{{ $customer->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total bookings</span>
                    <span class="font-medium">{{ $customer->bookings->count() }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total spent</span>
                    <span class="font-medium text-green-600">
                        ${{ number_format($customer->bookings->sum('total_price'), 2) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Booking History --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Booking History</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($customer->bookings as $booking)
                    @php
                        $colors = [
                            'pending'     => 'bg-yellow-100 text-yellow-700',
                            'confirmed'   => 'bg-blue-100 text-blue-700',
                            'checked_in'  => 'bg-green-100 text-green-700',
                            'checked_out' => 'bg-gray-100 text-gray-600',
                            'cancelled'   => 'bg-red-100 text-red-700',
                        ];
                    @endphp
                    <div class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="text-sm font-medium font-mono">{{ $booking->confirmation_code }}</p>
                            <p class="text-xs text-gray-500">
                                Room {{ $booking->room->number }} ·
                                {{ $booking->check_in->format('d M Y') }} →
                                {{ $booking->check_out->format('d M Y') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium">${{ number_format($booking->total_price, 2) }}</p>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $colors[$booking->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-gray-400 text-sm">
                        No bookings yet.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection