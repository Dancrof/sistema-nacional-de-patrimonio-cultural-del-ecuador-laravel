<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'description'])]
class ArtworkType extends Model
{
    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }
}
