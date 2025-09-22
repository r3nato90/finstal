<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'user_agent',
        'location',
        'device_type',
        'browser',
        'platform',
        'successful',
        'attempted_at',
    ];


    protected $casts = [
        'successful' => 'boolean',
        'attempted_at' => 'datetime',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSuccessful($query)
    {
        return $query->where('successful', true);
    }

    public function scopeFailed($query)
    {
        return $query->where('successful', false);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('attempted_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('attempted_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('attempted_at', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ]);
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->successful
            ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300'
            : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300';
    }

    public function getStatusTextAttribute(): string
    {
        return $this->successful ? 'Success' : 'Failed';
    }
}
