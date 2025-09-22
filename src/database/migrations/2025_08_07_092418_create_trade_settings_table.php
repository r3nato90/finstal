<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trade_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('currency_id')->constrained('crypto_currencies');
            $table->string('symbol');
            $table->boolean('is_active')->default(true);
            $table->decimal('min_amount', 15, 2)->default(1.00);
            $table->decimal('max_amount', 15, 2)->default(10000.00);
            $table->decimal('payout_rate', 5, 2)->default(85.00);
            $table->json('durations');
            $table->json('trading_hours')->nullable();
            $table->decimal('spread', 8, 5)->default(0.00001);
            $table->integer('max_trades_per_user')->default(10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_settings');
    }
};
