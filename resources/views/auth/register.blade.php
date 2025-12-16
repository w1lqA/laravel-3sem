@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <h1 class="text-3xl font-bold mb-6 text-[var(--text-dark)] text-center">
            Регистрация
        </h1>
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('auth.register') }}" method="POST">
            @csrf
            
            <!-- Имя -->
            <div class="mb-6">
                <label for="name" class="block text-[var(--text-dark)] font-medium mb-2">
                    Имя <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name"
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                       placeholder="Ваше имя"
                       required>
            </div>
            
            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-[var(--text-dark)] font-medium mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       id="email"
                       name="email" 
                       value="{{ old('email') }}"
                       class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                       placeholder="example@mail.com"
                       required>
            </div>
            
            <!-- Пароль -->
            <div class="mb-6">
                <label for="password" class="block text-[var(--text-dark)] font-medium mb-2">
                    Пароль <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="password"
                       name="password" 
                       class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                       placeholder="Минимум 6 символов"
                       required>
            </div>
            
            <!-- Подтверждение пароля -->
            <div class="mb-8">
                <label for="password_confirmation" class="block text-[var(--text-dark)] font-medium mb-2">
                    Подтверждение пароля <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="password_confirmation"
                       name="password_confirmation" 
                       class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                       placeholder="Повторите пароль"
                       required>
            </div>
            
            <!-- Кнопка регистрации -->
            <div class="mb-6">
                <button type="submit" 
                        class="w-full px-6 py-3 bg-[var(--primary-pink)] text-white font-bold hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
                    Зарегистрироваться
                </button>
            </div>
            
            <!-- Ссылка на вход -->
            <div class="text-center">
                <p class="text-[var(--text-light)] mb-2">Уже есть аккаунт?</p>
                <a href="{{ route('auth.login') }}" 
                   class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)] font-medium">
                    Войти в систему
                </a>
            </div>
        </form>
    </div>
    
    <!-- Информация -->
    <div class="bg-gray-50 border border-gray-200 p-6 text-sm text-gray-600 rounded">
        <h3 class="font-bold mb-2">Лабораторная работа №6:</h3>
        <ul class="list-disc pl-4 space-y-1">
            <li>Реальная регистрация с сохранением в БД</li>
            <li>Хеширование паролей</li>
            <li>Автоматическая авторизация после регистрации</li>
            <li>Использование Laravel Sanctum для токенов</li>
            <li>Защита роутов с middleware('auth:sanctum')</li>
        </ul>
        
        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 text-blue-700 rounded">
            <strong>Тестовые данные:</strong><br>
            Модератор: moderator@example.com / password<br>
            Читатель: reader@example.com / password
        </div>
    </div>
</div>
@endsection