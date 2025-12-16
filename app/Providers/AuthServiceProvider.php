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

        // Глобальный шлюз для модераторов (ЛР №7)
        Gate::before(function ($user, $ability) {
            if ($user->isModerator()) {
                return true; // Модераторам разрешено всё
            }
        });

        // Кастомные шлюзы
        Gate::define('manage-articles', function ($user) {
            return $user->isModerator();
        });

        Gate::define('manage-comments', function ($user) {
            return $user->isModerator();
        });

        Gate::define('create-comment', function ($user) {
            return $user->isReader() || $user->isModerator();
        });
    }
}