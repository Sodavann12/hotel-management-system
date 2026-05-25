<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

// ── Public routes ────────────────────────────────────────────────────────────

// Welcome page (home)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Browse rooms (public)
Route::get('/rooms', [App\Http\Controllers\Guest\RoomListingController::class, 'index'])
    ->name('rooms.index');

Route::get('/rooms/{room}', [App\Http\Controllers\Guest\RoomListingController::class, 'show'])
    ->name('rooms.show');

// ── Breeze dashboard redirect ────────────────────────────────────────────────
Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// ── Authenticated guest routes ───────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    Route::get('/book/{room}', [App\Http\Controllers\Guest\BookingController::class, 'create'])
        ->name('guest.booking.create');

    Route::post('/book/{room}', [App\Http\Controllers\Guest\BookingController::class, 'store'])
        ->name('guest.booking.store');

    Route::get('/booking/confirmed/{booking}', [App\Http\Controllers\Guest\BookingController::class, 'confirmed'])
        ->name('guest.booking.confirmed');

    Route::get('/my-bookings', [App\Http\Controllers\Guest\BookingController::class, 'myBookings'])
        ->name('guest.bookings');

    Route::post('/my-bookings/{booking}/cancel', [App\Http\Controllers\Guest\BookingController::class, 'cancel'])
        ->name('guest.booking.cancel');

    Route::get('/profile', [App\Http\Controllers\Guest\ProfileController::class, 'index'])
        ->name('guest.profile');

});

// ── Admin routes (staff only) ────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
        ->name('dashboard');

    // Admin Profile
    Route::get('/profile', [Admin\ProfileController::class, 'index'])
        ->name('profile');

    // Room Types
    Route::resource('room-types', Admin\RoomTypeController::class);

    // Rooms
    Route::resource('rooms', Admin\RoomController::class);

    // Bookings + special actions
    Route::resource('bookings', Admin\BookingController::class);
    Route::post('bookings/{booking}/check-in',
        [Admin\BookingController::class, 'checkIn'])
        ->name('bookings.check-in');
    Route::post('bookings/{booking}/check-out',
        [Admin\BookingController::class, 'checkOut'])
        ->name('bookings.check-out');
    Route::post('bookings/{booking}/cancel',
        [Admin\BookingController::class, 'cancel'])
        ->name('bookings.cancel');

    // Customers
    Route::resource('customers', Admin\CustomerController::class)
        ->only(['index', 'show']);

    // Invoices
    Route::resource('invoices', Admin\InvoiceController::class)
        ->only(['index', 'show']);

    // Payments
    Route::post('invoices/{invoice}/payments',
        [Admin\PaymentController::class, 'store'])
        ->name('payments.store');

    // Staff
    Route::resource('staff', Admin\StaffController::class);

    // Housekeeping
    Route::resource('housekeeping', Admin\HousekeepingController::class);

    // Reports
    Route::get('reports/occupancy',
        [Admin\ReportController::class, 'occupancy'])
        ->name('reports.occupancy');
    Route::get('reports/revenue',
        [Admin\ReportController::class, 'revenue'])
        ->name('reports.revenue');

});

// ── Breeze auth routes (login, register, logout) ─────────────────────────────
require __DIR__.'/auth.php';