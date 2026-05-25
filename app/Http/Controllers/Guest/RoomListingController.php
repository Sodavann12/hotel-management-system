<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomListingController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        $query = Room::with('roomType')
            ->where('status', 'available');

        // Filter by room type
        if ($request->type) {
            $query->where('room_type_id', $request->type);
        }

        // Filter by max price
        if ($request->max_price) {
            $query->whereHas('roomType', fn($q) =>
                $q->where('base_price', '<=', $request->max_price)
            );
        }

        // Filter by guests
        if ($request->guests) {
            $query->whereHas('roomType', fn($q) =>
                $q->where('max_occupancy', '>=', $request->guests)
            );
        }

        // Filter by availability dates
        if ($request->check_in && $request->check_out) {
            $query->whereDoesntHave('bookings', function ($q) use ($request) {
                $q->whereNotIn('status', ['cancelled', 'no_show', 'checked_out'])
                  ->where('check_in', '<', $request->check_out)
                  ->where('check_out', '>', $request->check_in);
            });
        }

        $rooms     = $query->get();
        $roomTypes = RoomType::active()->get();

        return view('guest.rooms.index', compact('rooms', 'roomTypes'));
    }

    public function show(Room $room): \Illuminate\View\View
    {
        $room->load('roomType');

        // Get similar rooms
        $similarRooms = Room::with('roomType')
            ->where('room_type_id', $room->room_type_id)
            ->where('id', '!=', $room->id)
            ->where('status', 'available')
            ->take(3)
            ->get();

        return view('guest.rooms.show', compact('room', 'similarRooms'));
    }
}