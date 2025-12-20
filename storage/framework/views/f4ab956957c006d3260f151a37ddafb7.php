

<?php $__env->startSection('title', 'Редактировать: ' . $article->title); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <h1 class="text-3xl font-bold mb-6 text-[var(--text-dark)]">Редактировать статью</h1>
        
        <?php if($errors->any()): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700">
                <ul class="list-disc pl-4">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form action="<?php echo e(route('articles.update', $article->slug)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <!-- Заголовок -->
            <div class="mb-6">
                <label for="title" class="block text-[var(--text-dark)] font-medium mb-2">
                    Заголовок <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title"
                       name="title" 
                       value="<?php echo e(old('title', $article->title)); ?>"
                       class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                       required>
            </div>
            
            <!-- Краткое описание -->
            <div class="mb-6">
                <label for="short_desc" class="block text-[var(--text-dark)] font-medium mb-2">
                    Краткое описание
                </label>
                <textarea 
                    id="short_desc"
                    name="short_desc" 
                    rows="2"
                    class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"><?php echo e(old('short_desc', $article->short_desc)); ?></textarea>
            </div>
            
            <!-- Содержание -->
            <div class="mb-6">
                <label for="content" class="block text-[var(--text-dark)] font-medium mb-2">
                    Содержание <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="content"
                    name="content" 
                    rows="10"
                    class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                    required><?php echo e(old('content', $article->content)); ?></textarea>
            </div>
            
            <!-- Изображения -->
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <!-- Текущее превью -->
                <div>
                    <label class="block text-[var(--text-dark)] font-medium mb-2">
                        Текущее превью
                    </label>
                    <?php if($article->preview_image): ?>
                        <div class="mb-3">
                            <img src="<?php echo e(Storage::url($article->preview_image)); ?>" 
                                 alt="Превью" 
                                 class="w-full h-32 object-cover border border-gray-300">
                        </div>
                    <?php else: ?>
                        <p class="text-[var(--text-light)] italic">Нет изображения</p>
                    <?php endif; ?>
                    <label for="preview_image" class="block text-sm text-[var(--text-dark)] mb-2">
                        Заменить изображение:
                    </label>
                    <input type="file" 
                           id="preview_image"
                           name="preview_image" 
                           class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                           accept="image/*">
                </div>
                
                <!-- Текущее полное изображение -->
                <div>
                    <label class="block text-[var(--text-dark)] font-medium mb-2">
                        Текущее полное изображение
                    </label>
                    <?php if($article->full_image): ?>
                        <div class="mb-3">
                            <img src="<?php echo e(Storage::url($article->full_image)); ?>" 
                                 alt="Полное" 
                                 class="w-full h-32 object-cover border border-gray-300">
                        </div>
                    <?php else: ?>
                        <p class="text-[var(--text-light)] italic">Нет изображения</p>
                    <?php endif; ?>
                    <label for="full_image" class="block text-sm text-[var(--text-dark)] mb-2">
                        Заменить изображение:
                    </label>
                    <input type="file" 
                           id="full_image"
                           name="full_image" 
                           class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                           accept="image/*">
                </div>
            </div>
            
            <!-- Статус публикации -->
            <div class="mb-8">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="is_published" 
                           value="1"
                           <?php echo e(old('is_published', $article->is_published) ? 'checked' : ''); ?>

                           class="mr-2 h-5 w-5 text-[var(--primary-pink)]">
                    <span class="text-[var(--text-dark)]">Опубликована</span>
                </label>
            </div>
            
            <!-- Кнопки -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="px-6 py-3 bg-[var(--primary-pink)] text-white font-bold hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
                    Обновить статью
                </button>
                <a href="<?php echo e(route('articles.show', $article->slug)); ?>" 
                   class="px-6 py-3 border-2 border-[var(--primary-pink)] text-[var(--primary-pink)] font-medium hover:bg-[#fff5f9] transition-colors">
                    Отмена
                </a>
            </div>
        </form>
        
        <!-- Форма удаления -->
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
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/articles/edit.blade.php ENDPATH**/ ?>