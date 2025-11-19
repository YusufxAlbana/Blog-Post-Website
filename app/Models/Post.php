<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title', // max 100 chars
        'body', // max 10000 chars
        'slug',
        'featured_image',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
    
    public function images()
    {
        return $this->hasMany(PostImage::class)->orderBy('order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return null;
    }

    public function postLikes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function isLikedBy($user): bool
    {
        if (!$user) return false;
        return $this->postLikes()->where('user_id', $user->id)->exists();
    }

    public function likesCount(): int
    {
        return $this->postLikes()->count();
    }

    public function canBeLikedBy($user): bool
    {
        if (!$user) return false;
        return true; // Everyone can like any post
    }
}
