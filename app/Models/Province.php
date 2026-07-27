<?php

namespace App\Models;

use Database\Factories\ProvinceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'slug',
    'region',
    'description',
    'cover_image',
    'latitude',
    'longitude',
])]
class Province extends Model
{
    /** @use HasFactory<ProvinceFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    public function cantons(): HasMany
    {
        return $this->hasMany(Canton::class);
    }

    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }
}
