<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Invoice $invoice): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'method' => ['required', 'in:cash,credit_card,debit_card,bank_transfer,online'],
        ]);

        Payment::create([
            'invoice_id' => $invoice->id,
            'amount'     => $request->amount,
            'method'     => $request->method,
            'status'     => 'completed',
            'paid_at'    => now(),
        ]);

        // Update invoice status
        $invoice->refresh();
        if ($invoice->amountDue() <= 0) {
            $invoice->update(['status' => 'paid']);
        } else {
            $invoice->update(['status' => 'partially_paid']);
        }

        return back()->with('success', 'Payment recorded successfully.');
    }
}