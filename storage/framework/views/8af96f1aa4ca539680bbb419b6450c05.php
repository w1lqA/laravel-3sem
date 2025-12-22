<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Laravel Blog'); ?></title>
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <style>
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
        
        * {
            border-radius: 0 !important;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <header class="bg-white border-b-2 border-[var(--border-color)] shadow-[var(--shadow-light)]">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="/" class="text-2xl font-bold text-[var(--primary-pink)] tracking-tight hover:text-[var(--primary-pink-dark)] transition-colors">
                    Laravel<span class="text-[var(--text-dark)]">Blog</span>
                </a>
                
                <div class="flex gap-6 items-center">
                    <a href="/" 
                       class="px-3 py-2 font-medium text-[var(--text-dark)] hover:text-[var(--primary-pink)] hover:bg-[#fff5f9] transition-colors relative
                       <?php if(request()->is('/')): ?> text-[var(--primary-pink)] after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[var(--primary-pink)] <?php endif; ?>">
                        Главная
                    </a>
                    <a href="/about" 
                       class="px-3 py-2 font-medium text-[var(--text-dark)] hover:text-[var(--primary-pink)] hover:bg-[#fff5f9] transition-colors relative
                       <?php if(request()->is('about')): ?> text-[var(--primary-pink)] after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[var(--primary-pink)] <?php endif; ?>">
                        О нас
                    </a>
                    <a href="/contacts" 
                       class="px-3 py-2 font-medium text-[var(--text-dark)] hover:text-[var(--primary-pink)] hover:bg-[#fff5f9] transition-colors relative
                       <?php if(request()->is('contacts')): ?> text-[var(--primary-pink)] after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[var(--primary-pink)] <?php endif; ?>">
                        Контакты
                    </a>
                    <a href="<?php echo e(route('articles.index')); ?>" 
                    class="px-3 py-2 font-medium text-[var(--text-dark)] hover:text-[var(--primary-pink)] hover:bg-[#fff5f9] transition-colors relative
                    <?php if(request()->is('articles*')): ?> text-[var(--primary-pink)] after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[var(--primary-pink)] <?php endif; ?>">
                        Статьи
                    </a>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->isModerator()): ?>
                        <a href="<?php echo e(route('articles.create')); ?>" 
                        class="px-3 py-2 font-medium text-[var(--text-dark)] hover:text-[var(--primary-pink)] hover:bg-[#fff5f9] transition-colors relative
                        <?php if(request()->is('articles/create')): ?> text-[var(--primary-pink)] after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[var(--primary-pink)] <?php endif; ?>">
                            Создать статью
                        </a>

                        <!-- Страница модерации комментариев -->
                        <a href="<?php echo e(route('comments.index')); ?>" 
                        class="px-3 py-2 font-medium text-[var(--text-dark)] hover:text-[var(--primary-pink)] hover:bg-[#fff5f9] transition-colors relative
                        <?php if(request()->is('comments*')): ?> text-[var(--primary-pink)] after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[var(--primary-pink)] <?php endif; ?>">
                            Модерация (<?php echo e(\App\Models\Comment::where('is_approved', false)->count()); ?>)
                        </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                
                <div class="flex items-center gap-4">
                    <?php if(auth()->guard()->check()): ?>
                        <span class="text-[var(--text-dark)] font-medium">
                            <?php echo e(Auth::user()->name); ?>

                        </span>
                        <form action="<?php echo e(route('auth.logout')); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" 
                                    class="px-4 py-2 text-sm bg-gray-100 text-gray-700 hover:bg-gray-200 hover:text-[var(--primary-pink)] transition-colors font-medium">
                                Выйти
                            </button>
                        </form>
                        <?php if(!auth()->user()->isModerator()): ?>
                        <div class="relative">
                            <button id="notificationsDropdown" 
                                    class="px-3 py-2 font-medium text-[var(--text-dark)] hover:text-[var(--primary-pink)] hover:bg-[#fff5f9] transition-colors relative">
                                🔔 Уведомления 
                                <?php
                                    $unreadCount = auth()->user()->unreadNotifications()->count();
                                ?>
                                <?php if($unreadCount > 0): ?>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    <?php echo e($unreadCount); ?>

                                </span>
                                <?php endif; ?>
                            </button>
                            
                            <div id="notificationsMenu" 
                                class="hidden absolute right-0 mt-2 w-64 bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] z-50">
                                <div class="p-3 border-b border-[var(--border-color)]">
                                    <div class="font-bold text-[var(--text-dark)]">Уведомления</div>
                                    <div class="text-xs text-[var(--text-light)]">Новые статьи</div>
                                </div>
                                
                                <div class="max-h-64 overflow-y-auto">
                                    <?php $__empty_1 = true; $__currentLoopData = auth()->user()->notifications->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <a href="<?php echo e(route('notifications.read', $notification)); ?>"
                                    class="block p-3 border-b border-[var(--border-color)] hover:bg-[#fff5f9] transition-colors <?php echo e($notification->read_at ? 'opacity-75' : ''); ?>">
                                        <div class="font-medium text-sm text-[var(--text-dark)]">
                                            <?php echo e($notification->data['article_title'] ?? 'Новая статья'); ?>

                                        </div>
                                        <div class="text-xs text-[var(--text-light)] mt-1">
                                            <?php echo e($notification->created_at->diffForHumans()); ?>

                                            <?php if(!$notification->read_at): ?>
                                            <span class="ml-2 inline-block h-2 w-2 bg-red-500 rounded-full"></span>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="p-4 text-center text-[var(--text-light)] text-sm">
                                        Нет уведомлений
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if(auth()->user()->notifications->count() > 0): ?>
                                <div class="p-3 border-t border-[var(--border-color)]">
                                    <a href="<?php echo e(route('notifications.index')); ?>" 
                                    class="block text-center text-sm text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)]">
                                        Все уведомления
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <script>
                            document.getElementById('notificationsDropdown').addEventListener('click', function(e) {
                                e.stopPropagation();
                                document.getElementById('notificationsMenu').classList.toggle('hidden');
                            });
                            
                            document.addEventListener('click', function(e) {
                                if (!e.target.closest('#notificationsDropdown') && !e.target.closest('#notificationsMenu')) {
                                    document.getElementById('notificationsMenu').classList.add('hidden');
                                }
                            });
                        </script>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?php echo e(route('auth.login')); ?>" 
                           class="px-4 py-2 text-sm bg-gray-100 text-gray-700 hover:bg-gray-200 hover:text-[var(--primary-pink)] transition-colors font-medium
                           <?php if(request()->is('login')): ?> bg-[#fff5f9] text-[var(--primary-pink)] <?php endif; ?>">
                            Войти
                        </a>
                        <a href="<?php echo e(route('auth.signin')); ?>" 
                           class="px-4 py-2 text-sm bg-[var(--primary-pink)] text-white hover:bg-[var(--primary-pink-dark)] transition-colors font-medium
                           <?php if(request()->is('signin')): ?> bg-[var(--primary-pink-dark)] <?php endif; ?>">
                            Регистрация
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-1 container mx-auto px-4 py-8">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

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
</html><?php /**PATH /var/www/html/resources/views/layouts/app.blade.php ENDPATH**/ ?>