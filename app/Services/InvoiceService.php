<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Invoice;

class InvoiceService
{
    public function generateForBooking(Booking $booking): Invoice
    {
        if ($booking->invoice) {
            return $booking->invoice;
        }

        $subtotal  = (float) $booking->total_price;
        $taxRate   = 10.00;
        $taxAmount = round($subtotal * ($taxRate / 100), 2);
        $total     = $subtotal + $taxAmount;

        return Invoice::create([
            'booking_id' => $booking->id,
            'subtotal'   => $subtotal,
            'tax_rate'   => $taxRate,
            'tax_amount' => $taxAmount,
            'discount'   => 0,
            'total'      => $total,
            'status'     => 'issued',
            'issue_date' => now()->toDateString(),
            'due_date'   => now()->addDays(7)->toDateString(),
        ]);
    }
}
