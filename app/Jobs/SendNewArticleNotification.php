<?php

namespace App\Jobs;

use App\Mail\NewArticleNotification;
use App\Models\Article;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewArticleNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Свойство $article будет автоматически сериализовано в очередь
    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    // Метод handle() выполняется, когда задание извлекается из очереди
    public function handle()
    {
        // Находим всех модераторов (та же логика, что и в контроллере)
        $moderators = User::whereHas('roles', function ($query) {
            $query->where('slug', 'moderator');
        })->get();

        // Отправляем письмо каждому модератору
        foreach ($moderators as $moderator) {
            Mail::to($moderator->email)->send(new NewArticleNotification($this->article));
        }
    }
}