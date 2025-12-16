<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Определяем, может ли пользователь просматривать любые статьи.
     */
    public function viewAny(User $user): bool
    {
        return true; // Все могут просматривать статьи
    }

    /**
     * Определяем, может ли пользователь просматривать конкретную статью.
     */
    public function view(User $user, Article $article): bool
    {
        // Если статья опубликована или пользователь - модератор
        return $article->is_published || $user->isModerator();
    }

    /**
     * Определяем, может ли пользователь создавать статьи.
     */
    public function create(User $user): bool
    {
        return $user->isModerator();
    }

    /**
     * Определяем, может ли пользователь обновлять статью.
     */
    public function update(User $user, Article $article): bool
    {
        return $user->isModerator();
    }

    /**
     * Определяем, может ли пользователь удалять статью.
     */
    public function delete(User $user, Article $article): bool
    {
        return $user->isModerator();
    }

    /**
     * Определяем, может ли пользователь восстановить статью.
     */
    public function restore(User $user, Article $article): bool
    {
        return $user->isModerator();
    }

    /**
     * Определяем, может ли пользователь окончательно удалить статью.
     */
    public function forceDelete(User $user, Article $article): bool
    {
        return $user->isModerator();
    }
}