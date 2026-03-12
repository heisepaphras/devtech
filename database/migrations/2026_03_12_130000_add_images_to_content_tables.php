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
        Schema::table('event_items', function (Blueprint $table) {
            $table->string('featured_image', 255)->nullable()->after('registration_link');
        });

        Schema::table('transfer_items', function (Blueprint $table) {
            $table->string('player_image', 255)->nullable()->after('transfer_fee');
        });

        Schema::table('player_values', function (Blueprint $table) {
            $table->string('player_image', 255)->nullable()->after('player_name_snapshot');
        });

        Schema::table('live_scores', function (Blueprint $table) {
            $table->string('home_logo', 255)->nullable()->after('home_team');
            $table->string('away_logo', 255)->nullable()->after('away_team');
        });

        Schema::table('scouting_programs', function (Blueprint $table) {
            $table->string('featured_image', 255)->nullable()->after('registration_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scouting_programs', function (Blueprint $table) {
            $table->dropColumn('featured_image');
        });

        Schema::table('live_scores', function (Blueprint $table) {
            $table->dropColumn(['home_logo', 'away_logo']);
        });

        Schema::table('player_values', function (Blueprint $table) {
            $table->dropColumn('player_image');
        });

        Schema::table('transfer_items', function (Blueprint $table) {
            $table->dropColumn('player_image');
        });

        Schema::table('event_items', function (Blueprint $table) {
            $table->dropColumn('featured_image');
        });
    }
};
