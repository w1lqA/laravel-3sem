<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ArticleView;
use Symfony\Component\HttpFoundation\Response;

class TrackArticleView
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        if ($request->isMethod('GET') && $request->route()->getName() === 'articles.show') {
            // Получаем статью из роута (уже привязана через модель)
            $article = $request->route('article');
            
            // Проверяем что это объект Article и статья опубликована
            if ($article instanceof \App\Models\Article && $article->is_published) {
                ArticleView::create([
                    'article_id' => $article->id,
                    'url' => $request->fullUrl(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }
        }
        
        return $response;
    }
}