<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('settings');
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text');
            $table->string('group')->default('general');
            $table->string('label');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->index(['group', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');

        // Recreate old structure
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sms_gateway_id')->nullable();
            $table->json('logo')->nullable();
            $table->json('appearance')->nullable();
            $table->json('matrix_parameters')->nullable();
            $table->json('system_configuration')->nullable();
            $table->json('theme_setting')->nullable();
            $table->json('recaptcha_setting')->nullable();
            $table->json('seo_setting')->nullable();
            $table->json('mail_configuration')->nullable();
            $table->json('social_login')->nullable();
            $table->json('commissions_charge')->nullable();
            $table->json('crypto_api')->nullable();
            $table->json('kyc_configuration')->nullable();
            $table->json('security')->nullable();
            $table->text('sms_template')->nullable();
            $table->text('mail_template')->nullable();
            $table->string('version')->nullable();
            $table->json('referral_setting')->nullable();
            $table->json('holiday_setting')->nullable();
            $table->json('investment_setting')->nullable();
            $table->json('agent_investment_commission')->nullable();
            $table->json('theme_template_setting')->nullable();
            $table->string('maintenance_mode')->nullable();
            $table->timestamps();
        });
    }
};
