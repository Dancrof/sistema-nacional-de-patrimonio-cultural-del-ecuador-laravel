<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'slug', 'description', 'icon'])]
class Category extends Model
{
    use SoftDeletes;

    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }
}
