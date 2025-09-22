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
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('symbol');
            $table->decimal('total_supply', 30, 18);
            $table->decimal('price', 30, 18);
            $table->decimal('founder_allocation', 30, 18);
            $table->decimal('investor_allocation', 30, 18);
            $table->decimal('public_allocation', 30, 18);
            $table->decimal('current_price', 30, 18)->default(0);
            $table->string('smart_contract_address')->nullable();
            $table->tinyInteger('status')->default(\App\Enums\Status::ACTIVE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
