<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel Blog')</title>
    
    <!-- Используем предустановленный Tailwind v4 через Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Дополнительные кастомные стили в бело-розовой палитре */
        :root {
            --primary-pink: #ff69b4;
            --primary-pink-dark: #db4d94;
            --light-bg: #fff5f9;
            --text-dark: #333333;
            --text-light: #666666;
            --border-color: #ffd1e0;
            --shadow-light: 0 2px 8px rgba(255, 105, 180, 0.1);
            --shadow-medium: 0 4px 12px rgba(255, 105, 180, 0.15);
        }
        
        body {
            background-color: var(--light-bg);
            color: var(--text-dark);
            font-family: system-ui, -apple-system, sans-serif;
        }
        
        /* Убираем все закругления глобально */
        * {
            border-radius: 0 !important;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Навигация с острыми углами -->
    <header class="bg-white border-b-2 border-[var(--border-color)] shadow-[var(--shadow-light)]">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="/" class="text-2xl font-bold text-[var(--primary-pink)] tracking-tight hover:text-[var(--primary-pink-dark)] transition-colors">
                    Laravel<span class="text-[var(--text-dark)]">Blog</span>
                </a>
                
                <div class="flex gap-6">
                    <a href="/" 
                       class="px-3 py-2 font-medium text-[var(--text-dark)] hover:text-[var(--primary-pink)] hover:bg-[#fff5f9] transition-colors relative
                       @if(request()->is('/')) text-[var(--primary-pink)] after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[var(--primary-pink)] @endif">
                        Главная
                    </a>
                    <a href="/about" 
                       class="px-3 py-2 font-medium text-[var(--text-dark)] hover:text-[var(--primary-pink)] hover:bg-[#fff5f9] transition-colors relative
                       @if(request()->is('about')) text-[var(--primary-pink)] after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[var(--primary-pink)] @endif">
                        О нас
                    </a>
                    <a href="/contacts" 
                       class="px-3 py-2 font-medium text-[var(--text-dark)] hover:text-[var(--primary-pink)] hover:bg-[#fff5f9] transition-colors relative
                       @if(request()->is('contacts')) text-[var(--primary-pink)] after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[var(--primary-pink)] @endif">
                        Контакты
                    </a>
                    <a href="/signin" 
                        class="px-3 py-2 font-medium text-[var(--text-dark)] hover:text-[var(--primary-pink)] hover:bg-[#fff5f9] transition-colors relative
                        @if(request()->is('signin')) text-[var(--primary-pink)] after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[var(--primary-pink)] @endif">
                        Регистрация
                    </a>
                    <a href="{{ route('articles.index') }}" 
                    class="px-3 py-2 font-medium text-[var(--text-dark)] hover:text-[var(--primary-pink)] hover:bg-[#fff5f9] transition-colors relative
                    @if(request()->is('articles*')) text-[var(--primary-pink)] after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[var(--primary-pink)] @endif">
                        Статьи
                    </a>
                    @auth
                    <a href="{{ route('comments.index') }}" 
                    class="px-3 py-2 font-medium text-[var(--text-dark)] hover:text-[var(--primary-pink)] hover:bg-[#fff5f9] transition-colors relative
                    @if(request()->is('comments*')) text-[var(--primary-pink)] after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[var(--primary-pink)] @endif">
                        Комментарии
                    </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Основной контент -->
    <main class="flex-1 container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Футер -->
    <footer class="bg-white border-t-2 border-[var(--border-color)] py-6 mt-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <div class="text-lg font-bold text-[var(--primary-pink)]">Laravel Blog</div>
                    <div class="text-sm text-[var(--text-light)]">Лабораторные работы по серверной веб-разработке</div>
                </div>
                
                <div class="text-center md:text-right">
                    <div class="font-medium text-[var(--text-dark)] mb-1">Болохонцев Виктор Андреевич</div>
                    <div class="text-sm text-[var(--text-light)]">Группа 241-321 • Лабораторная работа №1</div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>