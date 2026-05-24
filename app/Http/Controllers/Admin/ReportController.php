<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Invoice;

class ReportController extends Controller
{
    public function occupancy(): \Illuminate\View\View
    {
        $rooms = Room::with('roomType')->orderBy('floor')->orderBy('number')->get();

        $statusBreakdown = $rooms->groupBy('status')->map->count();

        $stats = [
            'total'          => $rooms->count(),
            'available'      => $rooms->where('status', 'available')->count(),
            'occupied'       => $rooms->where('status', 'occupied')->count(),
            'occupancy_rate' => $rooms->count() > 0
                ? round(($rooms->whereIn('status', ['occupied', 'reserved'])->count() / $rooms->count()) * 100)
                : 0,
        ];

        return view('admin.reports.occupancy', compact('rooms', 'stats', 'statusBreakdown'));
    }

    public function revenue(): \Illuminate\View\View
    {
        $revenue = [
            'today'      => Invoice::whereDate('created_at', today())
                                ->where('status', 'paid')->sum('total'),
            'this_month' => Invoice::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->where('status', 'paid')->sum('total'),
            'total'      => Invoice::where('status', 'paid')->sum('total'),
        ];

        $bookingStats = [
            'total'      => Booking::count(),
            'this_month' => Booking::whereMonth('created_at', now()->month)->count(),
            'cancelled'  => Booking::where('status', 'cancelled')->count(),
        ];

        $recentInvoices = Invoice::with(['booking.user'])
            ->where('status', 'paid')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports.revenue', compact('revenue', 'bookingStats', 'recentInvoices'));
    }
}