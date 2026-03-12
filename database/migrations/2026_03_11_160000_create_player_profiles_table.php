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
        Schema::create('player_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 140);
            $table->string('slug', 180)->unique();
            $table->unsignedTinyInteger('jersey_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nationality', 80)->nullable();
            $table->string('preferred_foot', 20)->nullable();
            $table->string('primary_position', 80)->nullable();
            $table->string('secondary_position', 80)->nullable();
            $table->unsignedSmallInteger('height_cm')->nullable();
            $table->unsignedSmallInteger('weight_kg')->nullable();
            $table->string('current_team', 160)->nullable();
            $table->string('video_url', 255)->nullable();
            $table->string('summary', 320)->nullable();
            $table->text('bio')->nullable();
            $table->text('strengths')->nullable();
            $table->text('achievements')->nullable();
            $table->string('profile_image', 255)->nullable();
            $table->string('cv_document', 255)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'is_featured', 'sort_order'], 'player_profiles_pub_feature_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_profiles');
    }
};
