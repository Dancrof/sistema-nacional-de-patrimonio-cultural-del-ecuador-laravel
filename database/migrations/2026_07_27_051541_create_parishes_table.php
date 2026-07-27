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
        Schema::create('parishes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canton_id')->constrained('cantons');
            $table->string('name', 100);
            $table->string('slug', 120);
            $table->timestamps();

            $table->unique(['canton_id', 'name'], 'uk_parishes_cantons_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parishes');
    }
};
