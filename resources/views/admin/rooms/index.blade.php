@extends('admin.layouts.app')

@section('title', 'Rooms')

@section('content')
<div class="mt-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">All Rooms</h2>
            <p class="text-sm text-gray-500">Manage hotel rooms and their status</p>
        </div>
        <a href="{{ route('admin.rooms.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2">
            <i class="fas fa-plus"></i> Add Room
        </a>
    </div>

    {{-- Status Filter Tabs --}}
    <div class="flex gap-2 mb-6 flex-wrap">
        @foreach(['all' => 'All', 'available' => 'Available', 'occupied' => 'Occupied', 'reserved' => 'Reserved', 'dirty' => 'Dirty', 'maintenance' => 'Maintenance'] as $value => $label)
            <a href="{{ $value === 'all' ? route('admin.rooms.index') : route('admin.rooms.index', ['status' => $value]) }}"
               class="px-3 py-1.5 rounded-full text-xs font-medium border
               {{ request('status', 'all') === $value ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Rooms Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($rooms as $room)
            @php
                $statusColors = [
                    'available'   => 'bg-green-100 text-green-700 border-green-200',
                    'occupied'    => 'bg-red-100 text-red-700 border-red-200',
                    'reserved'    => 'bg-blue-100 text-blue-700 border-blue-200',
                    'dirty'       => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                    'maintenance' => 'bg-orange-100 text-orange-700 border-orange-200',
                    'out_of_order'=> 'bg-gray-100 text-gray-700 border-gray-200',
                ];
                $dotColors = [
                    'available'   => 'bg-green-500',
                    'occupied'    => 'bg-red-500',
                    'reserved'    => 'bg-blue-500',
                    'dirty'       => 'bg-yellow-500',
                    'maintenance' => 'bg-orange-500',
                    'out_of_order'=> 'bg-gray-500',
                ];
                $color = $statusColors[$room->status] ?? 'bg-gray-100 text-gray-700';
                $dot   = $dotColors[$room->status] ?? 'bg-gray-500';
            @endphp

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $room->number }}</h3>
                            <p class="text-xs text-gray-500">Floor {{ $room->floor }}</p>
                        </div>
                        <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border {{ $color }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
                            {{ ucfirst(str_replace('_', ' ', $room->status)) }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-600 mb-1">{{ $room->roomType->name }}</p>
                    <p class="text-sm font-semibold text-gray-800">${{ number_format($room->roomType->base_price, 2) }}<span class="text-xs font-normal text-gray-500">/night</span></p>

                    @if($room->roomType->amenities)
                        <div class="flex flex-wrap gap-1 mt-3">
                            @foreach(array_slice($room->roomType->amenities, 0, 3) as $amenity)
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $amenity }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="border-t border-gray-100 px-5 py-3 flex items-center justify-between">
                    <a href="{{ route('admin.rooms.show', $room) }}"
                       class="text-xs text-blue-600 hover:underline">View details</a>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.rooms.edit', $room) }}"
                           class="text-xs text-gray-500 hover:text-gray-700">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}"
                              onsubmit="return confirm('Delete room {{ $room->number }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-600">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center py-16 text-gray-400">
                <i class="fas fa-door-open text-4xl mb-3 block"></i>
                <p>No rooms found.</p>
                <a href="{{ route('admin.rooms.create') }}" class="text-blue-600 text-sm mt-2 inline-block">Add your first room</a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $rooms->links() }}
    </div>

</div>
@endsection