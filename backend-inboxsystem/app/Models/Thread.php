<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;


class Thread extends Model
{
    use HasFactory;
    protected $casts = [ 'last_message_at' => 'datetime' ];
    protected $fillable = [ 'subject', 'created_by', 'last_message_at', 'status' ];

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
    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
    
    /**
     * Obtiene todos los participantes del thread excluyendo a un usuario específico 
     *
     * @param int $userId ID del usuario a excluir de la relación.
     * @return Collection<int, \App\Models\User> Colección filtrada y única de usuarios.
     */

    public function participantsExcept(int $userId): Collection
    {
        return $this->users()
            ->get()
            ->push($this->creator)
            ->unique('id')
            ->reject(fn($user) => $user->id === $userId);
    }
}