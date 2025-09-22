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
        Schema::table('deposits', function (Blueprint $table) {
            $table->string('currency')->nullable();
        });

        Schema::table('pin_generates', function (Blueprint $table) {
            $table->decimal('charge', 28,8)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn('currency');
        });

        Schema::table('pin_generates', function (Blueprint $table) {
            $table->dropColumn('charge');
        });
    }
};
