<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // УБИРАЕМ конструктор! Middleware настраиваем в роутах
    
    public function index()
    {
        $comments = Comment::with(['article', 'user'])
            ->latest()
            ->paginate(20);
        
        return view('comments.index', compact('comments'));
    }

    public function create()
    {
        $this->authorize('create', Comment::class);
        $articles = Article::published()->get();
        return view('comments.create', compact('articles'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Comment::class);
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'content' => 'required|string|min:5|max:1000'
        ], [
            'article_id.required' => 'Выберите статью',
            'content.required' => 'Комментарий не может быть пустым',
            'content.min' => 'Комментарий должен содержать минимум 5 символов'
        ]);
        
        $comment = Comment::create([
            'article_id' => $validated['article_id'],
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'is_approved' => false // По умолчанию на модерации
        ]);
        
        return redirect()
            ->route('articles.show', $comment->article->slug)
            ->with('success', 'Комментарий отправлен на модерацию!');
    }

    public function show(Comment $comment)
    {
        return view('comments.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        if (Auth::id() !== $comment->user_id) {
            abort(403, 'У вас нет прав на редактирование этого комментария');
        }
        
        $validated = $request->validate([
            'content' => 'required|string|min:5|max:1000'
        ]);
        
        $comment->update([
            'content' => $validated['content'],
            'is_approved' => false // При редактировании снова на модерацию
        ]);
        
        return redirect()
            ->route('articles.show', $comment->article->slug)
            ->with('success', 'Комментарий обновлен и отправлен на модерацию!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        if (Auth::id() !== $comment->user_id) {
            abort(403, 'У вас нет прав на удаление этого комментария');
        }
        
        $articleSlug = $comment->article->slug;
        $comment->delete();
        
        return redirect()
            ->route('articles.show', $articleSlug)
            ->with('success', 'Комментарий удален!');
    }
    
    // Дополнительные методы для модерации
    public function approve(Comment $comment)
    {
        $this->authorize('approve', Comment::class);
        $comment->update(['is_approved' => true]);
        
        return back()->with('success', 'Комментарий одобрен!');
    }
    
    public function reject(Comment $comment)
    {
        $this->authorize('reject', Comment::class);
        $comment->delete();
        
        return back()->with('success', 'Комментарий отклонен и удален!');
    }
}