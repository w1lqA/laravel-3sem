

<?php $__env->startSection('title', 'Комментарий #' . $comment->id); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white border-2 border-gray-200 shadow-lg p-8 mb-8">
        <!-- Хлебные крошки -->
        <div class="mb-6">
            <nav class="flex items-center gap-2 text-sm">
                <a href="<?php echo e(route('home')); ?>" class="text-pink-600 hover:text-pink-800">Главная</a>
                <span class="text-gray-400">/</span>
                <a href="<?php echo e(route('comments.index')); ?>" class="text-pink-600 hover:text-pink-800">Комментарии</a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-600">Просмотр #<?php echo e($comment->id); ?></span>
            </nav>
        </div>
        
        <h1 class="text-3xl font-bold mb-6 text-gray-800">
            Комментарий #<?php echo e($comment->id); ?>

        </h1>
        
        <!-- Информация о комментарии -->
        <div class="space-y-6 mb-8">
            <div class="border-2 border-gray-100 p-6">
                <h3 class="text-lg font-bold mb-3 text-gray-700">Содержание:</h3>
                <p class="text-gray-800 whitespace-pre-line"><?php echo e($comment->content); ?></p>
            </div>
            
            <!-- Мета-информация -->
            <div class="grid md:grid-cols-2 gap-4">
                <div class="border border-gray-200 p-4">
                    <div class="text-sm text-gray-500 mb-1">Статус:</div>
                    <div class="font-medium <?php echo e($comment->is_approved ? 'text-green-600' : 'text-yellow-600'); ?>">
                        <?php echo e($comment->is_approved ? '✅ Одобрен' : '⏳ На модерации'); ?>

                    </div>
                </div>
                
                <div class="border border-gray-200 p-4">
                    <div class="text-sm text-gray-500 mb-1">Дата создания:</div>
                    <div class="font-medium"><?php echo e($comment->created_at->format('d.m.Y H:i:s')); ?></div>
                </div>
                
                <div class="border border-gray-200 p-4">
                    <div class="text-sm text-gray-500 mb-1">ID статьи:</div>
                    <div class="font-medium">
                        <a href="<?php echo e(route('articles.show', $comment->article->slug)); ?>" 
                           class="text-pink-600 hover:text-pink-800">
                            #<?php echo e($comment->article_id); ?> - <?php echo e(Str::limit($comment->article->title, 30)); ?>

                        </a>
                    </div>
                </div>
                
                <div class="border border-gray-200 p-4">
                    <div class="text-sm text-gray-500 mb-1">Автор:</div>
                    <div class="font-medium">
                        <?php echo e($comment->user ? $comment->user->name : 'Аноним'); ?>

                    </div>
                </div>
            </div>
        </div>
        
        <!-- Действия -->
        <div class="border-t-2 border-gray-100 pt-6">
            <div class="flex gap-4">
                <a href="<?php echo e(route('comments.index')); ?>" 
                   class="px-6 py-3 border-2 border-pink-600 text-pink-600 font-medium hover:bg-pink-50 transition-colors">
                    ← Все комментарии
                </a>
                
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->id() == $comment->user_id): ?>
                    <a href="<?php echo e(route('comments.edit', $comment)); ?>" 
                       class="px-6 py-3 bg-blue-600 text-white font-medium hover:bg-blue-700 transition-colors">
                        ✏️ Редактировать
                    </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/comments/show.blade.php ENDPATH**/ ?>