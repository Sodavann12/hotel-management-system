@extends('admin.layouts.app')

@section('title', 'Occupancy Report')

@section('content')
<div class="mt-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Occupancy Report</h2>
            <p class="text-sm text-gray-500">Room occupancy overview</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 text-center">
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Rooms</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 text-center">
            <p class="text-3xl font-bold text-green-600">{{ $stats['available'] }}</p>
            <p class="text-sm text-gray-500 mt-1">Available</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 text-center">
            <p class="text-3xl font-bold text-red-600">{{ $stats['occupied'] }}</p>
            <p class="text-sm text-gray-500 mt-1">Occupied</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 text-center">
            <p class="text-3xl font-bold text-blue-600">{{ $stats['occupancy_rate'] }}%</p>
            <p class="text-sm text-gray-500 mt-1">Occupancy Rate</p>
        </div>
    </div>

    {{-- Room Status Breakdown --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="font-semibold text-gray-800 mb-4">Room Status Breakdown</h3>
        <div class="space-y-3">
            @foreach($statusBreakdown as $status => $count)
                @php
                    $colors = [
                        'available'    => 'bg-green-500',
                        'occupied'     => 'bg-red-500',
                        'reserved'     => 'bg-blue-500',
                        'dirty'        => 'bg-yellow-500',
                        'maintenance'  => 'bg-orange-500',
                        'out_of_order' => 'bg-gray-500',
                    ];
                    $bar = $colors[$status] ?? 'bg-gray-400';
                    $pct = $stats['total'] > 0 ? round(($count / $stats['total']) * 100) : 0;
                @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $status) }}</span>
                        <span class="font-medium">{{ $count }} rooms ({{ $pct }}%)</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="{{ $bar }} h-2 rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Rooms Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">All Rooms Status</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Room</th>
                    <th class="px-6 py-3 text-left">Type</th>
                    <th class="px-6 py-3 text-left">Floor</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Price/Night</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($rooms as $room)
                    @php
                        $colors = [
                            'available'    => 'bg-green-100 text-green-700',
                            'occupied'     => 'bg-red-100 text-red-700',
                            'reserved'     => 'bg-blue-100 text-blue-700',
                            'dirty'        => 'bg-yellow-100 text-yellow-700',
                            'maintenance'  => 'bg-orange-100 text-orange-700',
                            'out_of_order' => 'bg-gray-100 text-gray-700',
                        ];
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium">{{ $room->number }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $room->roomType->name }}</td>
                        <td class="px-6 py-3 text-gray-600">Floor {{ $room->floor }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-full text-xs {{ $colors[$room->status] ?? 'bg-gray-100' }}">
                                {{ ucfirst(str_replace('_', ' ', $room->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-3">${{ number_format($room->roomType->base_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection