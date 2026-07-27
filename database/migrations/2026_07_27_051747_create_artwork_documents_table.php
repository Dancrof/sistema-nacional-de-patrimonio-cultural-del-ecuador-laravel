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
        Schema::create('artwork_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artwork_id')->constrained('artworks');
            $table->string('title', 255);
            $table->string('file_name', 255);
            $table->text('description')->nullable();
            $table->string('file_path', 255);
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('file_size');
            $table->unsignedInteger('download_count')->default(0);
            $table->timestamps();

            $table->index('artwork_id', 'idx_artwork_documents_artwork');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artwork_documents');
    }
};
