<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Все могут видеть комментарии
    }

    public function view(User $user, Comment $comment): bool
    {
        return true; // Все могут просматривать комментарии
    }

    public function create(User $user): bool
    {
        return $user->isReader(); // Читатель и модератор могут создавать
    }

    public function update(User $user, Comment $comment): bool
    {
        // Модератор или автор комментария
        return $user->isModerator() || $user->id === $comment->user_id;
    }

    public function delete(User $user, Comment $comment): bool
    {
        // Модератор или автор комментария
        return $user->isModerator() || $user->id === $comment->user_id;
    }

    public function approve(User $user, Comment $comment): bool
    {
        return $user->isModerator(); // Только модератор
    }

    public function reject(User $user, Comment $comment): bool
    {
        return $user->isModerator(); // Только модератор
    }

    public function restore(User $user, Comment $comment): bool
    {
        return $user->isModerator();
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->isModerator();
    }
}