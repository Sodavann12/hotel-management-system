<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $fillable = [
        'user_id',
        'employee_id',
        'department',
        'position',
        'phone',
        'shift',
        'joined_at',
        'is_active',
    ];

    protected $casts = [
        'joined_at' => 'date',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function housekeepingTasks(): HasMany
    {
        return $this->hasMany(HousekeepingTask::class);
    }
}