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
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('conservation_status_id')->nullable()->constrained('conservation_statuses');
            $table->foreignId('artwork_type_id')->constrained('artwork_types');
            $table->foreignId('province_id')->constrained('provinces');
            $table->foreignId('canton_id')->constrained('cantons');
            $table->foreignId('parish_id')->nullable()->constrained('parishes');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->unsignedSmallInteger('reading_time')->nullable();
            $table->string('code', 30)->unique();
            $table->string('title', 255);
            $table->string('seo_title', 255)->nullable();
            $table->string('slug', 255)->unique();
            $table->text('short_description')->nullable();
            $table->longText('description');
            $table->string('language', 10)->default('es');
            $table->string('seo_description', 255)->nullable();
            $table->longText('historical_context')->nullable();
            $table->year('creation_year')->nullable();
            $table->string('dimensions', 100)->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('address', 255)->nullable();
            $table->decimal('estimated_value', 12, 2)->nullable();
            $table->text('accessibility_notes')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->unsignedInteger('visit_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['borrador', 'pendiente', 'publicado', 'archivado'])->default('borrador');
            $table->foreignId('published_by')->nullable()->constrained('users');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('title', 'idx_artworks_title');
            $table->index('creation_year', 'idx_artworks_creation_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artworks');
    }
};
