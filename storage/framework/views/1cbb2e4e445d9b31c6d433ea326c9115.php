

<?php $__env->startSection('title', 'Комментарии'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2 text-gray-800">Модерация комментариев</h1>
        <p class="text-gray-600">
            Комментарии, ожидающие проверки: <?php echo e($comments->total()); ?>

        </p>
        <?php if($comments->isEmpty()): ?>
            <div class="mt-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded">
                ✅ Все комментарии проверены!
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-6 flex gap-4">
        <a href="<?php echo e(route('comments.index')); ?>" 
        class="px-4 py-2 bg-pink-600 text-white font-medium rounded hover:bg-pink-700
                <?php echo e(request()->has('filter') && request('filter') == 'pending' ? 'bg-pink-700' : ''); ?>">
            ⏳ На модерации
        </a>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny', \App\Models\Comment::class)): ?>
        <a href="<?php echo e(route('comments.index')); ?>?filter=all" 
        class="px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded hover:bg-gray-300
                <?php echo e(request('filter') == 'all' ? 'bg-gray-300' : ''); ?>">
            📋 Все комментарии
        </a>
        <?php endif; ?>
    </div>
    
    <?php if($comments->isEmpty()): ?>
        <div class="bg-white border-2 border-gray-200 p-8 text-center">
            <p class="text-gray-600">Комментарии не найдены</p>
        </div>
    <?php else: ?>
        <!-- Таблица комментариев -->
        <div class="bg-white border-2 border-gray-200 shadow-lg overflow-hidden mb-6">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статья</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Комментарий</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e($comment->id); ?>

                        </td>
                        <td class="px-6 py-4">
                            <a href="<?php echo e(route('articles.show', $comment->article->slug)); ?>" 
                               class="text-pink-600 hover:text-pink-800 text-sm font-medium">
                                <?php echo e(Str::limit($comment->article->title, 30)); ?>

                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <?php echo e(Str::limit($comment->content, 50)); ?>

                            </div>
                            <?php if($comment->user): ?>
                            <div class="text-xs text-gray-500">
                                Автор: <?php echo e($comment->user->name); ?>

                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full <?php echo e($comment->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                <?php echo e($comment->is_approved ? 'Одобрен' : 'На модерации'); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($comment->created_at->format('d.m.Y H:i')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('comments.show', $comment)); ?>" 
                                class="text-blue-600 hover:text-blue-900">Просмотр</a>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $comment)): ?>
                                    <?php if(!$comment->is_approved): ?>
                                    <form action="<?php echo e(route('comments.approve', $comment)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="text-green-600 hover:text-green-900">Одобрить</button>
                                    </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $comment)): ?>
                                <form action="<?php echo e(route('comments.destroy', $comment)); ?>" method="POST" 
                                    onsubmit="return confirm('Удалить комментарий?')" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900">Удалить</button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <!-- Пагинация -->
        <?php echo e($comments->links()); ?>

    <?php endif; ?>
    
    <!-- Ссылка на создание -->
    <div class="mt-8">
        <a href="<?php echo e(route('comments.create')); ?>" 
           class="px-6 py-3 bg-pink-600 text-white font-bold hover:bg-pink-700 transition-colors shadow-lg inline-flex items-center gap-2">
            ✍️ Добавить комментарий
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/comments/index.blade.php ENDPATH**/ ?>