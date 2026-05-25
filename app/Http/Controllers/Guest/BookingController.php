<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;
use App\Services\BookingService;
use App\Exceptions\RoomNotAvailableException;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(
        private BookingService $bookingService
    ) {}

    public function create(Room $room, Request $request): \Illuminate\View\View
    {
        $room->load('roomType');

        $checkIn  = $request->check_in ?? now()->addDay()->format('Y-m-d');
        $checkOut = $request->check_out ?? now()->addDays(2)->format('Y-m-d');

        return view('guest.booking.create', compact('room', 'checkIn', 'checkOut'));
    }

    public function store(Room $room, Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'check_in'         => ['required', 'date', 'after_or_equal:today'],
            'check_out'        => ['required', 'date', 'after:check_in'],
            'guests'           => ['required', 'integer', 'min:1', 'max:' . $room->roomType->max_occupancy],
            'special_requests' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            $booking = $this->bookingService->create([
                'room_id'          => $room->id,
                'check_in'         => $request->check_in,
                'check_out'        => $request->check_out,
                'guests'           => $request->guests,
                'special_requests' => $request->special_requests,
            ], auth()->id());

            return redirect()
                ->route('guest.booking.confirmed', $booking)
                ->with('success', 'Booking confirmed successfully!');

        } catch (RoomNotAvailableException $e) {
            return back()
                ->withErrors(['room' => 'Sorry, this room is not available for the selected dates.'])
                ->withInput();
        }
    }

    public function confirmed(Booking $booking): \Illuminate\View\View
    {
        // Make sure guest can only see their own booking
        abort_if($booking->user_id !== auth()->id(), 403);

        $booking->load(['room.roomType']);
        return view('guest.booking.confirmed', compact('booking'));
    }

    public function myBookings(): \Illuminate\View\View
    {
        $bookings = Booking::with(['room.roomType'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('guest.booking.my-bookings', compact('bookings'));
    }

    public function cancel(Booking $booking): \Illuminate\Http\RedirectResponse
    {
        // Make sure guest can only cancel their own booking
        abort_if($booking->user_id !== auth()->id(), 403);

        try {
            $this->bookingService->cancel($booking, auth()->user()->name);
            return back()->with('success', 'Booking cancelled successfully.');
        } catch (\LogicException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}