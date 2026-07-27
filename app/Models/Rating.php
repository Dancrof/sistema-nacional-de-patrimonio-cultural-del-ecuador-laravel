<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['artwork_id', 'user_id', 'rating', 'review'])]
class Rating extends Model
{
    public const MIN_RATING = 1;

    public const MAX_RATING = 5;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    public function artwork(): BelongsTo
    {
        return $this->belongsTo(Artwork::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
