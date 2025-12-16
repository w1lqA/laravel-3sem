<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Определяем, может ли пользователь просматривать любые комментарии.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Определяем, может ли пользователь просматривать конкретный комментарий.
     */
    public function view(User $user, Comment $comment): bool
    {
        return true;
    }

    /**
     * Определяем, может ли пользователь создавать комментарии.
     */
    public function create(User $user): bool
    {
        // Читатели и модераторы могут комментировать
        return $user->isReader() || $user->isModerator();
    }

    /**
     * Определяем, может ли пользователь обновлять комментарий.
     */
    public function update(User $user, Comment $comment): bool
    {
        // Автор комментария или модератор
        return $user->id === $comment->user_id || $user->isModerator();
    }

    /**
     * Определяем, может ли пользователь удалять комментарий.
     */
    public function delete(User $user, Comment $comment): bool
    {
        // Автор комментария или модератор
        return $user->id === $comment->user_id || $user->isModerator();
    }

    /**
     * Определяем, может ли пользователь одобрить комментарий.
     */
    public function approve(User $user): bool
    {
        return $user->isModerator();
    }

    /**
     * Определяем, может ли пользователь отклонить комментарий.
     */
    public function reject(User $user): bool
    {
        return $user->isModerator();
    }
}