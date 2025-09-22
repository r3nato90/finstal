<?php

namespace App\Models;

use Carbon\Carbon;
use EloquentFilter\Filterable;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeLog extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'trade_id',
        'trade_setting_id',
        'user_id',
        'symbol',
        'direction',
        'amount',
        'open_price',
        'close_price',
        'duration_seconds',
        'payout_rate',
        'open_time',
        'expiry_time',
        'close_time',
        'status',
        'profit_loss',
        'notes'
    ];


    protected $casts = [
        'open_time' => 'datetime',
        'expiry_time' => 'datetime',
        'close_time' => 'datetime',
        'amount' => 'decimal:2',
        'open_price' => 'decimal:8',
        'close_price' => 'decimal:8',
        'profit_loss' => 'decimal:2',
        'payout_rate' => 'decimal:2',
        'duration_seconds' => 'integer',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setting(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TradeSetting::class, 'symbol', 'symbol');
    }


    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('trade_id', 'like', "%{$search}%")
                ->orWhere('symbol', 'like', "%{$search}%")
                ->orWhere('notes', 'like', "%{$search}%");
        });
    }

    public function scopeBySymbol($query, $symbol)
    {
        return $query->where('symbol', $symbol);
    }

    public function scopeByDirection($query, $direction)
    {
        return $query->where('direction', $direction);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'active')
            ->where('expiry_time', '<', now());
    }

    public function getDurationFormattedAttribute(): string
    {
        $seconds = $this->duration_seconds;

        if ($seconds < 60) {
            return $seconds . 's';
        } elseif ($seconds < 3600) {
            return floor($seconds / 60) . 'm';
        } else {
            return floor($seconds / 3600) . 'h';
        }
    }

    public function getTimeRemainingAttribute(): ?string
    {
        if ($this->status !== 'active') {
            return null;
        }

        $now = now();
        $expiry = Carbon::parse($this->expiry_time);

        if ($now->gte($expiry)) {
            return 'Expired';
        }

        $diff = $now->diffInSeconds($expiry);

        if ($diff < 60) {
            return $diff . 's left';
        } elseif ($diff < 3600) {
            return floor($diff / 60) . 'm left';
        } else {
            return floor($diff / 3600) . 'h left';
        }
    }

    public function getFormattedProfitLossAttribute(): string
    {
        if ($this->profit_loss == 0) {
            return '$0.00';
        }

        $sign = $this->profit_loss > 0 ? '+' : '';
        return $sign . '$' . number_format(abs($this->profit_loss), 2);
    }

    /**
     * @param $closePrice
     * @return $this
     * @throws Exception
     */
    public function settleTrade($closePrice): static
    {
        if ($this->status !== 'active') {
            throw new Exception('Trade is not active');
        }

        $this->close_price = $closePrice;
        $this->close_time = now();

        if ($closePrice == $this->open_price) {
            $this->status = 'draw';
            $this->profit_loss = 0;
        } else {
            $won = ($this->direction === 'up' && $closePrice > $this->open_price) ||
                ($this->direction === 'down' && $closePrice < $this->open_price);

            if ($won) {
                $this->status = 'won';
                $this->profit_loss = ($this->amount * $this->payout_rate) / 100;
            } else {
                $this->status = 'lost';
                $this->profit_loss = -$this->amount;
            }
        }

        $this->save();
        return $this;
    }

    public function cancelTrade(): static
    {
        if ($this->status !== 'active') {
            throw new Exception('Trade is not active');
        }

        $this->status = 'cancelled';
        $this->close_time = now();
        $this->profit_loss = 0;
        $this->save();

        return $this;
    }

    public function expireTrade(): static
    {
        if ($this->status !== 'active') {
            throw new Exception('Trade is not active');
        }

        $this->status = 'expired';
        $this->close_time = now();
        $this->profit_loss = -$this->amount;
        $this->save();

        return $this;
    }

    public function canBeCancelled(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        $timeSinceOpen = now()->diffInSeconds(Carbon::parse($this->open_time));
        return $timeSinceOpen <= 30;
    }

    public function getProgressPercentage()
    {
        if ($this->status !== 'active') {
            return 100;
        }

        $now = now();
        $start = Carbon::parse($this->open_time);
        $end = Carbon::parse($this->expiry_time);

        $elapsed = $now->diffInSeconds($start);
        $total = $end->diffInSeconds($start);

        return min(100, max(0, ($elapsed / $total) * 100));
    }

}
