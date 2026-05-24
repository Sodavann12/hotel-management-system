<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Services\BookingService;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Exceptions\RoomNotAvailableException;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(
        private BookingService $bookingService
    ) {}

    public function index(Request $request): \Illuminate\View\View
    {
        $bookings = Booking::with(['user', 'room.roomType'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, function ($q) use ($request) {
                $q->where('confirmation_code', 'like', "%{$request->search}%")
                ->orWhereHas('user', fn($u) =>
                $u->where('name', 'like', "%{$request->search}%")
                );
            })
            ->latest()
            ->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create(): \Illuminate\View\View
    {
        $rooms    = Room::with('roomType')->where('status', 'available')->get();
        $customers = User::all();
        return view('admin.bookings.create', compact('rooms', 'customers'));
    }

    public function store(StoreBookingRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $booking = $this->bookingService->create(
                $request->validated(),
                $request->user_id
            );

            return redirect()
                ->route('admin.bookings.show', $booking)
                ->with('success', "Booking {$booking->confirmation_code} created successfully.");

        } catch (RoomNotAvailableException $e) {
            return back()
                ->withErrors(['room_id' => $e->getMessage()])
                ->withInput();
        }
    }

    public function show(Booking $booking): \Illuminate\View\View
    {
        $booking->load(['user', 'room.roomType', 'invoice.payments', 'services.service']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking): \Illuminate\View\View
    {
        $rooms = Room::with('roomType')->get();
        return view('admin.bookings.edit', compact('booking', 'rooms'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking): \Illuminate\Http\RedirectResponse
    {
        $booking->update($request->validated());

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking): \Illuminate\Http\RedirectResponse
    {
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking deleted.');
    }

    public function checkIn(Booking $booking): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->bookingService->checkIn($booking);
            return back()->with('success', 'Guest checked in successfully.');
        } catch (\LogicException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function checkOut(Booking $booking): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->bookingService->checkOut($booking);
            return redirect()
                ->route('admin.invoices.show', $booking->fresh()->invoice)
                ->with('success', 'Guest checked out. Invoice generated.');
        } catch (\LogicException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function cancel(Booking $booking): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->bookingService->cancel($booking, auth()->user()->name);
            return back()->with('success', 'Booking cancelled successfully.');
        } catch (\LogicException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}