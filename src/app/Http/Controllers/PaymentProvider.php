<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentProvider extends Model
{
    protected $table = 'payment_providers';

    protected $fillable = ['key', 'title', 'enabled', 'config'];

    protected $casts = [
        'enabled' => 'boolean',
        'config'  => 'array',
    ];

    // Add more relationships or methods as needed for payment logic.
}
