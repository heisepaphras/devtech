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
        Schema::create('registration_applications', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code', 24)->unique();
            $table->string('full_name', 140);
            $table->date('date_of_birth')->nullable();
            $table->string('guardian_name', 140)->nullable();
            $table->string('phone', 40);
            $table->string('email', 160)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('age_group', 40)->nullable();
            $table->string('preferred_position', 80)->nullable();
            $table->string('preferred_foot', 20)->nullable();
            $table->string('experience_level', 80)->nullable();
            $table->text('medical_notes')->nullable();
            $table->text('additional_notes')->nullable();
            $table->string('status', 20)->default('new');
            $table->text('review_notes')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamp('contacted_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'submitted_at'], 'registration_apps_status_submitted_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_applications');
    }
};
