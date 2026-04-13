<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();

            // Hero section text
            $table->string('hero_kicker')->default('KINGS FOOTBALL ACADEMY, ABUJA');
            $table->string('hero_title')->default('Building elite football talent with discipline, identity, and modern coaching.');
            $table->string('hero_copy', 500)->default('Abuja Kings Football Academy develops players for local and international pathways through structured training, tactical intelligence, character building, and consistent match exposure.');
            $table->string('hero_metric_1')->default('Youth Development');
            $table->string('hero_metric_2')->default('Scouting Pathway');
            $table->string('hero_metric_3')->default('Character + Leadership');
            $table->string('hero_trials_label')->default('Next Open Trials');
            $table->string('hero_trials_date')->default('Saturday 9:00 AM');
            $table->string('hero_trials_location')->default('Abuja Kings Training Ground');

            // Hero section images
            $table->string('hero_main_image')->nullable();
            $table->string('hero_thumb_1')->nullable();
            $table->string('hero_thumb_2')->nullable();

            // Visual / "Academy In Motion" section
            $table->string('visual_kicker')->default('Academy In Motion');
            $table->string('visual_title')->default('A Visual Look At Kings');
            $table->string('visual_description')->default('Training intensity, match temperament, and player growth in one pathway.');

            $table->string('visual_card_1_image')->nullable();
            $table->string('visual_card_1_title')->default('Technical Sessions');
            $table->string('visual_card_1_description')->default('Ball mastery, first touch, scanning, and decision speed.');

            $table->string('visual_card_2_image')->nullable();
            $table->string('visual_card_2_title')->default('Competitive Fixtures');
            $table->string('visual_card_2_description')->default('Structured match exposure to test tactical and mental growth.');

            $table->string('visual_card_3_image')->nullable();
            $table->string('visual_card_3_title')->default('Mentorship & Discipline');
            $table->string('visual_card_3_description')->default('Building leaders on and off the pitch through mentorship.');

            $table->timestamps();
        });

        // Seed the single settings row
        DB::table('home_settings')->insert(['created_at' => now(), 'updated_at' => now()]);
    }

    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};
