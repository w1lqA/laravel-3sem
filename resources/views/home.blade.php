@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Герой-секция -->
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <h1 class="text-4xl font-bold mb-4">
            Добро пожаловать в <span class="text-[var(--primary-pink)]">Laravel Blog</span>
        </h1>
        <p class="text-lg text-[var(--text-light)] mb-6 max-w-3xl">
            Это учебный проект, созданный в рамках изучения Laravel. Здесь вы найдёте примеры работы с маршрутизацией, шаблонизатором Blade и динамическими данными.
        </p>
        
        <div class="flex gap-4 mt-8">
            <a href="/about" class="px-6 py-3 bg-[var(--primary-pink)] text-white font-medium hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
                Узнать больше
            </a>
            <a href="/contacts" class="px-6 py-3 border-2 border-[var(--primary-pink)] text-[var(--primary-pink)] font-medium hover:bg-[#fff5f9] transition-colors">
                Связаться с нами
            </a>
        </div>
    </div>

    <!-- Карточки предстоящих разделов -->
    <div class="grid md:grid-cols-2 gap-6 mb-12">
        <div class="bg-white border-2 border-(--border-color) p-6 shadow-[var(--shadow-light)] hover:shadow-[var(--shadow-medium)] transition-shadow">
            <div class="text-[var(--primary-pink)] text-2xl mb-3 font-bold">→</div>
            <h3 class="text-xl font-bold mb-2">Новости</h3>
            <p class="text-[var(--text-light)] mb-4">В будущем здесь будет выводиться список новостей с пагинацией и комментариями.</p>
        </div>
        
        <div class="bg-white border-2 border-[var(--border-color)] p-6 shadow-[var(--shadow-light)] hover:shadow-[var(--shadow-medium)] transition-shadow">
            <div class="text-[var(--primary-pink)] text-2xl mb-3 font-bold">→</div>
            <h3 class="text-xl font-bold mb-2">Статьи</h3>
            <p class="text-[var(--text-light)] mb-4">Раздел для обучающих материалов по Laravel и веб-разработке.</p>
        </div>
    </div>
</div>
@endsection