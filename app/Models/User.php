<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'role_id',
    'first_name',
    'last_name',
    'username',
    'email',
    'password',
    'avatar',
    'phone',
    'biography',
    'is_active',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public static function findActiveByEmailOrUsername(string $identifier): ?self
    {
        return static::query()
            ->active()
            ->where(function (Builder $query) use ($identifier) {
                $query->where('email', $identifier)
                    ->orWhere('username', $identifier);
            })
            ->first();
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function artworksCreated(): HasMany
    {
        return $this->hasMany(Artwork::class, 'created_by');
    }

    public function artworksUpdated(): HasMany
    {
        return $this->hasMany(Artwork::class, 'updated_by');
    }

    public function artworksPublished(): HasMany
    {
        return $this->hasMany(Artwork::class, 'published_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function favoriteArtworks(): BelongsToMany
    {
        return $this->belongsToMany(Artwork::class, 'favorites')
            ->withPivot('created_at');
    }

    public function artworkViews(): HasMany
    {
        return $this->hasMany(ArtworkView::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }
}
