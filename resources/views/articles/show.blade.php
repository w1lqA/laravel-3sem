@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <nav class="flex items-center gap-2 text-sm">
            <a href="{{ route('home') }}" class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)]">Главная</a>
            <span class="text-[var(--text-light)]">/</span>
            <a href="{{ route('articles.index') }}" class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)]">Статьи</a>
            <span class="text-[var(--text-light)]">/</span>
            <span class="text-[var(--text-dark)] truncate max-w-xs">{{ Str::limit($article->title, 40) }}</span>
        </nav>
    </div>
    
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] overflow-hidden">
        <div class="p-8 border-b-2 border-[var(--border-color)]">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold mb-2 text-[var(--text-dark)]">{{ $article->title }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-4 text-sm text-[var(--text-light)]">
                        <div class="flex items-center gap-1">
                            <span>📅</span>
                            <span>{{ $article->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span>👁️</span>
                            <span>{{ $article->views_count }} просмотров</span>
                        </div>
                        @if(!$article->is_published)
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Черновик</span>
                        @endif
                    </div>
                </div>
                
                <a href="{{ route('articles.index') }}" 
                   class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)]">
                    ← Все статьи
                </a>
            </div>
            
            @if($article->short_desc)
            <div class="bg-[#fff5f9] border-l-4 border-[var(--primary-pink)] p-4">
                <p class="text-[var(--text-dark)] italic">{{ $article->short_desc }}</p>
            </div>
            @endif
        </div>
        
        @if($article->full_image)
        <div class="p-8 border-b-2 border-[var(--border-color)]">
            <div class="max-w-2xl mx-auto">
                <img src="{{ asset('data/' . $article->full_image) }}" 
                     alt="{{ $article->title }}"
                     class="w-full h-auto rounded shadow-lg">
                <p class="text-center text-sm text-[var(--text-light)] mt-2">Иллюстрация к статье</p>
            </div>
        </div>
        @endif
        
        <div class="p-8">
            <div class="prose max-w-none text-[var(--text-dark)]">
                {!! nl2br(e($article->content)) !!}
            </div>
        </div>
        
        <div class="p-8 border-t-2 border-[var(--border-color)] bg-gray-50">
            <h3 class="font-bold mb-4 text-[var(--text-dark)]">Информация о статье:</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-[var(--text-light)]">ID статьи:</span>
                        <span class="font-medium">{{ $article->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[var(--text-light)]">Slug:</span>
                        <span class="font-medium">{{ $article->slug }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[var(--text-light)]">Статус:</span>
                        <span class="font-medium {{ $article->is_published ? 'text-green-600' : 'text-red-600' }}">
                            {{ $article->is_published ? 'Опубликована' : 'Черновик' }}
                        </span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-[var(--text-light)]">Дата создания:</span>
                        <span class="font-medium">{{ $article->created_at->format('d.m.Y H:i:s') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[var(--text-light)]">Дата обновления:</span>
                        <span class="font-medium">{{ $article->updated_at->format('d.m.Y H:i:s') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[var(--text-light)]">Просмотры:</span>
                        <span class="font-medium">{{ $article->views_count }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-8 flex justify-between">
        <a href="{{ route('articles.index') }}" 
           class="px-6 py-3 border-2 border-[var(--primary-pink)] text-[var(--primary-pink)] font-medium hover:bg-[#fff5f9] transition-colors inline-flex items-center gap-2">
            ← Все статьи
        </a>
        <a href="{{ route('home') }}" 
           class="px-6 py-3 bg-[var(--primary-pink)] text-white font-medium hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
            На главную
        </a>
    </div>
</div>
<!-- Кнопки управления статьей -->
<div class="mt-8 bg-white border-2 border-[var(--border-color)] p-6">
    <h3 class="font-bold mb-4 text-[var(--text-dark)]">Управление статьей:</h3>
    <div class="flex gap-4">
        <a href="{{ route('articles.edit', $article->slug) }}" 
           class="px-6 py-3 bg-blue-600 text-white font-bold hover:bg-blue-700 transition-colors shadow-[var(--shadow-light)]">
            ✏️ Редактировать
        </a>
        <form action="{{ route('articles.destroy', $article->slug) }}" method="POST" 
              onsubmit="return confirm('Вы уверены?')">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="px-6 py-3 bg-red-600 text-white font-bold hover:bg-red-700 transition-colors shadow-[var(--shadow-light)]">
                🗑️ Удалить
            </button>
        </form>
    </div>
</div>

<!-- Комментарии -->
<div class="mt-8 bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8">
    <h2 class="text-2xl font-bold mb-6 text-[var(--text-dark)]">Комментарии ({{ $article->approvedComments()->count() }})</h2>
    
    <!-- Список комментариев -->
    @if($article->approvedComments()->count() > 0)
        <div class="space-y-6 mb-8">
            @foreach($article->approvedComments()->get() as $comment)
            <div class="border border-[var(--border-color)] p-4 rounded">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[var(--primary-pink)] text-white rounded-full flex items-center justify-center font-bold">
                            {{ Str::upper(substr($comment->user?->name ?: 'Аноним', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-medium text-[var(--text-dark)]">
                                {{ $comment->user?->name ?: 'Анонимный пользователь' }}
                            </div>
                            <div class="text-sm text-[var(--text-light)]">
                                {{ $comment->created_at->format('d.m.Y H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    @auth
                        @if(auth()->id() == $comment->user_id)
                        <div class="flex gap-2">
                            <a href="{{ route('comments.edit', $comment) }}" 
                               class="text-sm text-blue-600 hover:text-blue-800">Изменить</a>
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" 
                                  onsubmit="return confirm('Удалить комментарий?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800">Удалить</button>
                            </form>
                        </div>
                        @endif
                    @endauth
                </div>
                
                <p class="text-[var(--text-dark)]">{{ $comment->content }}</p>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8 border-2 border-dashed border-[var(--border-color)] rounded mb-8">
            <p class="text-[var(--text-light)]">Пока нет комментариев. Будьте первым!</p>
        </div>
    @endif
    
    <!-- Форма добавления комментария -->
    <div class="border-t-2 border-[var(--border-color)] pt-8">
        <h3 class="text-xl font-bold mb-4 text-[var(--text-dark)]">Добавить комментарий</h3>
        
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="article_id" value="{{ $article->id }}">
            
            <div class="mb-4">
                <textarea name="content" 
                        rows="4"
                        class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                        placeholder="Ваш комментарий..."
                        required></textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" 
                    class="px-6 py-3 bg-[var(--primary-pink)] text-white font-bold hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
                Отправить комментарий
            </button>
        </form>
    </div>
        <!-- <div class="text-center py-6 border-2 border-[var(--border-color)] rounded bg-gray-50">
            <p class="text-[var(--text-dark)] mb-3">Чтобы оставить комментарий, необходимо авторизоваться</p>
            <a href="{{ route('auth.signin') }}" 
               class="px-6 py-2 bg-[var(--primary-pink)] text-white font-medium hover:bg-[var(--primary-pink-dark)] transition-colors">
                Войти / Зарегистрироваться
            </a>
        </div> -->
</div>

@endsection