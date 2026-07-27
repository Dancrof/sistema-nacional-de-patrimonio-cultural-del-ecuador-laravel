<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'artwork_id',
    'title',
    'file_name',
    'description',
    'file_path',
    'mime_type',
    'file_size',
    'download_count',
])]
class ArtworkDocument extends Model
{
    public function artwork(): BelongsTo
    {
        return $this->belongsTo(Artwork::class);
    }
}
