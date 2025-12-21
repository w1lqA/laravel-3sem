<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Mail\NewArticleNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendNewArticleNotification;

class ArticleController extends Controller
{

    public function index()
    {
        $filter = request('filter', 'all');
        
        $articles = Article::query();
        
        if ($filter === 'popular') {
            $articles->popular();
        } else {
            $articles->latest();
        }
        
        $articles = $articles->paginate(6);
        
        return view('articles.index', compact('articles', 'filter'));
    }

    public function create()
    {
        if (!auth()->user()->isModerator()) {
            abort(403, 'Доступ запрещен. Только модераторы могут создавать статьи.');
        }
        
        return view('articles.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isModerator()) {
            abort(403, 'Доступ запрещен. Только модераторы могут создавать статьи.');
        }
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:200',
            'content' => 'required|string|min:20',
            'short_desc' => 'nullable|string|max:300',
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'full_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'is_published' => 'boolean'
        ], [
            'title.required' => 'Заголовок обязателен',
            'title.min' => 'Заголовок должен быть минимум 5 символов',
            'content.required' => 'Содержание статьи обязательно',
            'content.min' => 'Содержание должно быть минимум 20 символов',
            'preview_image.image' => 'Файл должен быть изображением',
            'preview_image.max' => 'Размер изображения не должен превышать 2MB',
            'full_image.max' => 'Размер изображения не должен превышать 5MB'
        ]);
        
        // Создаем slug из заголовка
        $slug = Str::slug($validated['title']) . '-' . rand(1000, 9999);
        
        // Обработка изображений
        $previewImagePath = null;
        $fullImagePath = null;
        
        if ($request->hasFile('preview_image')) {
            $previewImagePath = $request->file('preview_image')->store('articles', 'public');
        }
        
        if ($request->hasFile('full_image')) {
            $fullImagePath = $request->file('full_image')->store('articles', 'public');
        }
        
        $article = Article::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'short_desc' => $validated['short_desc'] ?? null,
            'preview_image' => $previewImagePath,
            'full_image' => $fullImagePath,
            'is_published' => $validated['is_published'] ?? true,
            'user_id' => auth()->id(),
        ]);
        
        SendNewArticleNotification::dispatch($article);
        
        return redirect()
            ->route('articles.show', $article->slug)
            ->with('success', 'Статья успешно создана! Уведомления поставлены в очередь для отправки.');
    }

    public function show(Article $article)
    {
        // Увеличиваем счетчик просмотров
        if ($article->is_published) {
            $article->increment('views_count');
        }
        
        // Загружаем только одобренные комментарии
        $article->load(['comments' => function ($query) {
            $query->where('is_approved', true)->latest();
        }]);
        
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        if (!auth()->user()->isModerator()) {
            abort(403, 'Доступ запрещен. Только модераторы могут редактировать статьи.');
        }
        
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        if (!auth()->user()->isModerator()) {
            abort(403, 'Доступ запрещен. Только модераторы могут редактировать статьи.');
        }
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:200',
            'content' => 'required|string|min:20',
            'short_desc' => 'nullable|string|max:300',
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'full_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'is_published' => 'boolean'
        ]);
        
        // Обновляем slug если изменился заголовок
        if ($article->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . rand(1000, 9999);
        }
        
        // Обработка изображений
        if ($request->hasFile('preview_image')) {
            // Удаляем старое изображение если было
            if ($article->preview_image && Storage::disk('public')->exists($article->preview_image)) {
                Storage::disk('public')->delete($article->preview_image);
            }
            $validated['preview_image'] = $request->file('preview_image')->store('articles', 'public');
        } else {
            // Сохраняем старое значение
            $validated['preview_image'] = $article->preview_image;
        }
        
        if ($request->hasFile('full_image')) {
            if ($article->full_image && Storage::disk('public')->exists($article->full_image)) {
                Storage::disk('public')->delete($article->full_image);
            }
            $validated['full_image'] = $request->file('full_image')->store('articles', 'public');
        } else {
            $validated['full_image'] = $article->full_image;
        }
        
        $article->update($validated);
        
        return redirect()
            ->route('articles.show', $article->slug)
            ->with('success', 'Статья успешно обновлена!');
    }

    public function destroy(Article $article)
    {
        if (!auth()->user()->isModerator()) {
            abort(403, 'Доступ запрещен. Только модераторы могут редактировать статьи.');
        }
        // Удаляем изображения
        if ($article->preview_image && Storage::disk('public')->exists($article->preview_image)) {
            Storage::disk('public')->delete($article->preview_image);
        }
        if ($article->full_image && Storage::disk('public')->exists($article->full_image)) {
            Storage::disk('public')->delete($article->full_image);
        }
        
        $article->delete();
        
        return redirect()
            ->route('articles.index')
            ->with('success', 'Статья успешно удалена!');
    }
}