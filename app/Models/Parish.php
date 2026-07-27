<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['canton_id', 'name', 'slug'])]
class Parish extends Model
{
    public function canton(): BelongsTo
    {
        return $this->belongsTo(Canton::class);
    }

    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }
}
