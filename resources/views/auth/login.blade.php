@extends('layouts.app')

@section('title', 'Вход в систему')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <h1 class="text-3xl font-bold mb-6 text-[var(--text-dark)] text-center">
            Вход в систему
        </h1>
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            
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
                       placeholder="Ваш пароль"
                       required>
            </div>
            
            <!-- Запомнить меня -->
            <div class="mb-6 flex items-center">
                <input type="checkbox" 
                       id="remember"
                       name="remember" 
                       class="mr-2 h-4 w-4 text-[var(--primary-pink)]">
                <label for="remember" class="text-[var(--text-dark)]">
                    Запомнить меня
                </label>
            </div>
            
            <!-- Кнопка входа -->
            <div class="mb-6">
                <button type="submit" 
                        class="w-full px-6 py-3 bg-[var(--primary-pink)] text-white font-bold hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
                    Войти
                </button>
            </div>
            
            <!-- Ссылки -->
            <div class="text-center space-y-2">
                <p class="text-[var(--text-light)]">
                    Нет аккаунта?
                    <a href="{{ route('auth.register') }}" 
                       class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)] font-medium">
                        Зарегистрироваться
                    </a>
                </p>
                <p>
                    <a href="{{ route('home') }}" 
                       class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)] font-medium">
                        ← Вернуться на главную
                    </a>
                </p>
            </div>
        </form>
    </div>
    
    <!-- Информация о Sanctum токене -->
    @auth
    <div class="bg-gray-50 border border-gray-200 p-6 text-sm text-gray-600 rounded">
        <h3 class="font-bold mb-2">Токен аутентификации (Sanctum):</h3>
        <div class="bg-gray-100 p-3 rounded overflow-auto">
            <code class="text-xs">{{ session('sanctum_token') ?? 'Токен не сгенерирован' }}</code>
        </div>
        <p class="mt-2 text-xs">Этот токен используется для API запросов через middleware('auth:sanctum')</p>
    </div>
    @endauth
</div>
@endsection