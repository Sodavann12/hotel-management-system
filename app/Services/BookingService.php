<?php

namespace App\Services;

use App\Models\Booking;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Exceptions\RoomNotAvailableException;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function __construct(
        private BookingRepositoryInterface $bookingRepository,
        private RoomRepositoryInterface    $roomRepository,
        private PricingService             $pricingService,
        private InvoiceService             $invoiceService,
    ) {}

    public function create(array $data, int $userId): Booking
    {
        if (!$this->bookingRepository->isRoomAvailable(
            $data['room_id'],
            $data['check_in'],
            $data['check_out']
        )) {
            throw new RoomNotAvailableException(
                'This room is not available for the selected dates.'
            );
        }

        $room = $this->roomRepository->findById($data['room_id']);

        $data['user_id']     = $userId;
        $data['status']      = 'confirmed';
        $data['total_price'] = $this->pricingService->calculate(
            $room,
            $data['check_in'],
            $data['check_out']
        );

        return DB::transaction(function () use ($data, $room) {
            $booking = $this->bookingRepository->create($data);
            $this->roomRepository->updateStatus($room, 'reserved');
            return $booking;
        });
    }

    public function checkIn(Booking $booking): Booking
    {
        if ($booking->status !== 'confirmed') {
            throw new \LogicException('Only confirmed bookings can be checked in.');
        }

        return DB::transaction(function () use ($booking) {
            $updated = $this->bookingRepository->update($booking, [
                'status'        => 'checked_in',
                'checked_in_at' => now(),
            ]);
            $this->roomRepository->updateStatus($booking->room, 'occupied');
            return $updated;
        });
    }

    public function checkOut(Booking $booking): Booking
    {
        if ($booking->status !== 'checked_in') {
            throw new \LogicException('Only checked-in bookings can be checked out.');
        }

        return DB::transaction(function () use ($booking) {
            $updated = $this->bookingRepository->update($booking, [
                'status'         => 'checked_out',
                'checked_out_at' => now(),
            ]);
            $this->roomRepository->updateStatus($booking->room, 'dirty');
            $this->invoiceService->generateForBooking($updated);
            return $updated;
        });
    }

    public function cancel(Booking $booking, string $cancelledBy): Booking
    {
        if (in_array($booking->status, ['checked_out', 'cancelled'])) {
            throw new \LogicException('This booking cannot be cancelled.');
        }

        return DB::transaction(function () use ($booking, $cancelledBy) {
            $updated = $this->bookingRepository->update($booking, [
                'status'       => 'cancelled',
                'cancelled_at' => now(),
                'cancelled_by' => $cancelledBy,
            ]);
            $this->roomRepository->updateStatus($booking->room, 'available');
            return $updated;
        });
    }
}