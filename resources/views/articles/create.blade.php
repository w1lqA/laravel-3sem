@extends('layouts.app')

@section('title', 'Создать статью')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <h1 class="text-3xl font-bold mb-6 text-[var(--text-dark)]">Создать новую статью</h1>
        
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label for="title" class="block text-[var(--text-dark)] font-medium mb-2">
                    Заголовок <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title"
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                       placeholder="Введите заголовок статьи"
                       required>
            </div>
            
            <div class="mb-6">
                <label for="short_desc" class="block text-[var(--text-dark)] font-medium mb-2">
                    Краткое описание
                </label>
                <textarea 
                    id="short_desc"
                    name="short_desc" 
                    rows="2"
                    class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                    placeholder="Краткое описание статьи (максимум 300 символов)">{{ old('short_desc') }}</textarea>
            </div>
            
            <div class="mb-6">
                <label for="content" class="block text-[var(--text-dark)] font-medium mb-2">
                    Содержание <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="content"
                    name="content" 
                    rows="10"
                    class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                    placeholder="Текст статьи..."
                    required>{{ old('content') }}</textarea>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="preview_image" class="block text-[var(--text-dark)] font-medium mb-2">
                        Превью изображение
                    </label>
                    <input type="file" 
                           id="preview_image"
                           name="preview_image" 
                           class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                           accept="image/*">
                    <p class="text-sm text-[var(--text-light)] mt-2">JPG, PNG, до 2MB</p>
                </div>
                
                <div>
                    <label for="full_image" class="block text-[var(--text-dark)] font-medium mb-2">
                        Полное изображение
                    </label>
                    <input type="file" 
                           id="full_image"
                           name="full_image" 
                           class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                           accept="image/*">
                    <p class="text-sm text-[var(--text-light)] mt-2">JPG, PNG, до 5MB</p>
                </div>
            </div>
            <div class="flex gap-4">
                <button type="submit" 
                        class="px-6 py-3 bg-[var(--primary-pink)] text-white font-bold hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
                    Создать статью
                </button>
                <a href="{{ route('articles.index') }}" 
                   class="px-6 py-3 border-2 border-[var(--primary-pink)] text-[var(--primary-pink)] font-medium hover:bg-[#fff5f9] transition-colors">
                    Отмена
                </a>
            </div>
        </form>
    </div>
</div>
@endsection