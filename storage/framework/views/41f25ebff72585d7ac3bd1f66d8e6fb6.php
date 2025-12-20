

<?php $__env->startSection('title', 'Главная'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto">
    <!-- Герой-секция -->
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <h1 class="text-4xl font-bold mb-4">
            Добро пожаловать в <span class="text-[var(--primary-pink)]">Laravel Blog</span>
        </h1>
        <p class="text-lg text-[var(--text-light)] mb-6 max-w-3xl">
            Это учебный проект, созданный в рамках изучения Laravel. Здесь вы найдёте примеры работы с маршрутизацией, шаблонизатором Blade и динамическими данными.
        </p>
        
        <div class="flex gap-4 mt-8">
            <a href="/about" class="px-6 py-3 bg-[var(--primary-pink)] text-white font-medium hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
                Узнать больше
            </a>
            <a href="/contacts" class="px-6 py-3 border-2 border-[var(--primary-pink)] text-[var(--primary-pink)] font-medium hover:bg-[#fff5f9] transition-colors">
                Связаться с нами
            </a>
        </div>
    </div>

    <!-- Статьи из JSON -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold mb-6 text-[var(--text-dark)] border-b-2 border-[var(--border-color)] pb-3">
            Последние статьи
        </h2>
        
        <?php if(empty($articles)): ?>
            <div class="bg-white border-2 border-[var(--border-color)] p-8 text-center">
                <p class="text-[var(--text-light)]">Статьи не найдены</p>
            </div>
        <?php else: ?>
            <div class="grid md:grid-cols-2 gap-6">
                <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-light)] hover:shadow-[var(--shadow-medium)] transition-shadow overflow-hidden">
                    <!-- Изображение-превью с ссылкой -->
                    <?php if(isset($article['preview_image'])): ?>
                    <a href="<?php echo e(route('gallery', $article['preview_image'])); ?>">
                        <img src="<?php echo e(asset('data/' . $article['preview_image'])); ?>" 
                             alt="<?php echo e($article['name'] ?? 'Изображение статьи'); ?>"
                             class="w-full h-48 object-cover hover:opacity-90 transition-opacity">
                    </a>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <!-- Дата -->
                        <?php if(isset($article['date'])): ?>
                        <div class="text-sm text-[var(--primary-pink)] font-medium mb-2">
                            📅 <?php echo e($article['date']); ?>

                        </div>
                        <?php endif; ?>
                        
                        <!-- Заголовок -->
                        <h3 class="text-xl font-bold mb-3 text-[var(--text-dark)]">
                            <?php echo e($article['name'] ?? 'Без названия'); ?>

                        </h3>
                        
                        <!-- Краткое описание -->
                        <?php if(isset($article['shortDesc'])): ?>
                        <p class="text-[var(--text-light)] mb-4">
                            <?php echo e($article['shortDesc']); ?>

                        </p>
                        <?php endif; ?>
                        
                        <!-- Полное описание -->
                        <?php if(isset($article['desc'])): ?>
                        <div class="mb-4">
                            <p class="text-[var(--text-light)] text-sm line-clamp-3">
                                <?php echo e(Str::limit($article['desc'], 150)); ?>

                            </p>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Ссылка на полное изображение -->
                        <?php if(isset($article['full_image'])): ?>
                        <div class="mt-4 pt-4 border-t border-[var(--border-color)]">
                            <a href="<?php echo e(route('gallery', $article['full_image'])); ?>" 
                            class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)] font-medium inline-flex items-center gap-2">
                                <span>Посмотреть полное изображение</span>
                                <span>→</span>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/home.blade.php ENDPATH**/ ?>