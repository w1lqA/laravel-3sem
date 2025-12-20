

<?php $__env->startSection('title', 'Добавить комментарий'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white border-2 border-gray-200 shadow-lg p-8 mb-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Добавить комментарий</h1>
        
        <?php if($errors->any()): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700">
                <ul class="list-disc pl-4">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form action="<?php echo e(route('comments.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <!-- Выбор статьи -->
            <div class="mb-6">
                <label for="article_id" class="block text-gray-700 font-medium mb-2">
                    Статья <span class="text-red-500">*</span>
                </label>
                <select id="article_id" 
                        name="article_id" 
                        class="w-full border-2 border-gray-300 px-4 py-3 focus:border-pink-500 focus:outline-none focus:shadow-sm transition-all"
                        required>
                    <option value="">Выберите статью...</option>
                    <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($article->id); ?>" <?php echo e(old('article_id') == $article->id ? 'selected' : ''); ?>>
                            #<?php echo e($article->id); ?> - <?php echo e(Str::limit($article->title, 50)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <!-- Комментарий -->
            <div class="mb-8">
                <label for="content" class="block text-gray-700 font-medium mb-2">
                    Комментарий <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="content"
                    name="content" 
                    rows="6"
                    class="w-full border-2 border-gray-300 px-4 py-3 focus:border-pink-500 focus:outline-none focus:shadow-sm transition-all"
                    placeholder="Ваш комментарий..."
                    required><?php echo e(old('content')); ?></textarea>
                <p class="text-sm text-gray-500 mt-2">Минимум 5 символов, максимум 1000</p>
            </div>
            
            <!-- Кнопки -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="px-6 py-3 bg-pink-600 text-white font-bold hover:bg-pink-700 transition-colors shadow-md">
                    Отправить комментарий
                </button>
                <a href="<?php echo e(route('comments.index')); ?>" 
                   class="px-6 py-3 border-2 border-pink-600 text-pink-600 font-medium hover:bg-pink-50 transition-colors">
                    Отмена
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/comments/create.blade.php ENDPATH**/ ?>