<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TokenSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'user_id',
        'ico_token_id',
        'tokens_sold',
        'sale_price',
        'total_amount',
        'status',
        'sold_at'
    ];

    protected $casts = [
        'tokens_sold' => 'decimal:8',
        'sale_price' => 'decimal:8',
        'total_amount' => 'decimal:2',
        'sold_at' => 'datetime'
    ];

    public static function generateSaleId(): string
    {
        do {
            $date = now()->format('Ymd');
            $random = strtoupper(Str::random(6));
            $saleId = "SALE-{$date}-{$random}";

            $exists = self::where('sale_id', $saleId)->exists();
        } while ($exists);

        return $saleId;
    }

    /**
     * Get the user that owns the token sale.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ICO token associated with the sale.
     */
    public function icoToken(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(IcoToken::class, 'ico_token_id');
    }
}
