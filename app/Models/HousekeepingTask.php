<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HousekeepingTask extends Model
{
    protected $fillable = [
        'room_id',
        'staff_id',
        'type',
        'status',
        'notes',
        'scheduled_at',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'scheduled_at'  => 'datetime',
        'started_at'    => 'datetime',
        'completed_at'  => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}