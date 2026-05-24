<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'booking_id',
        'invoice_number',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'discount',
        'total',
        'status',
        'issue_date',
        'due_date',
        'notes',
    ];

    protected $casts = [
        'subtotal'   => 'decimal:2',
        'tax_rate'   => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount'   => 'decimal:2',
        'total'      => 'decimal:2',
        'issue_date' => 'date',
        'due_date'   => 'date',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function amountPaid(): float
    {
        return (float) $this->payments()
            ->where('status', 'completed')
            ->sum('amount');
    }

    public function amountDue(): float
    {
        return (float) $this->total - $this->amountPaid();
    }

    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice) {
            $year  = now()->year;
            $count = static::whereYear('created_at', $year)->count() + 1;
            $invoice->invoice_number = 'INV-' . $year . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
        });
    }
}