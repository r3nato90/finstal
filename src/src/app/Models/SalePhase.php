<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePhase extends Model
{
    use HasFactory;

    protected $fillable = [
        'token_id',
        'name',
        'type',
        'start_time',
        'end_time',
        'token_price',
        'max_purchase',
        'min_purchase',
        'available_tokens',
        'sold_tokens',
        'status',
        'enable_dynamic_pricing',
        'dynamic_pricing_rules'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'token_price' => 'decimal:10',
        'max_purchase' => 'decimal:18',
        'min_purchase' => 'decimal:18',
        'available_tokens' => 'decimal:18',
        'sold_tokens' => 'decimal:18',
        'dynamic_pricing_rules' => 'json'
    ];

    public function token(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(IcoToken::class);
    }

    public function purchases(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function getRemainingTokensAttribute()
    {
        return $this->available_tokens - $this->sold_tokens;
    }

    public function getSaleProgressPercentageAttribute(): float|int
    {
        return $this->available_tokens > 0
            ? ($this->sold_tokens / $this->available_tokens) * 100
            : 0;
    }
}
