<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'guests',
        'total_price',
        'status',
        'confirmation_code',
        'special_requests',
        'notes',
        'confirmed_at',
        'checked_in_at',
        'checked_out_at',
        'cancelled_at',
        'cancelled_by',
    ];

    protected $casts = [
        'check_in'       => 'date',
        'check_out'      => 'date',
        'total_price'    => 'decimal:2',
        'confirmed_at'   => 'datetime',
        'checked_in_at'  => 'datetime',
        'checked_out_at' => 'datetime',
        'cancelled_at'   => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(BookingService::class);
    }

    public function nights(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->check_in->diffInDays($this->check_out)
        );
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['confirmed', 'checked_in']);
    }

    public function scopeForDateRange($query, $checkIn, $checkOut)
    {
        return $query->where('check_in', '<', $checkOut)
                     ->where('check_out', '>', $checkIn);
    }

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            $booking->confirmation_code ??= strtoupper(
                substr(md5(uniqid(rand(), true)), 0, 8)
            );
        });
    }
}