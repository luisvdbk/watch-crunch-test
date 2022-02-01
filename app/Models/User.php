<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_posted_at' => 'datetime',
    ];

    protected static function booted()
    {
        /** this could also be in an observer */
        static::saving(function (User $user) {
            $user->username_lowercased = Str::lower($user->username);
        });
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function lastPost(): HasOne
    {
        return $this->hasOne(Post::class, 'last_post_id');
    }

    public function scopeByUsername(Builder $query, string $username): Builder
    {
        return $query->where('username_lowercased', Str::lower($username));
    }
}
