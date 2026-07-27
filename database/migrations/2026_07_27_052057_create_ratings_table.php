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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artwork_id')->constrained('artworks');
            $table->foreignId('user_id')->constrained('users');
            $table->unsignedTinyInteger('rating');
            $table->text('review')->nullable();
            $table->timestamps();

            $table->index('artwork_id', 'idx_ratings_artwork');
            $table->index('user_id', 'idx_ratings_user');
            $table->unique(['user_id', 'artwork_id'], 'uk_ratings_user_artwork');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
