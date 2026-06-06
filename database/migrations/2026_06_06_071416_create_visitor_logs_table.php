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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->nullable();
            $table->string('session_id', 255)->nullable();
            $table->string('url', 255);
            $table->string('referrer', 255)->nullable();
            $table->string('country', 100)->default('Unknown');
            $table->string('browser', 80)->default('Other');
            $table->string('device_type', 40)->default('Desktop');
            $table->text('user_agent')->nullable();
            $table->timestamps();

            // Indexes for dashboard aggregation
            $table->index('created_at');
            $table->index('session_id');
            $table->index('country');
            $table->index('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
