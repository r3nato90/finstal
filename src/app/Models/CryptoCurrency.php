<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CryptoCurrency extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'symbol', 'name', 'type', 'current_price',
        'previous_price', 'change_percent', 'last_updated', 'base_currency', 'tradingview_symbol', 'total_volume', 'market_cap', 'rank'
        ,'image_url', 'status'
    ];

    protected $casts = [
        'current_price' => 'decimal:8',
        'previous_price' => 'decimal:8',
        'change_percent' => 'decimal:4',
        'last_updated' => 'datetime'
    ];

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('symbol', 'LIKE', "%{$search}%");
        });
    }

    public function updatePrice($newPrice, $baseCurrency = 'USD'): void
    {
        $this->previous_price = $this->current_price;
        $this->current_price = $newPrice;
        $this->base_currency = $baseCurrency;

        if ($this->previous_price > 0) {
            $this->change_percent = (($newPrice - $this->previous_price) / $this->previous_price) * 100;
        }

        $this->last_updated = now();
        $this->save();
    }

    public function getFormattedPriceAttribute(): string
    {
        return $this->base_currency . ' ' . number_format($this->current_price, 2);
    }

}
