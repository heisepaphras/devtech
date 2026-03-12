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
        Schema::create('scouting_programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('age_group', 50)->nullable();
            $table->string('schedule')->nullable();
            $table->unsignedSmallInteger('duration_weeks')->nullable();
            $table->unsignedSmallInteger('capacity')->nullable();
            $table->string('registration_link')->nullable();
            $table->string('fee')->nullable();
            $table->text('description')->nullable();
            $table->text('highlights')->nullable();
            $table->text('requirements')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'is_featured', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scouting_programs');
    }
};
