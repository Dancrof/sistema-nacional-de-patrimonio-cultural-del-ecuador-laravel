<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'first_name',
    'last_name',
    'full_name',
    'slug',
    'birth_date',
    'birth_place',
    'death_date',
    'is_deceased',
    'nationality',
    'biography',
    'profile_image',
    'website',
])]
class Artist extends Model
{
    use SoftDeletes;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'death_date' => 'date',
            'is_deceased' => 'boolean',
        ];
    }

    public function artworks(): BelongsToMany
    {
        return $this->belongsToMany(Artwork::class, 'artwork_artist');
    }
}
