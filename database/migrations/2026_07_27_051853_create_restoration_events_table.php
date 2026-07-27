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
        Schema::create('restoration_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artwork_id')
                ->constrained('artworks')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->date('restoration_date');
            $table->string('organization', 255)->nullable();
            $table->longText('description');
            $table->timestamps();

            $table->index('artwork_id', 'idx_restoration_events_artwork');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restoration_events');
    }
};
