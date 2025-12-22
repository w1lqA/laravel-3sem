<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ArticleView;
use App\Models\Comment;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyStatsMail;
use Illuminate\Support\Facades\DB;

class SendDailyStats extends Command
{
    protected $signature = 'stats:daily';
    protected $description = 'Send daily statistics to moderators';

    public function handle()
    {
        // 1. Получаем статистику за сегодня
        $today = now()->format('Y-m-d');
        
        // Количество просмотров статей за сегодня
        $viewsToday = ArticleView::whereDate('created_at', $today)->count();
        
        // Количество просмотров по статьям (топ-5) - исправленный запрос
        $topArticles = ArticleView::whereDate('created_at', $today)
            ->select('article_id', DB::raw('COUNT(*) as views'))
            ->groupBy('article_id')
            ->with(['article' => function ($query) {
                $query->select('id', 'title');
            }])
            ->orderByDesc('views')
            ->take(5)
            ->get();
        
        // Количество новых комментариев за сегодня
        $newCommentsToday = Comment::whereDate('created_at', $today)->count();
        $newCommentsApproved = Comment::whereDate('created_at', $today)
            ->where('is_approved', true)
            ->count();
        
        // Количество комментариев ожидающих модерации
        $pendingComments = Comment::where('is_approved', false)->count();
        
        // 2. Получаем всех модераторов
        $moderators = User::whereHas('roles', function ($query) {
            $query->where('slug', 'moderator');
        })->get();
        
        if ($moderators->isEmpty()) {
            $this->error('No moderators found!');
            return;
        }
        
        // 3. Подготавливаем данные для письма
        $statsData = [
            'date' => $today,
            'views_today' => $viewsToday,
            'top_articles' => $topArticles,
            'new_comments_today' => $newCommentsToday,
            'new_comments_approved' => $newCommentsApproved,
            'pending_comments' => $pendingComments,
            'total_articles' => Article::count(),
            'total_comments' => Comment::count(),
        ];
        
        // 4. Отправляем письмо каждому модератору
        foreach ($moderators as $moderator) {
            try {
                Mail::to($moderator->email)->send(new DailyStatsMail($statsData));
                $this->info("Daily stats sent to: {$moderator->email}");
            } catch (\Exception $e) {
                $this->error("Failed to send to {$moderator->email}: " . $e->getMessage());
            }
        }
        
        $this->info('Daily statistics sent successfully!');
    }
}