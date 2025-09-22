<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'primary_balance',
        'investment_balance',
        'trade_balance',
        'practice_balance'
    ];

    protected $casts = [
        'primary_balance' => 'decimal:8',
        'investment_balance' => 'decimal:8',
        'trade_balance' => 'decimal:8',
        'practice_balance' => 'decimal:8'
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the total balance across all wallet types.
     */
    public function getTotalBalanceAttribute(): string
    {
        return bcadd(
            bcadd(
                bcadd($this->primary_balance, $this->investment_balance, 8),
                $this->trade_balance,
                8
            ),
            $this->practice_balance,
            8
        );
    }

    /**
     * Check if the wallet has any balance.
     */
    public function hasBalance(): bool
    {
        return $this->primary_balance > 0
            || $this->investment_balance > 0
            || $this->trade_balance > 0
            || $this->practice_balance > 0;
    }

    /**
     * Get the primary active balance (excluding practice).
     */
    public function getActiveBalanceAttribute(): string
    {
        return bcadd(
            bcadd($this->primary_balance, $this->investment_balance, 8),
            $this->trade_balance,
            8
        );
    }
}
