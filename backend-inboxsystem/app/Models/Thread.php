<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['subject', 'created_by', 'last_message_at', 'status'])]

class Thread extends Model
{
    protected $casts = [
        'last_message_at' => 'datetime'
    ];

    /**
     * Get thread creator
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }

    /**
     * Get thread participant users
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('last_read_at')->withTimestamps();
    }

    /**
     * Get thread messages
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get last message
     */
    public function latestMessage(): HasMany
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
}