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
        Schema::create('live_scores', function (Blueprint $table) {
            $table->id();
            $table->string('title', 180);
            $table->string('slug', 200)->unique();
            $table->string('competition', 120)->nullable();
            $table->string('home_team', 120);
            $table->string('away_team', 120);
            $table->string('venue', 180)->nullable();
            $table->timestamp('kickoff_at');
            $table->unsignedTinyInteger('home_score')->nullable();
            $table->unsignedTinyInteger('away_score')->nullable();
            $table->string('match_status', 20)->default('upcoming');
            $table->unsignedTinyInteger('live_minute')->nullable();
            $table->text('match_report')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'match_status', 'kickoff_at'], 'live_scores_pub_status_kickoff_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_scores');
    }
};
