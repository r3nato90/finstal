<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IcoToken extends Model
{
    use HasFactory;

    protected $table = 'tokens';

    protected $fillable = [
        'name',
        'symbol',
        'description',
        'total_supply',
        'price',
        'current_price',
        'tokens_sold',
        'sale_start_date',
        'sale_end_date',
        'status',
        'is_featured'
    ];

    /**
     * Get all purchases for this ICO token.
     */
    public function icoPurchases(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(IcoPurchase::class, 'ico_token_id');
    }

    /**
     * Get all sales for this ICO token.
     */
    public function tokenSales(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TokenSale::class, 'ico_token_id');
    }
}
