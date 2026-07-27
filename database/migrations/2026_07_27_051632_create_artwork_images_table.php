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
        Schema::create('artwork_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artwork_id')->constrained('artworks');
            $table->string('photographer', 150)->nullable();
            $table->string('image_path', 255);
            $table->string('caption', 255)->nullable();
            $table->string('alt_text', 255)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->string('image_hash', 64)->nullable();
            $table->unsignedSmallInteger('display_order')->default(1);
            $table->boolean('is_cover')->default(false);
            $table->timestamps();

            $table->index('artwork_id', 'idx_artwork_images_artwork');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artwork_images');
    }
};
