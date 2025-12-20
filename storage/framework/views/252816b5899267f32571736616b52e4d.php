<div class="mt-12 pt-8 border-t border-gray-200">
    <h3 class="text-2xl font-bold mb-6 text-gray-800">Комментарии (<?php echo e($article->comments()->approved()->count()); ?>)</h3>
    
    <!-- Список комментариев -->
    <?php $__empty_1 = true; $__currentLoopData = $article->comments()->approved()->latest()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="mb-6 p-4 border border-gray-100 rounded-lg bg-gray-50">
        <div class="flex justify-between items-start mb-2">
            <div class="font-medium text-gray-700">
                <?php echo e($comment->user ? $comment->user->name : 'Аноним'); ?>

            </div>
            <div class="text-sm text-gray-500">
                <?php echo e($comment->created_at->format('d.m.Y H:i')); ?>

            </div>
        </div>
        <p class="text-gray-800 whitespace-pre-line"><?php echo e($comment->content); ?></p>
        
        <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->id() == $comment->user_id): ?>
            <div class="mt-3 pt-3 border-t border-gray-200">
                <a href="<?php echo e(route('comments.edit', $comment)); ?>" class="text-sm text-blue-600 hover:text-blue-800 mr-4">Редактировать</a>
                <form action="<?php echo e(route('comments.destroy', $comment)); ?>" method="POST" class="inline" onsubmit="return confirm('Удалить?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800">Удалить</button>
                </form>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="text-gray-600">Комментариев пока нет. Будьте первым!</p>
    <?php endif; ?>
    
    <!-- Форма добавления комментария -->
    <?php if(auth()->guard()->check()): ?>
    <div class="mt-8 p-6 border-2 border-gray-200 rounded-lg">
        <h4 class="text-lg font-bold mb-4 text-gray-800">Добавить комментарий</h4>
        
        <form action="<?php echo e(route('comments.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="article_id" value="<?php echo e($article->id); ?>">
            
            <div class="mb-4">
                <textarea name="content" 
                          rows="4" 
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:border-pink-500 focus:outline-none"
                          placeholder="Ваш комментарий..."
                          required></textarea>
                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <button type="submit" 
                    class="px-6 py-2 bg-pink-600 text-white font-medium hover:bg-pink-700 rounded transition-colors">
                Отправить комментарий
            </button>
        </form>
    </div>
    <?php else: ?>
    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded">
        <p class="text-blue-800">
            Чтобы оставить комментарий, 
            <a href="<?php echo e(route('auth.login')); ?>" class="font-medium text-pink-600 hover:text-pink-800">войдите</a> или 
            <a href="<?php echo e(route('auth.signin')); ?>" class="font-medium text-pink-600 hover:text-pink-800">зарегистрируйтесь</a>.
        </p>
    </div>
    <?php endif; ?>
</div><?php /**PATH /var/www/html/resources/views/articles/_comments.blade.php ENDPATH**/ ?>