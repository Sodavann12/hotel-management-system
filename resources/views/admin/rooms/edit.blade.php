@extends('admin.layouts.app')

@section('title', 'Edit Room ' . $room->number)

@section('content')
<div class="mt-6 max-w-2xl">

    <div class="mb-6">
        <a href="{{ route('admin.rooms.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left mr-1"></i> Back to Rooms
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Edit Room {{ $room->number }}</h2>

        <form method="POST" action="{{ route('admin.rooms.update', $room) }}">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Room Number <span class="text-red-500">*</span></label>
                    <input type="text" name="number" value="{{ old('number', $room->number) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('number') border-red-400 @enderror">
                    @error('number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Floor <span class="text-red-500">*</span></label>
                    <input type="number" name="floor" value="{{ old('floor', $room->floor) }}"
                           min="1" max="50"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('floor') border-red-400 @enderror">
                    @error('floor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Room Type <span class="text-red-500">*</span></label>
                    <select name="room_type_id"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }} — ${{ number_format($type->base_price, 2) }}/night
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(['available','reserved','occupied','dirty','maintenance','out_of_order'] as $status)
                            <option value="{{ $status }}" {{ old('status', $room->status) === $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea name="notes" rows="3"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $room->notes) }}</textarea>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">
                    Save Changes
                </button>
                <a href="{{ route('admin.rooms.index') }}"
                   class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>
@endsection