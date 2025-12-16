@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <h1 class="text-3xl font-bold mb-2 text-[var(--text-dark)]">Контакты</h1>
        <p class="text-[var(--text-light)] mb-8 border-b-2 border-[var(--border-color)] pb-6">
            Страница с динамическими данными. Информация загружается из массива, переданного через контроллер.
        </p>
        
        <!-- Контактные карточки -->
        <div class="grid md:grid-cols-2 gap-6 mb-10">
            @foreach($contacts as $key => $value)
            <div class="border-2 border-[var(--border-color)] p-5 hover:border-[var(--primary-pink)] hover:shadow-[var(--shadow-light)] transition-all group">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-[#fff5f9] flex items-center justify-center text-[var(--primary-pink)] font-bold group-hover:bg-[var(--primary-pink)] group-hover:text-white transition-colors">
                        {{ strtoupper(substr($key, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-[var(--text-dark)] mb-1 capitalize">{{ $key }}</h3>
                        <p class="text-[var(--text-light)] break-words">{{ $value }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Форма для связи (статичная, не функциональная) -->
        <div class="border-t-2 border-[var(--border-color)] pt-8">
            <h2 class="text-2xl font-bold mb-6 text-[var(--text-dark)]">Напишите нам</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[var(--text-dark)] font-medium mb-2">Имя</label>
                    <input type="text" 
                           class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all" 
                           placeholder="Ваше имя">
                </div>
                
                <div>
                    <label class="block text-[var(--text-dark)] font-medium mb-2">Email</label>
                    <input type="email" 
                           class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all" 
                           placeholder="example@mail.com">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-[var(--text-dark)] font-medium mb-2">Сообщение</label>
                    <textarea 
                        class="w-full border-2 border-[var(--border-color)] px-4 py-3 h-32 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all" 
                        placeholder="Ваше сообщение..."></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <button class="px-8 py-3 bg-[var(--primary-pink)] text-white font-bold hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
                        Отправить сообщение
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection