@extends('layouts.app')

@section('title', 'О нас')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <h1 class="text-3xl font-bold mb-6 text-[var(--text-dark)] border-b-2 border-[var(--border-color)] pb-3">
            О нашем проекте
        </h1>
        
        <div class="space-y-6">
            <div class="flex items-start gap-4">
                <div class="text-[var(--primary-pink)] text-xl mt-1 font-bold">•</div>
                <div>
                    <h3 class="text-xl font-bold mb-2 text-[var(--primary-pink-dark)]">Цель создания</h3>
                    <p class="text-[var(--text-light)]">Этот сайт разработан в рамках выполнения лабораторных работ по курсу "Серверная веб-разработка". Основная цель — освоить фреймворк Laravel на практике.</p>
                </div>
            </div>
            
            <div class="flex items-start gap-4">
                <div class="text-[var(--primary-pink)] text-xl mt-1 font-bold">•</div>
                <div>
                    <h3 class="text-xl font-bold mb-2 text-[var(--primary-pink-dark)]">Используемые технологии</h3>
                    <ul class="list-none space-y-2 text-[var(--text-light)]">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[var(--primary-pink)]"></span> Laravel 12 — современный PHP-фреймворк</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[var(--primary-pink)]"></span> Tailwind CSS v4 — утилитарный CSS-фреймворк</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[var(--primary-pink)]"></span> MySQL — система управления базами данных</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[var(--primary-pink)]"></span> Docker — контейнеризация приложения</li>
                    </ul>
                </div>
            </div>
            
            <div class="flex items-start gap-4">
                <div class="text-[var(--primary-pink)] text-xl mt-1 font-bold">•</div>
                <div>
                    <h3 class="text-xl font-bold mb-2 text-[var(--primary-pink-dark)]">Планы по развитию</h3>
                    <p class="text-[var(--text-light)]">В рамках следующих лабораторных работ на сайте появятся: система аутентификации, CRUD для статей, комментарии, роли пользователей, рассылки и API.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection