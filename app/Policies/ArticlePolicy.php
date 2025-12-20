<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Все могут видеть статьи
    }

    public function view(User $user, Article $article): bool
    {
        return true; // Все могут просматривать статьи
    }

    public function create(User $user): bool
    {
        return $user->isModerator(); // Только модератор
    }

    public function update(User $user, Article $article): bool
    {
        return $user->isModerator(); // Только модератор
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->isModerator(); // Только модератор
    }

    public function restore(User $user, Article $article): bool
    {
        return $user->isModerator();
    }

    public function forceDelete(User $user, Article $article): bool
    {
        return $user->isModerator();
    }
}