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
        Schema::create('artwork_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artwork_id')->constrained('artworks');
            $table->string('title', 255);
            $table->string('video_url', 255);
            $table->string('thumbnail', 255)->nullable();
            $table->time('duration')->nullable();
            $table->string('provider', 20)->nullable();
            $table->timestamps();

            $table->index('artwork_id', 'idx_artwork_videos_artwork');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artwork_videos');
    }
};
