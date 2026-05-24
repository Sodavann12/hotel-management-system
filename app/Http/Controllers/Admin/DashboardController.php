<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Key stats for the dashboard
        $stats = [
            'total_rooms'        => Room::count(),
            'available_rooms'    => Room::where('status', 'available')->count(),
            'occupied_rooms'     => Room::where('status', 'occupied')->count(),
            'total_bookings'     => Booking::count(),
            'active_bookings'    => Booking::whereIn('status', ['confirmed', 'checked_in'])->count(),
            'today_arrivals'     => Booking::whereDate('check_in', today())
                                        ->where('status', 'confirmed')->count(),
            'today_departures'   => Booking::whereDate('check_out', today())
                                        ->where('status', 'checked_in')->count(),
            'total_customers'    => User::role('receptionist')->count(),
            'revenue_today'      => Invoice::whereDate('created_at', today())
                                        ->where('status', 'paid')->sum('total'),
            'revenue_this_month' => Invoice::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->where('status', 'paid')->sum('total'),
        ];

        // Recent bookings
        $recentBookings = Booking::with(['user', 'room.roomType'])
            ->latest()
            ->take(5)
            ->get();

        // Today's arrivals
        $todayArrivals = Booking::with(['user', 'room'])
            ->whereDate('check_in', today())
            ->where('status', 'confirmed')
            ->get();

        // Today's departures
        $todayDepartures = Booking::with(['user', 'room'])
            ->whereDate('check_out', today())
            ->where('status', 'checked_in')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentBookings',
            'todayArrivals',
            'todayDepartures'
        ));
    }
}