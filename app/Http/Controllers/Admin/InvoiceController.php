<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $invoices = Invoice::with(['booking.user', 'booking.room', 'payments'])
            ->latest()
            ->paginate(20);

        return view('admin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice): \Illuminate\View\View
    {
        $invoice->load(['booking.user', 'booking.room.roomType', 'payments']);
        return view('admin.invoices.show', compact('invoice'));
    }
}