<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'category_id',
    'conservation_status_id',
    'artwork_type_id',
    'province_id',
    'canton_id',
    'parish_id',
    'created_by',
    'updated_by',
    'reading_time',
    'code',
    'title',
    'seo_title',
    'slug',
    'short_description',
    'description',
    'language',
    'seo_description',
    'historical_context',
    'creation_year',
    'dimensions',
    'weight',
    'address',
    'estimated_value',
    'accessibility_notes',
    'latitude',
    'longitude',
    'visit_count',
    'average_rating',
    'is_featured',
    'status',
    'published_by',
    'published_at',
])]
class Artwork extends Model
{
    use SoftDeletes;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'weight' => 'decimal:2',
            'estimated_value' => 'decimal:2',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'average_rating' => 'decimal:2',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'creation_year' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function conservationStatus(): BelongsTo
    {
        return $this->belongsTo(ConservationStatus::class);
    }

    public function artworkType(): BelongsTo
    {
        return $this->belongsTo(ArtworkType::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function canton(): BelongsTo
    {
        return $this->belongsTo(Canton::class);
    }

    public function parish(): BelongsTo
    {
        return $this->belongsTo(Parish::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class, 'artwork_artist');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'artwork_tag');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ArtworkImage::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(ArtworkVideo::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ArtworkDocument::class);
    }

    public function sources(): HasMany
    {
        return $this->hasMany(ArtworkSource::class);
    }

    public function restorationEvents(): HasMany
    {
        return $this->hasMany(RestorationEvent::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(ArtworkView::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withPivot('created_at');
    }
}
