<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

// Root redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// All admin routes — must be logged in
Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
        ->name('dashboard');

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

// Breeze auth routes
require __DIR__.'/auth.php';