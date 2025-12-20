

<?php $__env->startSection('title', 'Галерея'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <!-- Хлебные крошки -->
        <div class="mb-6">
            <nav class="flex items-center gap-2 text-sm">
                <a href="<?php echo e(route('home')); ?>" class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)]">Главная</a>
                <span class="text-[var(--text-light)]">/</span>
                <span class="text-[var(--text-dark)]">Галерея</span>
                <span class="text-[var(--text-light)]">/</span>
                <span class="text-[var(--text-dark)]"><?php echo e($imageName); ?></span>
            </nav>
        </div>
        
        <h1 class="text-3xl font-bold mb-6 text-[var(--text-dark)]">
            Изображение: <span class="text-[var(--primary-pink)]"><?php echo e($imageName); ?></span>
        </h1>
        
        <!-- Полное изображение -->
        <div class="mb-8">
            <img src="<?php echo e(asset('data/' . $imageName)); ?>" 
                 alt="Полное изображение <?php echo e($imageName); ?>"
                 class="w-full max-h-[600px] object-contain border-2 border-[var(--border-color)] p-2">
        </div>
        
        <!-- Информация о файле -->
        <div class="border-t-2 border-[var(--border-color)] pt-6">
            <h2 class="text-xl font-bold mb-4 text-[var(--text-dark)]">Информация о файле</h2>
            
            <?php
                $filePath = public_path('data/' . $imageName);
                $fileExists = file_exists($filePath);
                $fileSize = $fileExists ? round(filesize($filePath) / 1024, 2) : 0;
                $fileExtension = pathinfo($imageName, PATHINFO_EXTENSION);
            ?>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div class="border border-[var(--border-color)] p-4">
                    <div class="text-sm text-[var(--text-light)] mb-1">Имя файла</div>
                    <div class="font-medium text-[var(--text-dark)]"><?php echo e($imageName); ?></div>
                </div>
                
                <div class="border border-[var(--border-color)] p-4">
                    <div class="text-sm text-[var(--text-light)] mb-1">Расширение</div>
                    <div class="font-medium text-[var(--text-dark)] uppercase"><?php echo e($fileExtension); ?></div>
                </div>
                
                <div class="border border-[var(--border-color)] p-4">
                    <div class="text-sm text-[var(--text-light)] mb-1">Размер</div>
                    <div class="font-medium text-[var(--text-dark)]"><?php echo e($fileSize); ?> KB</div>
                </div>
                
                <div class="border border-[var(--border-color)] p-4">
                    <div class="text-sm text-[var(--text-light)] mb-1">Статус</div>
                    <div class="font-medium <?php echo e($fileExists ? 'text-green-600' : 'text-red-600'); ?>">
                        <?php echo e($fileExists ? 'Файл найден' : 'Файл не найден'); ?>

                    </div>
                </div>
            </div>
        </div>
        
        <!-- Кнопка назад -->
        <div class="mt-8 pt-6 border-t-2 border-[var(--border-color)]">
            <a href="<?php echo e(route('home')); ?>" 
               class="px-6 py-3 bg-[var(--primary-pink)] text-white font-medium hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)] inline-flex items-center gap-2">
                ← Вернуться к статьям
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/gallery.blade.php ENDPATH**/ ?>