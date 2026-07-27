<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'artwork_id',
    'title',
    'video_url',
    'thumbnail',
    'duration',
    'provider',
])]
class ArtworkVideo extends Model
{
    public function artwork(): BelongsTo
    {
        return $this->belongsTo(Artwork::class);
    }
}
