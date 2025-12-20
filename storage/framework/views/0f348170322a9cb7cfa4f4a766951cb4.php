

<?php $__env->startSection('title', 'Статьи'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2 text-[var(--text-dark)]">Статьи из базы данных</h1>
        <p class="text-[var(--text-light)]">
            Лабораторная работа №4: Работа с моделями, миграциями и фейковыми данными.
            Показано <?php echo e($articles->total()); ?> статей.
        </p>
    </div>

    <div class="bg-white border-2 border-[var(--border-color)] p-4 mb-6">
        <div class="flex flex-wrap gap-4 items-center">
            <span class="font-medium text-[var(--text-dark)]">Фильтры:</span>
            <a href="<?php echo e(route('articles.index')); ?>" 
               class="px-4 py-2 <?php echo e(request()->has('filter') ? 'bg-gray-100' : 'bg-[var(--primary-pink)] text-white'); ?> rounded">
                Все статьи
            </a>
            <a href="<?php echo e(route('articles.index', ['filter' => 'popular'])); ?>" 
               class="px-4 py-2 <?php echo e(request('filter') == 'popular' ? 'bg-[var(--primary-pink)] text-white' : 'bg-gray-100'); ?> rounded">
                Популярные
            </a>
        </div>
    </div>

    <?php if($articles->isEmpty()): ?>
        <div class="bg-white border-2 border-[var(--border-color)] p-8 text-center">
            <p class="text-[var(--text-light)]">Статьи не найдены</p>
            <a href="<?php echo e(route('home')); ?>" class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)] mt-4 inline-block">
                Вернуться на главную
            </a>
        </div>
    <?php else: ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-light)] hover:shadow-[var(--shadow-medium)] transition-shadow overflow-hidden flex flex-col h-full">
                <?php if($article->preview_image): ?>
                <div class="relative h-48 overflow-hidden">
                    <img src="<?php echo e(asset('data/' . $article->preview_image)); ?>" 
                         alt="<?php echo e($article->title); ?>"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    
                    <?php if(!$article->is_published): ?>
                    <div class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
                        Черновик
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <div class="p-5 flex-1 flex flex-col">
                    <div class="mb-3">
                        <h3 class="text-xl font-bold mb-1 text-[var(--text-dark)] line-clamp-2">
                            <a href="<?php echo e(route('articles.show', $article->slug)); ?>" 
                               class="hover:text-[var(--primary-pink)] transition-colors">
                                <?php echo e($article->title); ?>

                            </a>
                        </h3>
                        <div class="flex items-center justify-between text-sm text-[var(--text-light)]">
                            <span>📅 <?php echo e($article->created_at->format('d.m.Y')); ?></span>
                            <span>👁️ <?php echo e($article->views_count); ?> просмотров</span>
                        </div>
                    </div>
                    
                    <?php if($article->short_desc): ?>
                    <p class="text-[var(--text-light)] mb-4 text-sm flex-1">
                        <?php echo e(Str::limit($article->short_desc, 100)); ?>

                    </p>
                    <?php endif; ?>
                    
                    <div class="mt-auto pt-4 border-t border-[var(--border-color)]">
                        <a href="<?php echo e(route('articles.show', $article->slug)); ?>" 
                           class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)] font-medium inline-flex items-center gap-2">
                            <span>Читать статью</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <?php if($articles->hasPages()): ?>
        <div class="bg-white border-2 border-[var(--border-color)] p-6">
            <div class="flex justify-between items-center">
                <div class="text-sm text-[var(--text-light)]">
                    Показано с <?php echo e($articles->firstItem()); ?> по <?php echo e($articles->lastItem()); ?> из <?php echo e($articles->total()); ?> статей
                </div>
                <div>
                    <?php echo e($articles->links()); ?>

                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', $article)): ?>
<div class="mt-8 bg-white border-2 border-[var(--border-color)] p-6">
    <h3 class="font-bold mb-4 text-[var(--text-dark)]">Управление статьями:</h3>
    <div class="flex gap-4">
        <a href="<?php echo e(route('articles.create')); ?>" 
            class="px-6 py-3 bg-[var(--primary-pink)] text-white font-bold hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
            📝 Создать новую статью
        </a>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>



.pagination {
    display: flex;
    gap: 0.5rem;
}
.page-item.active .page-link {
    background-color: var(--primary-pink);
    border-color: var(--primary-pink);
    color: white;
}
.page-link {
    padding: 0.5rem 1rem;
    border: 2px solid var(--border-color);
    color: var(--text-dark);
}
.page-link:hover {
    background-color: #fff5f9;
    border-color: var(--primary-pink);
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/articles/index.blade.php ENDPATH**/ ?>