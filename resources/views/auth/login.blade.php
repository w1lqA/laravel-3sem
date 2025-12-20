@extends('layouts.app')

@section('title', 'Вход в систему')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <h1 class="text-3xl font-bold mb-6 text-[var(--text-dark)] text-center">
            Вход в систему
        </h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('auth.login') }}" method="POST">
            @csrf

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

            <div class="mb-8">
                <label for="password" class="block text-[var(--text-dark)] font-medium mb-2">
                    Пароль <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="password"
                       name="password" 
                       class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                       placeholder="Введите ваш пароль"
                       required>
            </div>

            <div class="mb-6">
                <button type="submit" 
                        class="w-full px-6 py-3 bg-[var(--primary-pink)] text-white font-bold hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
                    Войти
                </button>
            </div>

            <div class="text-center space-y-2">
                <a href="{{ route('auth.signin') }}" 
                   class="block text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)] font-medium">
                    Нет аккаунта? Зарегистрируйтесь
                </a>
                <a href="{{ route('home') }}" 
                   class="block text-gray-600 hover:text-gray-800 font-medium">
                    ← Вернуться на главную
                </a>
            </div>
        </form>
    </div>
</div>
@endsection