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
        Schema::create('token_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ico_token_id')->nullable();
            $table->string('sale_id')->unique();
            $table->integer('tokens_sold');
            $table->decimal('sale_price', 15, 4);
            $table->decimal('total_amount', 15, 2);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');
            $table->timestamp('sold_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_sales');
    }
};
