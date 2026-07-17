<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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

    /**
     * Get key to save on token
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Set extra data on token
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get all user threads
     */
    public function threads(): BelongsToMany
    {
        return $this->belongsToMany(Thread::class)->withPivot('last_read_at')->withTimestamps();
    }

    /**
     * Get user messages
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get user Threads
     */
    public function createdThreads(): HasMany
    {
        return $this->hasMany(Thread::class, 'created_by');
    }

}
