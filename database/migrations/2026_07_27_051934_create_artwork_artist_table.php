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
        Schema::create('artwork_artist', function (Blueprint $table) {
            $table->foreignId('artwork_id')
                ->constrained('artworks')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('artist_id')
                ->constrained('artists')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->primary(['artwork_id', 'artist_id']);
            $table->index('artist_id', 'idx_artwork_artist_artist');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artwork_artist');
    }
};
