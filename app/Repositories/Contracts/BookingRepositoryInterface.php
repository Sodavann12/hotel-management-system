<?php

namespace App\Repositories\Contracts;

use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BookingRepositoryInterface
{
    public function all(array $filters = []): LengthAwarePaginator;
    public function findById(int $id): Booking;
    public function create(array $data): Booking;
    public function update(Booking $booking, array $data): Booking;
    public function isRoomAvailable(int $roomId, string $checkIn, string $checkOut, ?int $excludeId = null): bool;
    public function getTodayArrivals(): Collection;
    public function getTodayDepartures(): Collection;
}