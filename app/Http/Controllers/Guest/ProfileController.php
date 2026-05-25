<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class ProfileController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $user = auth()->user();

        $stats = [
            'total_bookings'    => Booking::where('user_id', $user->id)->count(),
            'active_bookings'   => Booking::where('user_id', $user->id)
                                    ->whereIn('status', ['confirmed', 'checked_in'])->count(),
            'completed_stays'   => Booking::where('user_id', $user->id)
                                    ->where('status', 'checked_out')->count(),
            'total_spent'       => Booking::where('user_id', $user->id)
                                    ->whereNotIn('status', ['cancelled'])
                                    ->sum('total_price'),
        ];

        $recentBookings = Booking::with(['room.roomType'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('guest.profile', compact('user', 'stats', 'recentBookings'));
    }
}