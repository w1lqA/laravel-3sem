

<?php $__env->startSection('title', 'Редактировать комментарий'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <h1 class="text-3xl font-bold mb-6 text-[var(--text-dark)]">Редактировать комментарий</h1>
        
        <?php if($errors->any()): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700">
                <ul class="list-disc pl-4">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form action="<?php echo e(route('comments.update', $comment)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <!-- Информация о статье -->
            <div class="mb-6 p-4 bg-gray-50 rounded">
                <h3 class="font-bold mb-2 text-[var(--text-dark)]">К статье:</h3>
                <p class="text-[var(--text-dark)]">
                    <a href="<?php echo e(route('articles.show', $comment->article->slug)); ?>" 
                       class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)]">
                        <?php echo e($comment->article->title); ?>

                    </a>
                </p>
            </div>
            
            <!-- Комментарий -->
            <div class="mb-8">
                <label for="content" class="block text-[var(--text-dark)] font-medium mb-2">
                    Комментарий <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="content"
                    name="content" 
                    rows="6"
                    class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                    required><?php echo e(old('content', $comment->content)); ?></textarea>
            </div>
            
            <!-- Кнопки -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="px-6 py-3 bg-[var(--primary-pink)] text-white font-bold hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
                    Обновить комментарий
                </button>
                <a href="<?php echo e(route('articles.show', $comment->article->slug)); ?>" 
                   class="px-6 py-3 border-2 border-[var(--primary-pink)] text-[var(--primary-pink)] font-medium hover:bg-[#fff5f9] transition-colors">
                    Отмена
                </a>
            </div>
        </form>
        
        <!-- Форма удаления -->
        <?php if(auth()->id() == $comment->user_id): ?>
        <div class="mt-8 pt-8 border-t border-[var(--border-color)]">
            <form action="<?php echo e(route('comments.destroy', $comment)); ?>" method="POST" 
                  onsubmit="return confirm('Удалить комментарий?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" 
                        class="px-6 py-3 bg-red-600 text-white font-bold hover:bg-red-700 transition-colors">
                    🗑️ Удалить комментарий
                </button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/comments/edit.blade.php ENDPATH**/ ?>