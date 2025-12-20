

<?php $__env->startSection('title', $article->title); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="max-w-4xl mx-auto mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded">
        ✅ <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="max-w-4xl mx-auto mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded">
        ❌ <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <nav class="flex items-center gap-2 text-sm">
            <a href="<?php echo e(route('home')); ?>" class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)]">Главная</a>
            <span class="text-[var(--text-light)]">/</span>
            <a href="<?php echo e(route('articles.index')); ?>" class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)]">Статьи</a>
            <span class="text-[var(--text-light)]">/</span>
            <span class="text-[var(--text-dark)] truncate max-w-xs"><?php echo e(Str::limit($article->title, 40)); ?></span>
        </nav>
    </div>
    
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] overflow-hidden">
        <div class="p-8 border-b-2 border-[var(--border-color)]">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold mb-2 text-[var(--text-dark)]"><?php echo e($article->title); ?></h1>
                    
                    <div class="flex flex-wrap items-center gap-4 text-sm text-[var(--text-light)]">
                        <div class="flex items-center gap-1">
                            <span>📅</span>
                            <span><?php echo e($article->created_at->format('d.m.Y H:i')); ?></span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span>👁️</span>
                            <span><?php echo e($article->views_count); ?> просмотров</span>
                        </div>
                        <?php if(!$article->is_published): ?>
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Черновик</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <a href="<?php echo e(route('articles.index')); ?>" 
                   class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)]">
                    ← Все статьи
                </a>
            </div>
            
            <?php if($article->short_desc): ?>
            <div class="bg-[#fff5f9] border-l-4 border-[var(--primary-pink)] p-4">
                <p class="text-[var(--text-dark)] italic"><?php echo e($article->short_desc); ?></p>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if($article->full_image): ?>
        <div class="p-8 border-b-2 border-[var(--border-color)]">
            <div class="max-w-2xl mx-auto">
                <img src="<?php echo e(asset('data/' . $article->full_image)); ?>" 
                     alt="<?php echo e($article->title); ?>"
                     class="w-full h-auto rounded shadow-lg">
                <p class="text-center text-sm text-[var(--text-light)] mt-2">Иллюстрация к статье</p>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="p-8">
            <div class="prose max-w-none text-[var(--text-dark)]">
                <?php echo nl2br(e($article->content)); ?>

            </div>
        </div>
        
        <div class="p-8 border-t-2 border-[var(--border-color)] bg-gray-50">
            <h3 class="font-bold mb-4 text-[var(--text-dark)]">Информация о статье:</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-[var(--text-light)]">ID статьи:</span>
                        <span class="font-medium"><?php echo e($article->id); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[var(--text-light)]">Slug:</span>
                        <span class="font-medium"><?php echo e($article->slug); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[var(--text-light)]">Статус:</span>
                        <span class="font-medium <?php echo e($article->is_published ? 'text-green-600' : 'text-red-600'); ?>">
                            <?php echo e($article->is_published ? 'Опубликована' : 'Черновик'); ?>

                        </span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-[var(--text-light)]">Дата создания:</span>
                        <span class="font-medium"><?php echo e($article->created_at->format('d.m.Y H:i:s')); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[var(--text-light)]">Дата обновления:</span>
                        <span class="font-medium"><?php echo e($article->updated_at->format('d.m.Y H:i:s')); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[var(--text-light)]">Просмотры:</span>
                        <span class="font-medium"><?php echo e($article->views_count); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-8 flex justify-between">
        <a href="<?php echo e(route('articles.index')); ?>" 
           class="px-6 py-3 border-2 border-[var(--primary-pink)] text-[var(--primary-pink)] font-medium hover:bg-[#fff5f9] transition-colors inline-flex items-center gap-2">
            ← Все статьи
        </a>
        <a href="<?php echo e(route('home')); ?>" 
           class="px-6 py-3 bg-[var(--primary-pink)] text-white font-medium hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
            На главную
        </a>
    </div>
</div>

<?php if(auth()->guard()->check()): ?>
    <?php if(auth()->user()->isModerator()): ?>
    <!-- Кнопки управления статьей - ТОЛЬКО ДЛЯ МОДЕРАТОРОВ -->
    <div class="mt-8 bg-white border-2 border-[var(--border-color)] p-6">
        <h3 class="font-bold mb-4 text-[var(--text-dark)]">Управление статьей:</h3>
        <div class="flex gap-4">
            <a href="<?php echo e(route('articles.edit', $article->slug)); ?>" 
               class="px-6 py-3 bg-blue-600 text-white font-bold hover:bg-blue-700 transition-colors shadow-[var(--shadow-light)]">
                ✏️ Редактировать
            </a>
            <form action="<?php echo e(route('articles.destroy', $article->slug)); ?>" method="POST" 
                  onsubmit="return confirm('Вы уверены?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" 
                        class="px-6 py-3 bg-red-600 text-white font-bold hover:bg-red-700 transition-colors shadow-[var(--shadow-light)]">
                    🗑️ Удалить
                </button>
            </form>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>

</div>
<!-- Подключение комментариев -->
<?php echo $__env->make('articles._comments', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/articles/show.blade.php ENDPATH**/ ?>