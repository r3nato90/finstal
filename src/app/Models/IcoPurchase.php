<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IcoPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ico_token_id',
        'purchase_id',
        'amount_usd',
        'tokens_purchased',
        'token_price',
        'status',
        'purchased_at',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'json',
        'amount_usd' => 'decimal:2',
        'tokens_purchased' => 'decimal:8',
        'token_price' => 'decimal:8',
        'purchased_at' => 'datetime'
    ];

    /**
     * Get the user that owns the ICO purchase.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ICO token associated with the purchase.
     */
    public function icoToken(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(IcoToken::class, 'ico_token_id');
    }
}
