@extends('layouts.app')

@section('title', 'Добавить комментарий')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white border-2 border-gray-200 shadow-lg p-8 mb-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Добавить комментарий</h1>
        
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            
            <!-- Выбор статьи -->
            <div class="mb-6">
                <label for="article_id" class="block text-gray-700 font-medium mb-2">
                    Статья <span class="text-red-500">*</span>
                </label>
                <select id="article_id" 
                        name="article_id" 
                        class="w-full border-2 border-gray-300 px-4 py-3 focus:border-pink-500 focus:outline-none focus:shadow-sm transition-all"
                        required>
                    <option value="">Выберите статью...</option>
                    @foreach($articles as $article)
                        <option value="{{ $article->id }}" {{ old('article_id') == $article->id ? 'selected' : '' }}>
                            #{{ $article->id }} - {{ Str::limit($article->title, 50) }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Комментарий -->
            <div class="mb-8">
                <label for="content" class="block text-gray-700 font-medium mb-2">
                    Комментарий <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="content"
                    name="content" 
                    rows="6"
                    class="w-full border-2 border-gray-300 px-4 py-3 focus:border-pink-500 focus:outline-none focus:shadow-sm transition-all"
                    placeholder="Ваш комментарий..."
                    required>{{ old('content') }}</textarea>
                <p class="text-sm text-gray-500 mt-2">Минимум 5 символов, максимум 1000</p>
            </div>
            
            <!-- Кнопки -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="px-6 py-3 bg-pink-600 text-white font-bold hover:bg-pink-700 transition-colors shadow-md">
                    Отправить комментарий
                </button>
                <a href="{{ route('comments.index') }}" 
                   class="px-6 py-3 border-2 border-pink-600 text-pink-600 font-medium hover:bg-pink-50 transition-colors">
                    Отмена
                </a>
            </div>
        </form>
    </div>
</div>
@endsection