<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['article', 'user'])
            ->latest()
            ->paginate(20);
        
        return view('comments.index', compact('comments'));
    }

    public function create()
    {
        $articles = Article::published()->get();
        return view('comments.create', compact('articles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'content' => 'required|string|min:5|max:1000'
        ], [
            'article_id.required' => 'Выберите статью',
            'content.required' => 'Комментарий не может быть пустым',
            'content.min' => 'Комментарий должен содержать минимум 5 символов'
        ]);
        
        // ВРЕМЕННО: user_id = null (так как нет аутентификации)
        $comment = Comment::create([
            'article_id' => $validated['article_id'],
            'user_id' => null, // Временно null
            'content' => $validated['content'],
            'is_approved' => true // Временно сразу одобряем
        ]);
        
        return redirect()
            ->route('articles.show', $comment->article->slug)
            ->with('success', 'Комментарий успешно добавлен!');
    }

    public function show(Comment $comment)
    {
        return view('comments.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        // ВРЕМЕННО: разрешаем всем редактировать
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:5|max:1000'
        ]);
        
        $comment->update([
            'content' => $validated['content'],
            'is_approved' => false // При редактировании снова на модерацию
        ]);
        
        return redirect()
            ->route('articles.show', $comment->article->slug)
            ->with('success', 'Комментарий обновлен!');
    }

    public function destroy(Comment $comment)
    {
        $articleSlug = $comment->article->slug;
        $comment->delete();
        
        return redirect()
            ->route('articles.show', $articleSlug)
            ->with('success', 'Комментарий удален!');
    }
    
    // Дополнительные методы для модерации
    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        
        return back()->with('success', 'Комментарий одобрен!');
    }
    
    public function reject(Comment $comment)
    {
        $comment->delete();
        
        return back()->with('success', 'Комментарий отклонен и удален!');
    }
}