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
        Schema::create('player_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_profile_id')->nullable()->constrained('player_profiles')->nullOnDelete();
            $table->string('player_name_snapshot', 140);
            $table->string('slug', 180)->unique();
            $table->unsignedBigInteger('value_ngn');
            $table->unsignedBigInteger('previous_value_ngn')->nullable();
            $table->string('value_change', 20)->default('stable');
            $table->text('assessment_note')->nullable();
            $table->date('assessed_at');
            $table->string('assessor_name', 120)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'is_featured', 'sort_order'], 'player_values_pub_feature_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_values');
    }
};
