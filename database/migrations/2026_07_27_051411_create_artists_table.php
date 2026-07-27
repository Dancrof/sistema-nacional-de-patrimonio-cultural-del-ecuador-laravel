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
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('full_name', 200);
            $table->string('slug', 255)->unique();
            $table->date('birth_date')->nullable();
            $table->string('birth_place', 150)->nullable();
            $table->date('death_date')->nullable();
            $table->boolean('is_deceased')->default(false);
            $table->string('nationality', 100)->nullable();
            $table->longText('biography')->nullable();
            $table->string('profile_image', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('full_name', 'idx_artists_full_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
