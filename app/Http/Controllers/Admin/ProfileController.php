<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $user = auth()->user();

        $stats = [
            'total_bookings'   => Booking::count(),
            'today_arrivals'   => Booking::whereDate('check_in', today())
                                    ->where('status', 'confirmed')->count(),
            'today_departures' => Booking::whereDate('check_out', today())
                                    ->where('status', 'checked_in')->count(),
            'total_customers'  => User::whereDoesntHave('roles', function ($q) {
                                        $q->whereIn('name', [
                                            'super_admin', 'manager',
                                            'receptionist', 'housekeeping',
                                        ]);
                                    })->count(),
        ];

        return view('admin.profile', compact('user', 'stats'));
    }
}