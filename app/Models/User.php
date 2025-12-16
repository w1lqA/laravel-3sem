<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Константы ролей
    const ROLE_READER = 'reader';
    const ROLE_MODERATOR = 'moderator';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Связи
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    // Методы проверки ролей
    public function isReader(): bool
    {
        return $this->role === self::ROLE_READER;
    }

    public function isModerator(): bool
    {
        return $this->role === self::ROLE_MODERATOR;
    }

    // Проверка прав
    public function canManageArticles(): bool
    {
        return $this->isModerator();
    }

    public function canManageComments(): bool
    {
        return $this->isModerator();
    }

    public function canComment(): bool
    {
        return $this->isReader() || $this->isModerator();
    }
}