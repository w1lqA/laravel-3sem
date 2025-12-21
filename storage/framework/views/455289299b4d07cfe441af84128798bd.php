

<?php $__env->startSection('title', 'Создать статью'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <h1 class="text-3xl font-bold mb-6 text-[var(--text-dark)]">Создать новую статью</h1>
        
        <?php if($errors->any()): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700">
                <ul class="list-disc pl-4">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form action="<?php echo e(route('articles.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <div class="mb-6">
                <label for="title" class="block text-[var(--text-dark)] font-medium mb-2">
                    Заголовок <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title"
                       name="title" 
                       value="<?php echo e(old('title')); ?>"
                       class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                       placeholder="Введите заголовок статьи"
                       required>
            </div>
            
            <div class="mb-6">
                <label for="short_desc" class="block text-[var(--text-dark)] font-medium mb-2">
                    Краткое описание
                </label>
                <textarea 
                    id="short_desc"
                    name="short_desc" 
                    rows="2"
                    class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                    placeholder="Краткое описание статьи (максимум 300 символов)"><?php echo e(old('short_desc')); ?></textarea>
            </div>
            
            <div class="mb-6">
                <label for="content" class="block text-[var(--text-dark)] font-medium mb-2">
                    Содержание <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="content"
                    name="content" 
                    rows="10"
                    class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                    placeholder="Текст статьи..."
                    required><?php echo e(old('content')); ?></textarea>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="preview_image" class="block text-[var(--text-dark)] font-medium mb-2">
                        Превью изображение
                    </label>
                    <input type="file" 
                           id="preview_image"
                           name="preview_image" 
                           class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                           accept="image/*">
                    <p class="text-sm text-[var(--text-light)] mt-2">JPG, PNG, до 2MB</p>
                </div>
                
                <div>
                    <label for="full_image" class="block text-[var(--text-dark)] font-medium mb-2">
                        Полное изображение
                    </label>
                    <input type="file" 
                           id="full_image"
                           name="full_image" 
                           class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                           accept="image/*">
                    <p class="text-sm text-[var(--text-light)] mt-2">JPG, PNG, до 5MB</p>
                </div>
            </div>
            <div class="flex gap-4">
                <button type="submit" 
                        class="px-6 py-3 bg-[var(--primary-pink)] text-white font-bold hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
                    Создать статью
                </button>
                <a href="<?php echo e(route('articles.index')); ?>" 
                   class="px-6 py-3 border-2 border-[var(--primary-pink)] text-[var(--primary-pink)] font-medium hover:bg-[#fff5f9] transition-colors">
                    Отмена
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/articles/create.blade.php ENDPATH**/ ?>