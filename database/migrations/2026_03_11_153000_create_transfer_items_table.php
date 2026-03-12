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
        Schema::create('transfer_items', function (Blueprint $table) {
            $table->id();
            $table->string('title', 180);
            $table->string('slug', 200)->unique();
            $table->string('player_name', 120);
            $table->string('position', 80)->nullable();
            $table->string('transfer_type', 40);
            $table->string('from_club', 160)->nullable();
            $table->string('to_club', 160)->nullable();
            $table->string('transfer_fee', 80)->nullable();
            $table->date('contract_until')->nullable();
            $table->string('summary', 320)->nullable();
            $table->text('details')->nullable();
            $table->timestamp('announced_at');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'is_featured', 'announced_at', 'sort_order'], 'transfer_items_pub_feature_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_items');
    }
};
