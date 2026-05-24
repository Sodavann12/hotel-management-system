<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function bookingServices(): HasMany
    {
        return $this->hasMany(BookingService::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}