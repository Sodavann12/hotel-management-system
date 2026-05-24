<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        $customers = User::withCount('bookings')
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            })
            ->latest()
            ->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer): \Illuminate\View\View
    {
        $customer->load(['bookings.room.roomType']);
        return view('admin.customers.show', compact('customer'));
    }
}