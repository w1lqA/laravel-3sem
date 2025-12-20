<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function hasPermission($permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    public static function findByName(string $name): ?self
    {
        return self::where('name', $name)->first();
    }

    public static function findById(int $id): ?self
    {
        return self::find($id);
    }

    public function isModerator(): bool
    {
        return $this->slug === 'moderator';
    }

    public function isReader(): bool
    {
        return $this->slug === 'reader';
    }
}