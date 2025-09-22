<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->dropColumn([
                'founder_allocation',
                'investor_allocation',
                'public_allocation',
                'smart_contract_address',
            ]);
            $table->text('description')->nullable();
            $table->timestamp('price_updated_at')->nullable();
            $table->bigInteger('tokens_sold')->default(0);
            $table->date('sale_start_date');
            $table->date('sale_end_date');
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['active', 'paused', 'completed', 'cancelled'])->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->decimal('founder_allocation', 30, 18);
            $table->decimal('investor_allocation', 30, 18);
            $table->decimal('public_allocation', 30, 18);
            $table->string('smart_contract_address')->nullable();
            $table->dropColumn([
                'description',
                'price_updated_at',
                'tokens_sold',
                'sale_start_date',
                'sale_end_date',
                'is_featured'
            ]);

            $table->tinyInteger('status')->default(\App\Enums\Status::ACTIVE->value)->change();
        });
    }
};
