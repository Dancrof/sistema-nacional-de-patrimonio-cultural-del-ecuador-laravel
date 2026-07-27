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
        Schema::create('artwork_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artwork_id')
                ->constrained('artworks')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('title', 255);
            $table->string('author', 255)->nullable();
            $table->string('isbn', 20)->nullable();
            $table->enum('source_type', ['libro', 'sitio web', 'articulo', 'revista', 'periodico', 'otros'])->default('libro');
            $table->string('url', 500)->nullable();
            $table->date('published_at')->nullable();
            $table->timestamps();

            $table->index('artwork_id', 'idx_artwork_sources_artwork');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artwork_sources');
    }
};
