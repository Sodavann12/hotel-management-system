<?php

namespace App\Repositories;

use App\Models\Room;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RoomRepository implements RoomRepositoryInterface
{
    public function all(): Collection
    {
        return Room::with('roomType')->orderBy('number')->get();
    }

    public function findById(int $id): Room
    {
        return Room::with('roomType')->findOrFail($id);
    }

    public function getAvailableRooms(string $checkIn, string $checkOut): Collection
    {
        return Room::with('roomType')
            ->where('status', 'available')
            ->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
                $q->whereNotIn('status', ['cancelled', 'no_show', 'checked_out'])
                  ->where('check_in', '<', $checkOut)
                  ->where('check_out', '>', $checkIn);
            })
            ->get();
    }

    public function updateStatus(Room $room, string $status): Room
    {
        $room->update(['status' => $status]);
        return $room->fresh();
    }
}