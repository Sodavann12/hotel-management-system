@extends('admin.layouts.app')

@section('title', 'Room Types')

@section('content')
<div class="mt-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Room Types</h2>
            <p class="text-sm text-gray-500">Manage room categories and pricing</p>
        </div>
        <a href="{{ route('admin.room-types.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2">
            <i class="fas fa-plus"></i> Add Room Type
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($roomTypes as $type)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="font-semibold text-gray-800 text-lg">{{ $type->name }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Max {{ $type->max_occupancy }} guests</p>
                        </div>
                        <span class="text-xl font-bold text-blue-600">
                            ${{ number_format($type->base_price, 0) }}
                            <span class="text-xs font-normal text-gray-400">/night</span>
                        </span>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">{{ $type->description }}</p>

                    @if($type->amenities)
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            @foreach($type->amenities as $amenity)
                                <span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded-full">
                                    {{ $amenity }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex items-center justify-between text-sm text-gray-500 border-t border-gray-100 pt-3">
                        <span>{{ $type->rooms_count }} rooms</span>
                        <span class="{{ $type->is_active ? 'text-green-600' : 'text-red-500' }}">
                            <i class="fas fa-circle text-xs mr-1"></i>
                            {{ $type->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <div class="border-t border-gray-100 px-6 py-3 bg-gray-50 flex justify-between">
                    <a href="{{ route('admin.room-types.edit', $type) }}"
                       class="text-sm text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('admin.room-types.destroy', $type) }}"
                          onsubmit="return confirm('Delete {{ $type->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-red-400 hover:text-red-600">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 text-gray-400">
                <i class="fas fa-layer-group text-4xl mb-3 block"></i>
                <p>No room types found.</p>
                <a href="{{ route('admin.room-types.create') }}"
                   class="text-blue-600 text-sm mt-2 inline-block">
                   Add your first room type
                </a>
            </div>
        @endforelse
    </div>

</div>
@endsection