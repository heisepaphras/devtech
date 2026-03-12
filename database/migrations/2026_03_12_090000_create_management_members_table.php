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
        Schema::create('management_members', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 140);
            $table->string('slug', 180)->unique();
            $table->string('role_title', 120);
            $table->string('department', 80)->nullable();
            $table->string('email', 160)->nullable();
            $table->string('phone', 40)->nullable();
            $table->text('bio')->nullable();
            $table->string('image_path', 255)->nullable();
            $table->unsignedTinyInteger('experience_years')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'is_featured', 'sort_order'], 'management_members_pub_feature_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('management_members');
    }
};
