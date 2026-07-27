<?php

namespace App\Models;

use Database\Factories\CantonFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['province_id', 'name', 'slug'])]
class Canton extends Model
{
    /** @use HasFactory<CantonFactory> */
    use HasFactory;

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function parishes(): HasMany
    {
        return $this->hasMany(Parish::class);
    }

    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }
}
