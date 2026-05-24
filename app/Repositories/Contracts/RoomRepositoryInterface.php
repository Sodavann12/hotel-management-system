<?php

namespace App\Repositories\Contracts;

use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

interface RoomRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): Room;
    public function getAvailableRooms(string $checkIn, string $checkOut): Collection;
    public function updateStatus(Room $room, string $status): Room;
}