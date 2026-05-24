<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Contracts\BookingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BookingRepository implements BookingRepositoryInterface
{
    public function all(array $filters = []): LengthAwarePaginator
    {
        $query = Booking::with(['user', 'room.roomType'])->latest();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('confirmation_code', 'like', "%{$filters['search']}%")
                  ->orWhereHas('user', fn($u) =>
                      $u->where('name', 'like', "%{$filters['search']}%")
                        ->orWhere('email', 'like', "%{$filters['search']}%")
                  );
            });
        }

        if (!empty($filters['date_from'])) {
            $query->where('check_in', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('check_out', '<=', $filters['date_to']);
        }

        return $query->paginate(20);
    }

    public function findById(int $id): Booking
    {
        return Booking::with([
            'user',
            'room.roomType',
            'invoice.payments',
            'services.service',
        ])->findOrFail($id);
    }

    public function create(array $data): Booking
    {
        return Booking::create($data);
    }

    public function update(Booking $booking, array $data): Booking
    {
        $booking->update($data);
        return $booking->fresh();
    }

    public function isRoomAvailable(int $roomId, string $checkIn, string $checkOut, ?int $excludeId = null): bool
    {
        $query = Booking::where('room_id', $roomId)
            ->whereNotIn('status', ['cancelled', 'no_show', 'checked_out'])
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->doesntExist();
    }

    public function getTodayArrivals(): Collection
    {
        return Booking::with(['user', 'room'])
            ->whereDate('check_in', today())
            ->where('status', 'confirmed')
            ->get();
    }

    public function getTodayDepartures(): Collection
    {
        return Booking::with(['user', 'room'])
            ->whereDate('check_out', today())
            ->where('status', 'checked_in')
            ->get();
    }
}