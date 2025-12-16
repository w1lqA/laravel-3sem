@extends('layouts.app')

@section('title', 'Комментарий #' . $comment->id)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <!-- Хлебные крошки -->
        <div class="mb-6">
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)]">Главная</a>
                <span class="text-[var(--text-light)]">/</span>
                <a href="{{ route('comments.index') }}" class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)]">Комментарии</a>
                <span class="text-[var(--text-light)]">/</span>
                <span class="text-[var(--text-dark)]">Просмотр #{{ $comment->id }}</span>
            </nav>
        </div>
        
        <h1 class="text-3xl font-bold mb-6 text-[var(--text-dark)]">
            Комментарий #{{ $comment->id }}
        </h1>
        
        <!-- Информация о комментарии -->
        <div class="space-y-6 mb-8">
            <div class="border-2 border-[var(--border-color)] p-6">
                <h3 class="text-lg font-bold mb-3 text-[var(--text-dark)]">Содержание:</h3>
                <p class="text-[var(--text-dark)] whitespace-pre-line">{{ $comment->content }}</p>
            </div>
            
            <!-- Мета-информация -->
            <div class="grid md:grid-cols-2 gap-4">
                <div class="border border-[var(--border-color)] p-4">
                    <div class="text-sm text-[var(--text-light)] mb-1">Статус:</div>
                    <div class="font-medium {{ $comment->is_approved ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ $comment->is_approved ? '✅ Одобрен' : '⏳ На модерации' }}
                    </div>
                </div>
                
                <div class="border border-[var(--border-color)] p-4">
                    <div class="text-sm text-[var(--text-light)] mb-1">Дата создания:</div>
                    <div class="font-medium">{{ $comment->created_at->format('d.m.Y H:i:s') }}</div>
                </div>
                
                <div class="border border-[var(--border-color)] p-4">
                    <div class="text-sm text-[var(--text-light)] mb-1">ID статьи:</div>
                    <div class="font-medium">
                        <a href="{{ route('articles.show', $comment->article->slug) }}" 
                           class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)]">
                            #{{ $comment->article_id }} - {{ Str::limit($comment->article->title, 30) }}
                        </a>
                    </div>
                </div>
                
                <div class="border border-[var(--border-color)] p-4">
                    <div class="text-sm text-[var(--text-light)] mb-1">Автор:</div>
                    <div class="font-medium">
                        {{ $comment->user ? $comment->user->name : 'Аноним' }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Действия -->
        <div class="border-t-2 border-[var(--border-color)] pt-6">
            <div class="flex gap-4">
                <a href="{{ route('comments.index') }}" 
                   class="px-6 py-3 border-2 border-[var(--primary-pink)] text-[var(--primary-pink)] font-medium hover:bg-[#fff5f9] transition-colors">
                    ← Все комментарии
                </a>
                
                @auth
                    @if(auth()->id() == $comment->user_id)
                    <a href="{{ route('comments.edit', $comment) }}" 
                       class="px-6 py-3 bg-blue-600 text-white font-medium hover:bg-blue-700 transition-colors">
                        ✏️ Редактировать
                    </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection