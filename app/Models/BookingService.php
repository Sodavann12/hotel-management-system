<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingService extends Model
{
    protected $fillable = [
        'booking_id',
        'service_id',
        'quantity',
        'unit_price',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'quantity'   => 'integer',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function subtotal(): float
    {
        return (float) $this->unit_price * $this->quantity;
    }
}