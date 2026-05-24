<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        $rooms = Room::with('roomType')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('floor')
            ->orderBy('number')
            ->paginate(20);

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create(): \Illuminate\View\View
    {
        $roomTypes = RoomType::active()->get();
        return view('admin.rooms.create', compact('roomTypes'));
    }

    public function store(StoreRoomRequest $request): \Illuminate\Http\RedirectResponse
    {
        Room::create($request->validated());

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room created successfully.');
    }

    public function show(Room $room): \Illuminate\View\View
    {
        $room->load(['roomType', 'bookings.user', 'housekeepingTasks', 'maintenanceRequests']);
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room): \Illuminate\View\View
    {
        $roomTypes = RoomType::active()->get();
        return view('admin.rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(UpdateRoomRequest $request, Room $room): \Illuminate\Http\RedirectResponse
    {
        $room->update($request->validated());

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room): \Illuminate\Http\RedirectResponse
    {
        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}