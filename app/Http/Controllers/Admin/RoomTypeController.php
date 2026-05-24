<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $roomTypes = RoomType::withCount('rooms')->latest()->get();
        return view('admin.room-types.index', compact('roomTypes'));
    }

    public function create(): \Illuminate\View\View
    {
        return view('admin.room-types.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'unique:room_types,name'],
            'description'   => ['nullable', 'string'],
            'base_price'    => ['required', 'numeric', 'min:0'],
            'max_occupancy' => ['required', 'integer', 'min:1'],
            'amenities'     => ['nullable', 'string'],
            'is_active'     => ['required', 'in:0,1'],
        ]);

        // Convert amenities string to array
        if (!empty($validated['amenities'])) {
            $validated['amenities'] = array_map(
                'trim',
                explode(',', $validated['amenities'])
            );
        }

        $validated['is_active'] = (bool) $validated['is_active'];

        RoomType::create($validated);

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'Room type created successfully.');
    }

    public function edit(RoomType $roomType): \Illuminate\View\View
    {
        return view('admin.room-types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string'],
            'description'   => ['nullable', 'string'],
            'base_price'    => ['required', 'numeric', 'min:0'],
            'max_occupancy' => ['required', 'integer', 'min:1'],
            'amenities'     => ['nullable', 'string'],
            'is_active'     => ['required', 'in:0,1'],
        ]);

        if (!empty($validated['amenities'])) {
            $validated['amenities'] = array_map(
                'trim',
                explode(',', $validated['amenities'])
            );
        }

        $validated['is_active'] = (bool) $validated['is_active'];

        $roomType->update($validated);

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'Room type updated successfully.');
    }

    public function destroy(RoomType $roomType): \Illuminate\Http\RedirectResponse
    {
        $roomType->delete();
        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'Room type deleted.');
    }
}