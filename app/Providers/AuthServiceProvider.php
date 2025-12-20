<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Comment;
use App\Policies\ArticlePolicy;
use App\Policies\CommentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Gate для модератора
        Gate::define('moderator', function ($user) {
            return $user->isModerator();
        });

        // Gate для читателя
        Gate::define('reader', function ($user) {
            return $user->isReader();
        });

        // Gate для управления статьями
        Gate::define('manage-articles', function ($user) {
            return $user->isModerator();
        });

        // Gate для управления комментариями
        Gate::define('manage-comments', function ($user) {
            return $user->isModerator();
        });

        // Gate для модерации комментариев
        Gate::define('moderate-comments', function ($user) {
            return $user->isModerator();
        });
    }
}