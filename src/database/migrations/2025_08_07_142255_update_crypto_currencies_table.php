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
        Schema::table('crypto_currencies', function (Blueprint $table) {
            $table->dropColumn([
                'pair',
                'crypto_id',
                'file',
                'top_gainer',
                'top_loser',
                'meta'
            ]);
            $table->enum('type', ['crypto']);
            $table->decimal('current_price', 28, 8)->default(0);
            $table->decimal('previous_price', 28, 8)->default(0);
            $table->decimal('total_volume', 28, 8)->default(0);
            $table->decimal('market_cap', 28, 8)->default(0);
            $table->integer('rank')->default(0);
            $table->decimal('change_percent', 10, 4)->nullable();
            $table->string('base_currency', 3)->default('USD');
            $table->string('image_url', 500)->nullable();
            $table->string('tradingview_symbol', 50)->nullable();
            $table->timestamp('last_updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crypto_currencies', function (Blueprint $table) {
            $table->dropColumn([
                'symbol',
                'type',
                'current_price',
                'previous_price',
                'total_volume',
                'market_cap',
                'rank',
                'change_percent',
                'base_currency',
                'image_url',
                'tradingview_symbol',
                'last_updated'
            ]);

            $table->string('pair', 190);
            $table->string('crypto_id', 190);
            $table->text('file')->nullable();
            $table->tinyInteger('top_gainer')->nullable();
            $table->tinyInteger('top_loser')->nullable();
            $table->json('meta')->nullable();
        });
    }
};
