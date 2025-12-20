<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Автоматически применится политика через AuthServiceProvider
    // или можно явно указать: $this->authorize('action', $comment);
    
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
        ]);
        
        $comment = Comment::create([
            'article_id' => $validated['article_id'],
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'is_approved' => Auth::user()->isModerator()
        ]);
        
        return redirect()
            ->route('articles.show', $comment->article->slug)
            ->with('success', Auth::user()->isModerator() 
                ? 'Комментарий успешно добавлен!' 
                : 'Комментарий отправлен на модерацию!');
    }

    public function show(Comment $comment)
    {
        return view('comments.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        // Проверка через политику CommentPolicy
        if (!Auth::user()->can('update', $comment)) {
            abort(403, 'Доступ запрещен');
        }
        
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        if (!Auth::user()->can('update', $comment)) {
            abort(403, 'Доступ запрещен');
        }
        
        $validated = $request->validate([
            'content' => 'required|string|min:5|max:1000'
        ]);
        
        $comment->update([
            'content' => $validated['content'],
            'is_approved' => Auth::user()->isModerator()
        ]);
        
        return redirect()
            ->route('articles.show', $comment->article->slug)
            ->with('success', 'Комментарий обновлен!');
    }

    public function destroy(Comment $comment)
    {
        if (!Auth::user()->can('delete', $comment)) {
            abort(403, 'Доступ запрещен');
        }
        
        $articleSlug = $comment->article->slug;
        $comment->delete();
        
        return redirect()
            ->route('articles.show', $articleSlug)
            ->with('success', 'Комментарий удален!');
    }
    
    public function approve(Comment $comment)
    {
        if (!Auth::user()->can('approve', $comment)) {
            abort(403, 'Доступ запрещен');
        }
        
        $comment->update(['is_approved' => true]);
        
        return back()->with('success', 'Комментарий одобрен!');
    }
    
    public function reject(Comment $comment)
    {
        if (!Auth::user()->can('reject', $comment)) {
            abort(403, 'Доступ запрещен');
        }
        
        $comment->delete();
        
        return back()->with('success', 'Комментарий отклонен и удален!');
    }
}