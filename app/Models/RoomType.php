<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'base_price',
        'max_occupancy',
        'amenities',
        'image',
        'is_active',
    ];

    protected $casts = [
        'base_price'    => 'decimal:2',
        'amenities'     => 'array',
        'is_active'     => 'boolean',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}