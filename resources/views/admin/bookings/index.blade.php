@extends('admin.layouts.app')

@section('title', 'Bookings')

@section('content')
<div class="mt-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">All Bookings</h2>
            <p class="text-sm text-gray-500">Manage reservations and check-ins</p>
        </div>
        <a href="{{ route('admin.bookings.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2">
            <i class="fas fa-plus"></i> New Booking
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="flex flex-wrap gap-3 items-end">

            <div>
                <label class="block text-xs text-gray-500 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Name or code..."
                       class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-48">
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Status</label>
                <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All statuses</option>
                    @foreach(['pending','confirmed','checked_in','checked_out','cancelled','no_show'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Check In From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Check In To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                <i class="fas fa-search mr-1"></i> Filter
            </button>

            <a href="{{ route('admin.bookings.index') }}"
               class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm hover:bg-gray-200">
                Clear
            </a>

        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Code</th>
                        <th class="px-6 py-3 text-left">Guest</th>
                        <th class="px-6 py-3 text-left">Room</th>
                        <th class="px-6 py-3 text-left">Check In</th>
                        <th class="px-6 py-3 text-left">Check Out</th>
                        <th class="px-6 py-3 text-left">Nights</th>
                        <th class="px-6 py-3 text-left">Total</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($bookings as $booking)
                        @php
                            $colors = [
                                'pending'     => 'bg-yellow-100 text-yellow-700',
                                'confirmed'   => 'bg-blue-100 text-blue-700',
                                'checked_in'  => 'bg-green-100 text-green-700',
                                'checked_out' => 'bg-gray-100 text-gray-600',
                                'cancelled'   => 'bg-red-100 text-red-700',
                                'no_show'     => 'bg-red-100 text-red-700',
                            ];
                            $color = $colors[$booking->status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono text-xs font-medium">
                                {{ $booking->confirmation_code }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ $booking->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $booking->user->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium">{{ $booking->room->number }}</p>
                                <p class="text-xs text-gray-400">{{ $booking->room->roomType->name }}</p>
                            </td>
                            <td class="px-6 py-4">{{ $booking->check_in->format('d M Y') }}</td>
                            <td class="px-6 py-4">{{ $booking->check_out->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center">{{ $booking->nights }}</td>
                            <td class="px-6 py-4 font-medium">${{ number_format($booking->total_price, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.bookings.show', $booking) }}"
                                       class="text-blue-600 hover:text-blue-800 text-xs">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($booking->status === 'confirmed')
                                        <form method="POST" action="{{ route('admin.bookings.check-in', $booking) }}">
                                            @csrf
                                            <button class="text-green-600 hover:text-green-800 text-xs" title="Check In">
                                                <i class="fas fa-sign-in-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($booking->status === 'checked_in')
                                        <form method="POST" action="{{ route('admin.bookings.check-out', $booking) }}">
                                            @csrf
                                            <button class="text-orange-600 hover:text-orange-800 text-xs" title="Check Out">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if(!in_array($booking->status, ['checked_out', 'cancelled']))
                                        <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}"
                                              onsubmit="return confirm('Cancel this booking?')">
                                            @csrf
                                            <button class="text-red-400 hover:text-red-600 text-xs" title="Cancel">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-16 text-center text-gray-400">
                                <i class="fas fa-calendar-times text-4xl mb-3 block"></i>
                                No bookings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($bookings->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $bookings->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>
@endsection