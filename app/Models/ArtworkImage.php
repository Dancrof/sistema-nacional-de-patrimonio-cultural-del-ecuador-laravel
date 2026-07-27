<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'artwork_id',
    'photographer',
    'image_path',
    'caption',
    'alt_text',
    'file_size',
    'width',
    'height',
    'mime_type',
    'image_hash',
    'display_order',
    'is_cover',
])]
class ArtworkImage extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_cover' => 'boolean',
        ];
    }

    public function artwork(): BelongsTo
    {
        return $this->belongsTo(Artwork::class);
    }
}
