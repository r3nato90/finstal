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
        Schema::table('trade_logs', function (Blueprint $table) {
            $table->dropColumn([
                'crypto_currency_id',
                'original_price',
                'duration',
                'arrival_time',
                'volume',
                'outcome',
                'meta'
            ]);

            $table->string('trade_id')->nullable();
            $table->foreignId('trade_setting_id')->nullable()->constrained('trade_settings')->onDelete('cascade');
            $table->string('symbol')->nullable();
            $table->enum('direction', ['up', 'down'])->nullable();
            $table->decimal('open_price', 15, 8)->nullable();
            $table->decimal('close_price', 15, 8)->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->decimal('payout_rate', 5, 2)->nullable();
            $table->timestamp('open_time')->nullable();
            $table->timestamp('expiry_time')->nullable();
            $table->timestamp('close_time')->nullable();
            $table->decimal('profit_loss', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'won', 'lost', 'draw', 'cancelled', 'expired'])->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trade_logs', function (Blueprint $table) {
            $table->dropColumn([
                'trade_id',
                'trade_setting_id',
                'symbol',
                'direction',
                'open_price',
                'close_price',
                'duration_seconds',
                'payout_rate',
                'open_time',
                'expiry_time',
                'close_time',
                'profit_loss',
                'notes'
            ]);

            // Restore original columns
            $table->integer('crypto_currency_id')->nullable();
            $table->decimal('original_price', 28, 8)->default(0);
            $table->integer('duration')->nullable();
            $table->timestamp('arrival_time')->nullable();
            $table->tinyInteger('volume')->default(\App\Enums\Trade\TradeVolume::HIGH->value);
            $table->tinyInteger('outcome')->default(\App\Enums\Trade\TradeOutcome::DRAW->value);
            $table->tinyInteger('status')->default(\App\Enums\Trade\TradeStatus::RUNNING->value)->change();
            $table->tinyInteger('meta')->nullable();
        });
    }
};
