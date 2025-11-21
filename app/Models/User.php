<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getAvatarUrlAttribute(): string
    {
        // If user has uploaded avatar, use it
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        // Anonymous users get the BLOGMOUS logo as avatar
        if ($this->isAnonymous()) {
            return asset('assets/logo.png');
        }
        
        // Default avatar using UI Avatars
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=200&background=random';
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Users that this user follows
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')->withTimestamps();
    }

    // Users that follow this user
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')->withTimestamps();
    }

    public function isFollowing($userId): bool
    {
        return $this->following()->where('following_id', $userId)->exists();
    }

    public function followersCount(): int
    {
        return $this->followers()->count();
    }

    public function followingCount(): int
    {
        return $this->following()->count();
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_members')
            ->withPivot('is_admin')
            ->withTimestamps();
    }

    public function createdGroups()
    {
        return $this->hasMany(Group::class, 'created_by');
    }

    public function mutualFollowers()
    {
        // Users who follow me AND I follow them back
        return $this->followers()
            ->whereIn('users.id', function($query) {
                $query->select('following_id')
                    ->from('follows')
                    ->where('follower_id', $this->id);
            });
    }

    // Anonymous mode helper
    public function isAnonymous(): bool
    {
        return $this->email === 'anonymous@system.local';
    }

    public function canBeInvitedToGroup(): bool
    {
        return !$this->isAnonymous();
    }

    public function canReceiveMessages(): bool
    {
        return !$this->isAnonymous();
    }

    public function canBeFollowed(): bool
    {
        return !$this->isAnonymous();
    }

    public function canViewProfile(): bool
    {
        return !$this->isAnonymous();
    }
}
