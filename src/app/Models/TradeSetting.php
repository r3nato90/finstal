<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'symbol',
        'is_active',
        'min_amount',
        'max_amount',
        'payout_rate',
        'durations',
        'trading_hours'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'payout_rate' => 'decimal:2',
        'durations' => 'array',
        'trading_hours' => 'array'
    ];

    protected $appends = ['formatted_durations'];

    public function currency(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CryptoCurrency::class, 'currency_id');
    }

    public function trades(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TradeLog::class, 'symbol', 'symbol');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBySymbol($query, $symbol)
    {
        return $query->where('symbol', $symbol);
    }

    public function getFormattedDurationsAttribute(): array
    {
        if (!$this->durations) {
            return [];
        }

        return collect($this->durations)->map(function ($seconds) {
            return $this->formatDuration($seconds);
        })->toArray();
    }

    public function formatDuration($seconds): string
    {
        if ($seconds < 60) {
            return $seconds . ' sec';
        } elseif ($seconds < 3600) {
            $minutes = floor($seconds / 60);
            return $minutes . ' min';
        } else {
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds % 3600) / 60);
            return $hours . 'h' . ($minutes > 0 ? ' ' . $minutes . 'm' : '');
        }
    }

    public function isValidDuration($seconds): bool
    {
        return in_array($seconds, $this->durations ?? []);
    }

    public function isValidAmount($amount): bool
    {
        return $amount >= $this->min_amount && $amount <= $this->max_amount;
    }
}
