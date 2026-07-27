<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'slug'])]
class Tag extends Model
{
    use SoftDeletes;

    public function artworks(): BelongsToMany
    {
        return $this->belongsToMany(Artwork::class, 'artwork_tag');
    }
}
